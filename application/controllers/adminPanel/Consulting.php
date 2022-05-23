<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Consulting extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'consulting';
    protected $title = 'consulting';
    protected $table = "inquiry";
    protected $redirect = "consulting";
    protected $access = ['Operation', 'Super Admin', 'Consultant'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['consultant'] = $this->main->getall('admins', 'id, name', ['is_blocked' => 0, 'is_deleted' => 0, 'role' => 'Consultant']);
        $data['ielts'] = $this->main->getall('admins', 'id, name', ['role' => 'IELTS Operation', 'is_blocked' => 0, 'is_deleted' => 0]);

        return $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('consulting_model'));
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


            if (in_array($this->role, ['Consultant'])){
                
                /*if (!$row->ielts)
                    $ielts = '<div class="table-display">'.form_open($this->redirect.'/ielts', ['id' => 'ielts'.e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fa fa-headphones"></i>','type'  => 'button','class' => 'btn btn-outline-warning', 'onclick' => "ielts(".e_id($row->id).")"]).form_close().'</div>';
                else
                    $ielts = '<div class="table-display">'.form_button([ 'content' => '<i class="fas fa-thumbs-up"></i>','type'  => 'button','class' => 'btn btn-outline-success']).'</div>';

                $sub_array[] = $ielts;*/

                if (!$row->cred_create)
                    $sub_array[] = '<div class="table-display">'.form_open($this->redirect.'/creds', ['id' => 'creds'.e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fa fa-id-card"></i>','type'  => 'button','class' => 'btn btn-outline-info', 'onclick' => "creds(".e_id($row->id).")"]).form_close().'</div>';
                else
                    $sub_array[] = '<div class="table-display">'.form_button([ 'content' => '<i class="fas fa-thumbs-up"></i>','type'  => 'button','class' => 'btn btn-outline-success']).'</div>';
                
                $sub_array[] = '<div class="table-display">'.anchor($this->redirect.'/upload/'.e_id($row->id).'/'.str_replace(' ', '-', $row->visa_type), '<i class="fa fa-image"></i>', 'class="btn btn-outline-secondary mr-2"').'</div>';
                
                $sub_array[] = '<div class="table-display">'.form_button([ 'content' => '<i class="fas fa-chart-line"></i>','type'  => 'button','class' => 'mr-2 btn btn-outline-primary', 'onclick' => "statusCheck(".e_id($row->id).")"]).'</div>';
            }

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';
            $action .= anchor($this->redirect.'/view_client/'.e_id($row->id).'/'.str_replace(' ', '-', $row->visa_type), '<i class="fa fa-print"></i> Print', ['class' => 'dropdown-item']);
            if (in_array($this->role, ['Consultant']))
            $action .= anchor($this->redirect.'/update_details/'.e_id($row->id).'/'.str_replace(' ', '-', $row->visa_type), '<i class="fa fa-edit"></i> Edit', ['class' => 'dropdown-item']);

            $action .= form_button([ 'content' => '<i class="fa fa-history"></i> History','type'  => 'button','class' => 'dropdown-item', 'onclick' => "viewHistory(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);

            if (in_array($this->role, ['Consultant'])) {
                /* $action .= form_button([ 'content' => '<i class="fas fa-user-plus"></i>','type'  => 'button','class' => 'dropdown-item', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-counselor"]); */
                $action .= form_button([ 'content' => '<i class="fas fa-user"></i> Assign Lead','type'  => 'button','class' => 'dropdown-item', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-consultant"]);
                $action .= anchor($this->redirect.'/fees/'.e_id($row->id), '<i class="fa fa-rupee-sign"></i>&nbsp Fees', ['class' => 'dropdown-item']);
            }

            $action .= '</div></div>';
            
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('consulting_model'), 'consulting');

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->consulting->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('consulting_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function consulting()
    {
        if (!$this->input->post('inquiry_id') || !$this->input->post('remarks')) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        
        $post = [
                'inq_id'     => d_id($this->input->post('inquiry_id')),
                'remarks'    => $this->input->post('remarks'),
                'created_by' => $this->id,
                'counselor'  => $this->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
        
        $id = $this->main->add($post, 'inquery_logs');

        if ($id)
            $this->main->update(['id' => $post['inq_id']], ['updated_at' => $post['created_at']], $this->table);

        flashMsg($id, "Remark Added Successfully.", "Remark Not Added. Try again.", $this->redirect);
    }

    public function ielts()
    {
        if (!$this->input->post('inquiry_id') || !$this->input->post('ielts')) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        $i_id = d_id($this->input->post('inquiry_id'));
        
        $id = $this->main->update(['id' => $i_id], ['ielts' => 1, 'updated_at' => date("Y-m-d H:i:s")], $this->table);

        if ($id){
            $log = [
                'inq_id'     => $i_id,
                'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : 'IELTS Enabled.',
                'created_by' => $this->id,
                'counselor'  => d_id($this->input->post('ielts')),
                'created_at' => date("Y-m-d H:i:s")
            ];
        
            $this->main->add($log, 'inquery_logs');
        }

        flashMsg($id, "IELTS Enabled Successfully.", "IELTS Not Enabled. Try again.", $this->redirect);
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