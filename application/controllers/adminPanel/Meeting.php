<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'meeting';
    protected $title = 'meeting';
    private $table = "meeting";
    protected $redirect = "meeting";
    protected $access = ['Operation', 'Super Admin', 'Reception'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['counselors'] = $this->main->getall('admins', 'id, name', ['role' => 'Counselor', 'is_blocked' => 0, 'is_deleted' => 0]);
        $data['ielts'] = $this->main->getall('admins', 'id, name', ['role' => 'IELTS Operation', 'is_blocked' => 0, 'is_deleted' => 0]);

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('meeting_model'));
        $sr = $_POST['start'] + 1;
        $data = array();
        
        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = date('d-m-Y h:i A', strtotime($row->meeting_date));

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';

            $action .= form_button([ 'content' => '<i class="fa fa-history"></i> History','type'  => 'button','class' => 'dropdown-item', 'onclick' => "viewHistory(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);
            
            if (in_array($this->role, ['Reception']))
                $action .= form_button([ 'content' => '<i class="fas fa-user"></i> Assign Inquiry','type'  => 'button','class' => 'dropdown-item', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-counselor"]);

            $action .= '</div></div>';
            
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('meeting_model'), 'inquiry');

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->inquiry->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('meeting_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function counselor()
    {
        if (!$this->input->post('inquiry_id') || (!$this->input->post('counselor') && !$this->input->post('ielts'))) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        
        $emp = ($this->input->post('ielts')) ? $this->input->post('ielts') : $this->input->post('counselor');

        $post = [
                'inq_id'     => d_id($this->input->post('inquiry_id')),
                'created_by' => $this->id,
                'counselor'  => d_id($emp),
                'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                'created_at' => date("Y-m-d H:i:s")
            ];
        
        $id = $this->main->add($post, 'inquery_logs');
        
        if ($id)
            $this->main->update(['id' => $post['inq_id']], ['updated_at' => $post['created_at']], 'inquiry');

        flashMsg($id, "Inquiry Assigned Successfully.", "Inquiry Not Assigned. Try again.", $this->redirect);
    }
}