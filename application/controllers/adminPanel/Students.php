<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'students';
    protected $title = 'student';
    protected $table = "inquiry";
    protected $redirect = "students";
    protected $access = ['Operation', 'Super Admin', 'IELTS Coaching'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['consultant'] = $this->main->getall('admins', 'id, name', ['is_blocked' => 0, 'is_deleted' => 0, 'role' => 'IELTS Coaching']);

        return $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('students_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = ($row->grammer) ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>' ;
            $sub_array[] = $row->batch_name;

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';

            $action .= form_button([ 'content' => '<i class="fa fa-history"></i> History','type'  => 'button','class' => 'dropdown-item', 'onclick' => "viewAttendance(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);

            $action .= '</div></div>';
            
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('students_model'), 'students');

        $output = [
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => $this->students->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('students_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function viewAttendance()
    {
        if (!$this->input->is_ajax_request()) 
           return $this->error_404();
        else{
            $this->load->model(admin('students_model'), 'students');
            $data['history'] = $this->students->viewAttendance();
            
            return $this->load->view($this->redirect.'/attendance', $data);
        }
    }
}