<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'report';
    protected $title = 'report';
    private $table = "admins";
    protected $redirect = "report";
    protected $access = ['Operation', 'Super Admin', 'LMS', 'IELTS Operation'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('users_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = $row->role;

            $action = '<div class="ml-0 table-display row">';
            
            if (in_array($row->role, ['Reception', 'Counselor', 'Consultant', 'IELTS Operation'])) 
            	$action .= anchor($this->redirect.'/inquiry/'.e_id($row->id), '<i class="fa fa-question-circle"></i>', 'class="btn btn-outline-info mr-2"');
            
            if (in_array($row->role, ['Reception', 'LMS', 'LMS Employee'])) 
                $action .= anchor($this->redirect.'/leads/'.e_id($row->id), '<i class="fa fa-user"></i>', 'class="btn btn-outline-info mr-2"');

            if (in_array($row->role, ['IELTS Coaching']))
                $action .= anchor($this->redirect.'/coaching/'.e_id($row->id), '<i class="fa fa-user"></i>', 'class="btn btn-outline-info mr-2"');

            $action .= '</div>';
            $sub_array[] = $action;
            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();  
        
        if (in_array($this->role, ['LMS']))
            $where = ['is_deleted' => 0, 'role' => 'LMS Employee'];
        else if (in_array($this->role, ['IELTS Operation']))
            $where = ['is_deleted' => 0, 'role' => 'IELTS Coaching'];
        else
            $where = ['is_deleted' => 0, 'role != ' => 'Super Admin'];

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, $where),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('users_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        );
        
        echo json_encode($output);
    }

	public function coaching($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "coaching report";
        $data['url'] = $this->redirect;
        $data['getCoaching'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['id'] = $id;
        $data['data'] = $this->main->get($this->table, 'name, mobile, email, role', ['id' => d_id($id)]);

        if ($data['data']) 
            return $this->template->load(admin('template'), $this->redirect.'/coaching', $data);
        else
            return $this->error_404();
    }

    public function inquiry($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "inquiry report";
        $data['url'] = $this->redirect;
        $data['getInqury'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['id'] = $id;
        $data['data'] = $this->main->get($this->table, 'name, mobile, email, role', ['id' => d_id($id)]);

        if ($data['data']) 
            return $this->template->load(admin('template'), $this->redirect.'/inquiry', $data);
        else
            return $this->error_404();
    }

    public function leads($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "lead report";
        $data['url'] = $this->redirect;
        $data['getFollowup'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['id'] = $id;
        $data['data'] = $this->main->get($this->table, 'name, mobile, email, role', ['id' => d_id($id)]);

        if ($data['data'])
            return $this->template->load(admin('template'), $this->redirect.'/leads', $data);
        else
            return $this->error_404();
    }

	public function getInqury()
    {
    	$this->load->model(admin('inquiry_model'));
    	$inquiry = $this->inquiry_model->getInqury();
        $retutn = '';
        if ($inquiry) {
        	foreach ($inquiry as $k => $v)
        		$retutn .= '<tr>
        						<td>'.($k + 1).'</td>
        						<td>'.$v['name'].'</td>
        						<td>'.$v['mobile'].'</td>
        						<td>'.$v['email'].'</td>
        						<td>'.date('d-m-Y', strtotime($v['first_visit'])).'</td>
        						<td>'.$v['visa_type'].'</td>
        						<td>'.$v['country_name'].'</td>
        						<td>'.$v['reference'].'</td>
        						<td>'.date('d-m-Y h:i A', strtotime($v['visit_date'])).'</td>
        						<td>'.$v['counselor'].'</td>
        						<td>'.$v['remarks'].'</td>
        					</tr>';
        }else
        	$retutn .= '<tr><td colspan="11" class="text-center">No History Available</td></tr>';

        echo $retutn;
    }

	public function getFollowup()
    {
    	$this->load->model(admin('followup_model'));
    	$followups = $this->followup_model->getFollowup();
        // re($followups);
        $retutn = '';
        if ($followups) {
        	foreach ($followups as $k => $v)
        		$retutn .= '<tr>
        						<td>'.($k + 1).'</td>
        						<td>'.$v['name'].'</td>
        						<td>'.$v['mobile'].'</td>
        						<td>'.$v['email'].'</td>
                                <td>'.date('d-m-Y', strtotime($v['first_visit'])).'</td>
        						<td>'.$v['visa_type'].'</td>
        						<td>'.$v['country_name'].'</td>
        						<td>'.date('d-m-Y h:i A', strtotime($v['visit_date'])).'</td>
        						<td>'.$v['remarks'].'</td>
                                <td>'.$v['status'].'</td>
        					</tr>';
        }else
        	$retutn .= '<tr><td colspan="11" class="text-center">No History Available</td></tr>';

        echo $retutn;
    }

    public function getCoaching()
    {
        $this->load->model(admin('students_model'));
        $history = $this->students_model->getCoaching();
        
        $retutn = '';
        if ($history) {
            foreach ($history as $k => $v)
                $retutn .= '<tr>
                                <td>'.($k + 1).'</td>
                                <td>'.$v['remarks'].'</td>
                                <td>'.date('d-m-Y h:i A', strtotime($v['created_at'])).'</td>
                            </tr>';
        }else
            $retutn .= '<tr><td colspan="11" class="text-center">No History Available</td></tr>';

        echo $retutn;
    }
}