<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'users';
    protected $title = 'users';
    private $table = "admins";
    protected $redirect = "users";
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

            $action = '<div class="btn-group" role="group">
                        <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-cogs"></span></button><div class="dropdown-menu" x-placement="bottom-start">';

            $action .= anchor($this->redirect.'/view/'.e_id($row->id), '<i class="fa fa-eye"></i> View', 'class="dropdown-item"');
            $action .= anchor($this->redirect.'/update/'.e_id($row->id), '<i class="fa fa-edit"></i> Edit', 'class="dropdown-item"');
            $action .= form_open($this->redirect.'/delete', ['id' => e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fas fa-trash"></i> Delete','type'  => 'button','class' => 'dropdown-item', 'onclick' => "remove(".e_id($row->id).")"]).form_close();
            
            $action .= '</div></div>';

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

    public function add()
	{
        $this->form_validation->set_rules($this->validate);
        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "add";
            $data['url'] = $this->redirect;
            return $this->template->load(admin('template'), $this->redirect.'/add', $data);
        }
        else
        {
        	$post = [
                'name'        => $this->input->post('name'),
                'mobile'      => $this->input->post('mobile'),
                'email'       => $this->input->post('email'),
                'role'        => $this->input->post('role'),
                'password'    => my_crypt($this->input->post('password')),
                'created_at'  => date('Y-m-d H:i:s'),
                'last_update' => date('Y-m-d H:i:s')
            ];

        	$id = $this->main->add($post, $this->table);

        	flashMsg($id, ucwords($this->title)." Added Successfully.", ucwords($this->title)." Not Added. Try again.", $this->redirect);
        }
	}

	public function view($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "view";
        $data['url'] = $this->redirect;
        $data['data'] = $this->main->get($this->table, 'name, mobile, email, role', ['id' => d_id($id)]);

        if ($data['data']) 
            return $this->template->load(admin('template'), $this->redirect.'/view', $data);
        else
            return $this->error_404();
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
	        
            $data['url'] = $this->redirect;
            $data['data'] = $this->main->get($this->table, 'id, name, mobile, email, role', ['id' => d_id($id)]);
			
			if ($data['data']) 
			{
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
                'name'        => $this->input->post('name'),
                'mobile'      => $this->input->post('mobile'),
                'email'       => $this->input->post('email'),
                'role'        => $this->input->post('role'),
                'last_update' => date('Y-m-d H:i:s')
            ];

            if ($this->input->post('password')) 
                $post['password'] = my_crypt($this->input->post('password'));

        	$id = $this->main->update(['id' => d_id($updateId)], $post, $this->table);

			flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
        }
	}

	public function delete()
	{
        $id = $this->main->update(['id' => d_id($this->input->post('id'))], ['is_deleted' => 1], $this->table);

		flashMsg($id, ucwords($this->title)." Deleted Successfully.", ucwords($this->title)." Not Deleted. Try again.", $this->redirect);
	}

    public function mobile_check($str)
    {   
        $id = $this->session->updateId;
        
        if ((!empty($id) && $this->main->check($this->table, ['mobile' => $str, 'id != ' => d_id($id), 'is_deleted' => 0], 'id')) || (empty($id) && $this->main->check($this->table, ['mobile' => $str, 'is_deleted' => 0], 'id')))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        $id = $this->session->updateId;
        
        if ((!empty($id) && $this->main->check($this->table, ['email' => $str, 'id != ' => d_id($id), 'is_deleted' => 0], 'id')) || (empty($id) && $this->main->check($this->table, ['email' => $str, 'is_deleted' => 0], 'id')))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function password_check($str)
    {   
        if (empty($this->session->updateId) && !$str)
        {
            $this->form_validation->set_message('password_check', '%s is Required');
            return FALSE;
        } else
            return TRUE;
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'required|exact_length[10]|callback_mobile_check',
            'errors' => [
                'required' => "%s is Required",
                'exact_length' => "%s is invalid"
            ]
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|callback_email_check',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'role',
            'label' => 'Role',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'callback_password_check'
        ]
    ];
}