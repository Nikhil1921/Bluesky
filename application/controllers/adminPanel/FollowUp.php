<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FollowUp extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access))
            return redirect(admin('unauthorized'));
    }

	protected $name = 'followUp';
    protected $title = 'follow Up';
    protected $redirect = "followUp";
    protected $table = "follow_ups";
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
        $data['counselors'] = $this->main->getall('admins', 'id, name', ['role' => 'Counselor', 'is_blocked' => 0, 'is_deleted' => 0]);
        $data['lms'] = $this->main->getall('admins', 'id, name', "is_blocked = 0 AND is_deleted = 0 AND (role = 'LMS Employee' OR role = 'Reception')");
        $data['ielts'] = $this->main->getall('admins', 'id, name', ['role' => 'IELTS Operation', 'is_blocked' => 0, 'is_deleted' => 0]);

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('followup_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = date('d-m-Y', strtotime($row->follow_date));
            $sub_array[] = date('h:i A', strtotime($row->follow_time));
            $sub_array[] = date('d-m-Y h:i A', strtotime($row->created_at));
            $sub_array[] = $row->status;
            $sub_array[] = $row->remarks;
            // $sub_array[] = '<div class="table-display">'.form_open($this->redirect.'/ielts-approve', ['id' => 'ielts'.e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fa fa-headphones"></i>','type'  => 'button','class' => 'btn btn-outline-warning', 'onclick' => "ielts(".e_id($row->id).")"]).form_close().'</div>';
            
            $action = '<div class="ml-0 table-display ">';
            
            $action .= '<div class="table-display">'.form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'onclick' => "viewFollowUps(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#follow-ups"]).'</div>';
            
            if (in_array($this->role, ['LMS Employee', 'Reception']))
                $action .= form_button([ 'content' => '<i class="fa fa-user-plus"></i>','type'  => 'button','class' => 'btn btn-outline-primary mr-2', 'onclick' => "assign(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#add-follow-up"]).form_button([ 'content' => '<i class="fas fa-user"></i>','type'  => 'button','class' => 'mr-2 btn btn-outline-primary', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-counselor"]);

            $action .= '</div>';
            $sub_array[] = $action;

            $data[] = $sub_array;
            $sr++;
        }

        $this->load->model(admin('followup_model'), 'follow');

        $output = array(  
            "draw"             => intval($_POST["draw"]),
            "recordsTotal"     => $this->follow->count(),
            "recordsFiltered"  => $this->main->get_filtered_data(admin('followup_model')),
            "data"             => $data
        );
        
        echo json_encode($output);
    }

    public function follow()
    {
        if (!$this->input->post('lead_id')) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);

        $date = date('Y-m-d H:i:s');
        $follow = [
                'lead_id'     => d_id($this->input->post('lead_id')),
                'remarks'     => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                'follow_date' => date('Y-m-d', strtotime($this->input->post('follow_date'))),
                'follow_time' => date('H:i:s', strtotime($this->input->post('follow_time'))),
                'status'      => $this->input->post('follow'),
                'created_by'  => $this->id,
                'created_at'  => $date
            ];

        $id = $this->main->add($follow, $this->table);

        if ($id && $follow['status'] !== 'Follow Up') {
            $this->main->update(['lead_id' => $follow['lead_id']], ['is_closed' => 1], 'follow_ups');
            $this->main->update(['id' => $follow['lead_id']], ['is_archived' => 1, 'updated_at' => $date], 'inquiry');
        }

        flashMsg($id, ucwords($this->title)." Successfully.", ucwords($this->title)." Not Successful. Try again.", $this->redirect);
    }

    public function counselor()
    {
        if (!$this->input->post('lead_id') || (!$this->input->post('counselor') && !$this->input->post('ielts'))) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        
        $lead_id = d_id($this->input->post('lead_id'));
        $date = date('Y-m-d H:i:s');
        $update = [
                    'is_archived' => 1, 
                    'ielts'       => ($this->input->post('ielts')) ? 1 : 0,
                    'updated_at'  => $date
                ];

        $emp = ($this->input->post('ielts')) ? $this->input->post('ielts') : $this->input->post('counselor');

        $id = $this->main->update(['id' => $lead_id], $update, 'inquiry');

        if ($id) {
            $follow = [
                    'lead_id'     => $lead_id,
                    'remarks'     => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                    'follow_date' => date('Y-m-d'),
                    'follow_time' => date('H:i:s', strtotime($date)),
                    'status'      => $this->input->post('ielts') ? "Assigned To IELTS" : "Assigned To Counselor",
                    'created_by'  => $this->id,
                    'created_at'  => $date
                ];
            
            $this->main->add($follow, $this->table);

            $this->main->update(['lead_id' => $lead_id], ['is_closed' => 1], $this->table);

            $inq = [
                    'inq_id'      => $lead_id,
                    'created_by'  => $this->id,
                    'counselor'   => d_id($emp),
                    'remarks'     => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                    'created_at'  => $date
                ];

            $this->main->add($inq, 'inquery_logs');
        }

        flashMsg($id, ucwords($this->title)." Successfully.", ucwords($this->title)." Not Successful. Try again.", $this->redirect);
    }

    public function ielts_approve()
    {
        if (!$this->input->post('id')) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        
        $lead_id = d_id($this->input->post('id'));
        $date = date('Y-m-d H:i:s');
        $id = $this->main->update(['id' => $lead_id], ['is_archived' => 1, 'updated_at' => $date], 'inquiry');
        if ($id) {
            $follow = [
                    'lead_id'     => $lead_id,
                    'remarks'     => "Assigned to IELTS",
                    'follow_date' => date('Y-m-d'),
                    'follow_time' => date('H:i:s', strtotime($date)),
                    'status'      => "Assigned To IELTS",
                    'created_by'  => $this->id,
                    'created_at'  => $date
                ];
            
            $this->main->add($follow, $this->table);

            $this->main->update(['lead_id' => $lead_id], ['is_closed' => 1], $this->table);

            $inq = [
                    'inq_id'      => $lead_id,
                    'created_by'  => $this->id,
                    'counselor'   => $this->id,
                    'remarks'     => 'Assigned to IELTS',
                    'created_at'  => $date
                ];

            $this->main->add($inq, 'inquery_logs');
        }
        
        flashMsg($id, ucwords($this->title)." Successfully.", ucwords($this->title)." Not Successful. Try again.", $this->redirect);
    }
}