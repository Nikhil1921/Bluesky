<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Installment extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'installment';
    protected $title = 'fees installment';
    protected $table = "inquiry";
    protected $redirect = "installment";
    protected $access = ['Super Admin', 'Accountant', 'Consultant'];

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
        $fetch_data = $this->main->make_datatables(admin('installment_model'));
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

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';
            
            $action .= form_button([ 'content' => '<i class="fa fa-history"></i>&nbsp History','type'  => 'button','class' => 'dropdown-item', 'onclick' => "viewFees(".e_id($row->id).")"]);
            
            if (in_array($this->role, ['Accountant'])):
                $action .= anchor($this->redirect.'/fees/'.e_id($row->id), '<i class="fa fa-rupee-sign"></i>&nbsp&nbsp Collect Fees', ['class' => 'dropdown-item']);
            endif;
            if (in_array($this->role, ['Accountant', 'Consultant'])):
                $action .= anchor($this->redirect.'/installment/'.e_id($row->id), '<i class="fa fa-credit-card"></i> Installments', ['class' => 'dropdown-item']);
            endif;
            if (in_array($this->role, ['Consultant'])):
                $action .= anchor($this->redirect.'/installmentChange/'.e_id($row->id), '<i class="fa fa-credit-card"></i> Change Installment', ['class' => 'dropdown-item']);
            endif;

            $action .= '</div></div>';
            
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('installment_model'), 'fees');

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->fees->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('installment_model')),
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

    public function installment($id)
    {
    	$validate = [
                [
                    'field' => 'fees_collect',
                    'label' => 'Fees',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => "%s is Required",
                        'numeric' => "%s is Invalid"
                    ],
                ],
                [
                    'field' => 'fees_date',
                    'label' => 'Fees Date',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "%s is Required"
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
            $data['daterangepicker'] = true;
            $data['data'] = $this->main->get($this->table, '(fees + ielts_fees) ielts_fees', ['id' => d_id($id)]);
    
            $data['installments'] = $this->main->getall('installment', 'fees, remarks, created_at, fees_date, status', ['inq_id' => d_id($id)]);
            
            if ($data['data'])
                return $this->template->load(admin('template'), $this->redirect.'/installment', $data);
            else
                return $this->error_404();
        }else{
        	$post = [
                'inq_id'     => d_id($id),
                'fees'       => $this->input->post('fees_collect'),
                'fees_date'  => date("Y-m-d", strtotime($this->input->post('fees_date'))),
                'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                'created_by' => $this->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
            
            $aid = $this->main->add($post, 'installment');

            if ($aid) {
                $post = [
                    'inq_id'     => d_id($id),
                    'remarks'    => "Fees installment.",
                    'created_by' => $this->id,
                    'counselor'  => $this->id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            
                $this->main->add($post, 'inquery_logs');

                $uid = $this->main->update(['id' => d_id($id)], ['updated_at' => $post['created_at']], $this->table);
            }

            flashMsg($uid, "Fees Installment Added Successfully.", "Fees Installment Not Added. Try again.", $this->redirect.'/installment/'.$id);
        }
    }

    public function installmentChange($id)
    {
        $validate = [
                [
                    'field' => 'fees_date',
                    'label' => 'Date Of Installment',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "%s is Required"
                    ],
                ]
        ];

        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "fees";
            $data['id'] = $id;
            $data['url'] = $this->redirect;
            $data['daterangepicker'] = true;
            $data['multipledaterange'] = true;
            $data['installments'] = $this->main->getall('installment', 'id, fees, remarks, created_at, fees_date', ['inq_id' => d_id($id)]);
            
            if ($data['installments'])
                return $this->template->load(admin('template'), $this->redirect.'/installmentChange', $data);
            else
                return $this->error_404();
        }else{
            $post = [
                'fees_date'  => date("Y-m-d", strtotime($this->input->post('fees_date')))
            ];
            
            $aid = $this->main->update(['id' => d_id($this->input->post('fee_id')), 'inq_id'     => d_id($id)], $post, 'installment');

            if ($aid) {
                $log = [
                    'inq_id'     => d_id($id),
                    'remarks'    => "Fees installment updated.",
                    'created_by' => $this->id,
                    'counselor'  => $this->id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            
                $this->main->add($log, 'inquery_logs');

                $this->main->update(['id' => d_id($id)], ['updated_at' => $log['created_at']], $this->table);
            }

            flashMsg($aid, "Fees Installment Added Successfully.", "Fees Installment Not Added. Try again.", $this->redirect.'/installmentChange/'.$id);
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