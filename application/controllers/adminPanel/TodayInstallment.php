<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TodayInstallment extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'todayInstallment';
    protected $title = 'today\'s installment';
    protected $redirect = "todayInstallment";
    protected $table = "inquiry";
    protected $access = ['Super Admin', 'Accountant'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;

        return $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('today_installment_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = $row->fees;

            $action = '<div class="ml-0 table-display row">';

            $action .= form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'onclick' => "viewFees(".e_id($row->id).")"]);
            if (in_array($this->role, ['Accountant'])):
                $action .= anchor($this->redirect.'/fees/'.e_id($row->id), '<i class="fa fa-rupee-sign"></i>', ['class' => 'btn btn-outline-primary mr-2']);
            endif;

            $action .= '</div>';
            
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('today_installment_model'), 'fees');

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->fees->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('today_installment_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function viewFees($id)
    {
    	if (!$this->input->is_ajax_request()) 
            return $this->error_404();
        else{
            $this->load->model(admin('fees_model'));
            $data['history'] = $this->fees_model->viewFees($id);
            
            return $this->load->view(admin('fees/history'), $data);
        }
    }

    public function fees($id)
    {
        $validate = [
                [
                    'field' => 'fees_collect',
                    'label' => 'Fees Collect',
                    'rules' => 'required|numeric|callback_fees_check',
                    'errors' => [
                        'required' => "%s is Required",
                        'numeric' => "%s is Invalid"
                    ],
                ]
        ];
        
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "fees";
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['data'] = $this->main->get($this->table, '(fees + ielts_fees) ielts_fees', ['id' => d_id($id)]);
    
            $data['fees'] = $this->main->getall('fee_logs', 'fees, remarks, created_at', ['inq_id' => d_id($id)]);
            
            if ($data['data'])
                return $this->template->load(admin('template'), admin('fees/fees'), $data);
            else
                return $this->error_404();
        }
        else
        {
            $post = [
                'inq_id'     => d_id($id),
                'fees'       => $this->input->post('fees_collect'),
                'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                'created_by' => $this->id,
                'fee_type'   => $this->input->post('fee_type'),
                'pay_type'   => $this->input->post('pay_type'),
                'created_at' => date("Y-m-d H:i:s")
            ];
            
            $aid = $this->main->add($post, 'fee_logs');

            if ($aid) {
                $post = [
                    'inq_id'     => d_id($id),
                    'remarks'    => "Fees collection.",
                    'created_by' => $this->id,
                    'counselor'  => $this->id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            
                $this->main->add($post, 'inquery_logs');
                $this->main->update(['inq_id' => d_id($id), 'fees_date' => date("Y-m-d")], 
                    ['status' => 'Collected'], 'installment');

                $uid = $this->main->update(['id' => d_id($id)], ['updated_at' => $post['created_at']], $this->table);
            }

            flashMsg($uid, "Fees Added Successfully.", "Fees Not Added. Try again.", $this->redirect);
        }
    }
}