<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fees extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'fees';
    protected $title = 'fees collection';
    protected $table = "inquiry";
    protected $redirect = "fees";
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
        $fetch_data = $this->main->make_datatables(admin('fees_model'));
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
            $sub_array[] = $row->ielts_fees;
            $sub_array[] = $row->remain_fees;
            $sub_array[] = $row->pay_type;

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';
            
            $action .= form_button([ 'content' => '<i class="fa fa-history"></i>&nbsp History','type'  => 'button','class' => 'dropdown-item', 'onclick' => "viewFees(".e_id($row->id).")"]);
            
            if (in_array($this->role, ['Accountant'])):
                $action .= anchor($this->redirect.'/fees/'.e_id($row->id), '<i class="fa fa-rupee-sign"></i> Collect Fees', ['class' => 'dropdown-item']);
                $action .= anchor($this->redirect.'/print/'.e_id($row->id), '<i class="fa fa-print"></i> Print Invoice', ['class' => 'dropdown-item']);
            endif;

            $action .= '</div></div>';
            
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('fees_model'), 'fees');

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->fees->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('fees_model')),
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
            
            return $this->load->view($this->redirect.'/history', $data);
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
                return $this->template->load(admin('template'), $this->redirect.'/fees', $data);
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
                'gst'        => $this->input->post('fees_gst') ? $this->input->post('fees_gst') : 0,
                'gst_no'     => $this->input->post('gst_no') ? $this->input->post('gst_no') : "NA",
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

    public function print($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "fees";
        $data['url'] = $this->redirect;
        $data['id'] = $id;

        $data['fees'] = $this->main->getall('fee_logs', 'id, fees, remarks, created_at, fee_type, gst, gst_no', ['inq_id' => d_id($id)]);
        
        if ($data['fees'])
            return $this->template->load(admin('template'), $this->redirect.'/print', $data);
        else
            return $this->error_404();
    }

    public function invoice($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "fees";
        $data['url'] = $this->redirect;
        $data['id'] = $id;
        $data['fees'] = $this->main->get('fee_logs', 'fees, remarks, created_at, fee_type, gst, gst_no, inq_id', ['id' => d_id($id)]);
        $data['data'] = $this->main->get($this->table, 'name, mobile, email, (fees + ielts_fees) ielts_fees', ['id' => $data['fees']['inq_id']]);
        
        if ($data['data'] && $data['fees'])
            return $this->template->load(admin('template'), $this->redirect.'/invoice', $data);
        else
            return $this->error_404();
    }
}