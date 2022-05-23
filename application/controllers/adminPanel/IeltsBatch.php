<?php defined('BASEPATH') OR exit('No direct script access allowed');

class IeltsBatch extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'ieltsBatch';
    protected $title = 'ielts Batch';
    private $table = "ielts_batch";
    protected $redirect = "ieltsBatch";
    protected $access = ['Operation', 'Super Admin', 'IELTS Operation', 'IELTS Coaching'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['dataTables'] = TRUE;
        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('ielts_batch_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->batch_name;
            $sub_array[] = date('d-m-Y', strtotime($row->from_date));
            $sub_array[] = date('d-m-Y', strtotime($row->to_date));
            $sub_array[] = date('h:i A', strtotime($row->from_time));
            $sub_array[] = date('h:i A', strtotime($row->to_time));
            
            if (!in_array($this->role, ['Operation', 'Super Admin', 'IELTS Coaching']))
                $sub_array[] = ucfirst($row->name);

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';

            $action .= form_button([ 'content' => '<i class="fa fa-users"></i> Batch Details','type'  => 'button','class' => 'dropdown-item', 'onclick' => "viewBatch(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#ielts-batch"]);
            
            if (in_array($this->role, ['IELTS Coaching']))
                $action .= form_button([ 'content' => '<i class="fa fa-user-check"></i> Batch Attendance','type'  => 'button','class' => 'dropdown-item', 'onclick' => "makeAttendance(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#make-attendance"]);
            
            if (!in_array($this->role, ['IELTS Coaching']))
                $action .= anchor($this->redirect.'/update/'.e_id($row->id), '<i class="fa fa-edit"></i> Edit', 'class="dropdown-item"').form_open($this->redirect.'/delete', ['id' => e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fas fa-trash"></i>&nbsp Delete','type'  => 'button','class' => 'dropdown-item', 'onclick' => "remove(".e_id($row->id).")"]).form_close();

            $action .= '</div></div>';

            $sub_array[] = $action;

            $data[] = $sub_array;
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, ['is_deleted' => 0]),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('ielts_batch_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        );
        
        echo json_encode($output);
    }

    public function add()
	{
        $this->form_validation->set_rules($this->validate);
        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "add";
            $data['url'] = $this->redirect;
            $data['daterangepicker'] = TRUE;
        	$data['select'] = TRUE;
        	$data['coachs'] = $this->main->getall('admins', 'id, name', ['is_blocked' => 0, 'is_deleted' => 0, 'role' => 'IELTS Coaching']);

            return $this->template->load(admin('template'), $this->redirect.'/add', $data);
        }
        else
        {
        	$post = [
                'batch_name' => $this->input->post('batch_name'),
                'from_date'  => date('Y-m-d', strtotime($this->input->post('from_date'))),
                'from_time'  => date('H:i:s', strtotime($this->input->post('from_time'))),
                'to_date'    => date('Y-m-d', strtotime($this->input->post('to_date'))),
                'to_time'    => date('H:i:s', strtotime($this->input->post('to_time'))),
                'coach_id'   => d_id($this->input->post('coach_id'))
            ];
            
        	$id = $this->main->add($post, $this->table);

        	flashMsg($id, ucwords($this->title)." Added Successfully.", ucwords($this->title)." Not Added. Try again.", $this->redirect);
        }
	}

	public function update($id)
	{
        $this->form_validation->set_rules($this->validate);
        
        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['id'] = $id;
			$data['title'] = $this->title;
			$data['operation'] = "update";
	        $data['daterangepicker'] = TRUE;
        	$data['select'] = TRUE;
            $data['url'] = $this->redirect;
            $data['data'] = $this->main->get($this->table, 'batch_name, from_date, to_date, from_time, to_time, coach_id', ['id' => d_id($id)]);
			
			if ($data['data']) 
			{
        		$data['coachs'] = $this->main->getall('admins', 'id, name', ['is_blocked' => 0, 'is_deleted' => 0, 'role' => 'IELTS Coaching']);
				$this->session->set_flashdata('updateId', $id);
				return $this->template->load(admin('template'), $this->redirect.'/update', $data);
			}
			else
				return $this->error_404();
        }
        else
        {
        	$updateId = $this->session->updateId;
            
        	$post = [
                'batch_name' => $this->input->post('batch_name'),
                'from_date'  => date('Y-m-d', strtotime($this->input->post('from_date'))),
                'from_time'  => date('H:i:s', strtotime($this->input->post('from_time'))),
                'to_date'    => date('Y-m-d', strtotime($this->input->post('to_date'))),
                'to_time'    => date('H:i:s', strtotime($this->input->post('to_time'))),
                'coach_id'   => d_id($this->input->post('coach_id'))
            ];

        	$id = $this->main->update(['id' => d_id($updateId)], $post, $this->table);

			flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
        }
	}

	public function delete()
	{
        $id = $this->main->update(['id' => d_id($this->input->post('id'))], ['is_deleted' => 1], $this->table);

		flashMsg($id, ucwords($this->title)." Deleted Successfully.", ucwords($this->title)." Not Deleted. Try again.", $this->redirect);
	}

    public function makeAttendance()
    {
        if (!$this->input->is_ajax_request()) 
           return $this->error_404();
        else{
            $this->load->model(admin('inquiry_model'), 'inquiry');
            $data['users'] = $this->inquiry->viewBatch();
            $data['id'] = $this->input->post('id');
            
            return $this->load->view(admin('ieltsBatch/attendance'), $data);
        }
    }

    public function saveAttendance()
    {
        if (!$this->input->is_ajax_request()) 
           return $this->error_404();
        else{
            $this->load->model(admin('inquiry_model'), 'inquiry');
            $users = $this->inquiry->viewBatch();
            $pre = ($this->input->post('present')) ? $this->input->post('present') : [];
            $batch_id = d_id($this->input->post('id'));
            $insert = [];
            foreach ($users as $k => $v)
                if (in_array(e_id($v['id']), $pre))
                    $insert[$k] = ['att_date' => date('Y-m-d'), 'created_at' => date('Y-m-d H:i:s'), 'attendance' => 'Present', 'stu_id' => $v['id'], 'coach_id' => $this->id, 'batch_id' => $batch_id];
                else
                    $insert[$k] = ['att_date' => date('Y-m-d'), 'created_at' => date('Y-m-d H:i:s'), 'attendance' => 'Absent', 'stu_id' => $v['id'], 'coach_id' => $this->id, 'batch_id' => $batch_id];
            if ($insert)
                $id = $this->main->import_excel($insert, 'attendance');
            else
                $id = 0;
            $response =  ($id) ? ['title' => 'Success', 'text' => 'Attendance success.', 'icon' => 'success'] : ['title' => 'Error', 'text' => 'Attendance not success.', 'icon' => 'error'];
            if ($id)
                $this->main->add(['created_by' => $this->id, 'created_at' => date('Y-m-d H:i:s'), 'remarks' => 'Attendance added.'], 'coach_logs');
            echo json_encode($response); die;
        }
    }

    protected $validate = [
        [
            'field' => 'batch_name',
            'label' => 'Batch Name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'coach_id',
            'label' => 'Coach',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'from_date',
            'label' => 'From Date',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'from_time',
            'label' => 'From Time',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'to_date',
            'label' => 'To Date',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'to_time',
            'label' => 'To Time',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}