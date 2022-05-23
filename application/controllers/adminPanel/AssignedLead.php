<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AssignedLead extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'assignedLead';
    protected $title = 'lead';
    protected $table = "inquiry";
    protected $redirect = "assignedLead";
    protected $access = ['Operation', 'Super Admin', 'LMS', 'LMS Employee', 'Reception'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['select'] = TRUE;
        $data['lms'] = $this->main->getall('admins', 'id, name', "is_blocked = 0 AND is_deleted = 0 AND (role = 'LMS Employee' OR role = 'Reception')");

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('lead_model'));
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

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';

            $action .= form_button([ 'content' => '<i class="fa fa-history"></i> History','type'  => 'button','class' => 'dropdown-item', 'onclick' => "viewFollowUps(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);
            
            if (in_array($this->role, ['LMS Employee', 'Reception']))
                $action .= form_button([ 'content' => '<i class="fa fa-user-plus"></i>','type'  => 'button','class' => 'dropdown-item', 'onclick' => "assign(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#add-follow-up"]).anchor($this->redirect.'/update_details/'.e_id($row->id).'/'.str_replace(' ', '-', $row->visa_type), '<i class="fa fa-edit"></i> Edit', ['class' => 'dropdown-item']).anchor($this->redirect.'/visa_type/'.e_id($row->id), '<i class="fa fa-globe"></i> Change country', ['class' => 'dropdown-item']);

            $action .= '</div></div>';
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('lead_model'));

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->lead_model->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('lead_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function meeting()
    {
        if (!$this->input->post('lead_id')) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        $lead_id = d_id($this->input->post('lead_id'));
        $date = date('Y-m-d H:i:s');
        $meeting = [
                    'lead_id'      => $lead_id,
                    'remarks'      => $this->input->post('remarks'),
                    'meeting_date' => date('Y-m-d', strtotime($this->input->post('meeting_date'))),
                    'meeting_time' => date('H:i:s', strtotime($this->input->post('meeting_time'))),
                    'created_by'   => $this->id,
                    'created_at'   => $date
                ];
        if ($id = $this->main->add($meeting, 'meeting'))
        {
            $inq = [
                    'inq_id'      => $lead_id,
                    'created_by'  => $this->id,
                    'counselor'   => $this->id,
                    'remarks'     => 'Meeting arranged',
                    'created_at'  => $date
                ];
            $this->main->update(['id' => $lead_id], ['updated_at' => $date], $this->table);
            $this->main->add($inq, 'inquery_logs');
        }
        
        flashMsg($id, "Meeting Successfully.", "Meeting Not Successful. Try again.", $this->redirect);
    }
}