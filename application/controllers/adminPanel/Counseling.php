<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Counseling extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'counseling';
    protected $title = 'counseling';
    protected $table = "inquiry";
    protected $redirect = "counseling";
    protected $access = ['Operation', 'Super Admin', 'Counselor'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['counselers'] = $this->main->getall('admins', 'id, name', ['is_blocked' => 0, 'is_deleted' => 0, 'role' => 'Counselor']);
        $data['consultant'] = $this->main->getall('admins', 'id, name', ['is_blocked' => 0, 'is_deleted' => 0, 'role' => 'Consultant']);
        $data['ielts'] = $this->main->getall('admins', 'id, name', ['role' => 'IELTS Operation', 'is_blocked' => 0, 'is_deleted' => 0]);

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('counseling_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = date('d-m-Y', strtotime($row->created_at));
            $sub_array[] = date('d-m-Y h:i A', strtotime($row->updated_at));
            $sub_array[] = ucwords($row->country_name);
            $sub_array[] = ucwords($row->visa_type);
            $sub_array[] = ucfirst($row->reference);
            $sub_array[] = $row->client_type;


            if (in_array($this->role, ['Counselor'])){
                
            /*    if (!$row->ielts)
                    $ielts = '<div class="table-display">'.form_open($this->redirect.'/ielts', ['id' => 'ielts'.e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fa fa-headphones"></i>','type'  => 'button','class' => 'btn btn-outline-warning', 'onclick' => "ielts(".e_id($row->id).")"]).form_close().'</div>';
                else
                    $ielts = '<div class="table-display">'.form_button([ 'content' => '<i class="fas fa-thumbs-up"></i>','type'  => 'button','class' => 'btn btn-outline-success']).'</div>';

                $sub_array[] = $ielts;*/

                if (!$row->cred_create)
                    $sub_array[] = '<div class="table-display">'.form_open($this->redirect.'/creds', ['id' => 'creds'.e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fa fa-id-card"></i>','type'  => 'button','class' => 'btn btn-outline-info', 'onclick' => "creds(".e_id($row->id).")"]).form_close().'</div>';
                else
                    $sub_array[] = '<div class="table-display">'.form_button([ 'content' => '<i class="fas fa-thumbs-up"></i>','type'  => 'button','class' => 'btn btn-outline-success']).'</div>';
            }

            $action = '<div class="ml-0 table-display row">';
            $action .= anchor($this->redirect.'/view_client/'.e_id($row->id).'/'.str_replace(' ', '-', $row->visa_type), '<i class="fa fa-eye"></i>', ['class' => 'btn btn-outline-success mr-2']);
            if (in_array($this->role, ['Counselor']))
                $action .= anchor($this->redirect.'/update_details/'.e_id($row->id).'/'.str_replace(' ', '-', $row->visa_type), '<i class="fa fa-edit"></i>', ['class' => 'btn btn-outline-primary mr-2']);

            $action .= form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'onclick' => "viewHistory(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);

            if (in_array($this->role, ['Counselor'])) {
                $action .= form_button([ 'content' => '<i class="fas fa-user-plus"></i>','type'  => 'button','class' => 'mr-2 btn btn-outline-primary', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-counselor"]);
                $action .= form_button([ 'content' => '<i class="fas fa-user"></i>','type'  => 'button','class' => 'mr-2 btn btn-outline-primary', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-consultant"]);
                $action .= anchor($this->redirect.'/fees/'.e_id($row->id), '<i class="fa fa-rupee-sign"></i>', ['class' => 'btn btn-outline-primary mr-2']);
            }

            $action .= '</div>';
            
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('counseling_model'), 'counseling');

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->counseling->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('counseling_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function counseling()
    {
        $post = [
                'inq_id'     => d_id($this->input->post('inquiry_id')),
                'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                'created_by' => $this->id,
                'counselor'  => $this->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
        
        $id = $this->main->add($post, 'inquery_logs');

        if ($id)
            $this->main->update(['id' => $post['inq_id']], ['updated_at' => $post['created_at']], $this->table);

        flashMsg($id, "Remark Added Successfully.", "Remark Not Added. Try again.", $this->redirect);
    }

    public function consult()
    {
        if (!$this->input->post('inquiry_id') || (!$this->input->post('consultant') && !$this->input->post('ielts')))
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        
        $emp = ($this->input->post('ielts')) ? $this->input->post('ielts') : $this->input->post('consultant');

        $post = [
                'inq_id'     => d_id($this->input->post('inquiry_id')),
                'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                'created_by' => $this->id,
                'counselor'  => d_id($emp),
                'created_at' => date("Y-m-d H:i:s")
            ];
        
        $id = $this->main->add($post, 'inquery_logs');

        if ($id)
            $this->main->update(['id' => $post['inq_id']], ['updated_at' => $post['created_at'], 'ielts' => ($this->input->post('ielts')) ? 1 : 0], $this->table);

        flashMsg($id, "Inquiry Assigned Successfully.", "Inquiry Not Assigned. Try again.", $this->redirect);
    }

    public function update_fees($id)
    {
        $validate = [
            [
                'field' => 'fees',
                'label' => 'Fees',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => "%s is Required",
                    'numeric' => "%s is Invalid"
                ]
            ]
        ];
        
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE)
            return $this->fees($id);
        else{
            $fees = $this->input->post('fees');
            $uid = $this->main->update(['id' => d_id($id)], ['fees' => $fees, 'updated_at' => date("Y-m-d H:i:s")], $this->table);
           
            if ($uid) {
                $post = [
                    'inq_id'     => d_id($id),
                    'remarks'    => "Fees updated.",
                    'created_by' => $this->id,
                    'counselor'  => $this->id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            
                $this->main->add($post, 'inquery_logs');
            }

            flashMsg($uid, "Fees Updated Successfully.", "Fees Not Updated. Try again.", $this->redirect.'/fees/'.$id);
        }
    }

    public function fees($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "fees";
        $data['url'] = $this->redirect;
        $data['id'] = $id;
        $data['data'] = $this->main->get($this->table, 'fees ielts_fees', ['id' => d_id($id)]);

        $data['fees'] = $this->main->getall('fee_logs', 'fees, remarks, created_at', ['inq_id' => d_id($id), 'fee_type' => 'Consultancy']);
        
        if ($data['data'])
            return $this->template->load(admin('template'), admin('ielts/fees'), $data);
        else
            return $this->error_404();
    }
}