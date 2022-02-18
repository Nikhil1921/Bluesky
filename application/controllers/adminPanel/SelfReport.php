<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SelfReport extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'selfReport';
    protected $title = 'Assigned';
    protected $table = "inquiry";
    protected $redirect = "selfReport";
    protected $access = ['LMS Employee', 'Reception'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['select'] = TRUE;

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('self_report_model'));
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
            $sub_array[] = ucwords($row->country_name);
            $sub_array[] = ucwords($row->visa_type);
            $sub_array[] = ucwords($row->employee);
            $sub_array[] = $row->remarks;

            $action = '<div class="ml-0 table-display row">'.form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'onclick' => "viewFollowUps(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);
            
            $action .= '</div>';
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('self_report_model'));

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->self_report_model->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('lead_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }
}