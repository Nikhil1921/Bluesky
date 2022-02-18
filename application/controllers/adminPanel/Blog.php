<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access))
            return redirect(admin('unauthorized'));
    }

	protected $name = 'blog';
    protected $title = 'blog';
    private $table = "blog";
    protected $redirect = "blog";
    protected $access = ['Operation', 'Super Admin', 'IELTS Operation'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['dataTables'] = TRUE;
        $data['select'] = TRUE;
        $data['daterangepicker'] = TRUE;

        $data['students'] = $this->main->getall('inquiry', 'id, name', ['is_deleted' => 0, 'ielts' => 1]);

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('blog_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = ucfirst($row->title);
            $sub_array[] = img(['src' => $row->image, 'width' => 100, 'height' => 80]);
            
            $action = '<div class="ml-0 table-display row">';
            $action .= anchor($this->redirect.'/update/'.e_id($row->id), '<i class="fa fa-edit"></i>', 'class="btn btn-outline-primary mr-2"')
                    ;
            $action .= form_open($this->redirect.'/delete', ['id' => e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fas fa-trash"></i>','type'  => 'button','class' => 'btn btn-outline-danger', 'onclick' => "remove(".e_id($row->id).")"]).form_close();
            $action .= '</div>';

            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, ['is_deleted' => 0]),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('blog_model')),
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
        	$image = $this->uploadImage();
        	if ($image['error']) {
        		$data['name'] = $this->name;
	            $data['title'] = $this->title;
	            $data['operation'] = "add";
	            $data['url'] = $this->redirect;
	            $data['img_error'] = $image['message'];
	            
	            return $this->template->load(admin('template'), $this->redirect.'/add', $data);
        	}else{
	        	$post = [
	                'title' => $this->input->post('title'),
	                'description' => $this->input->post('description'),
                    'image' => $image['img']
	            ];
	            
	        	$id = $this->main->add($post, $this->table);

	        	flashMsg($id, ucwords($this->title)." Added Successfully.", ucwords($this->title)." Not Added. Try again.", $this->redirect);
        	}
        }
	}

	public function edit($id, $data=[])
    {
        $data['name'] = $this->name;
        $data['id'] = $id;
        $data['title'] = $this->title;
        $data['operation'] = "update";
        $data['url'] = $this->redirect;
        $data['data'] = $this->main->get($this->table, 'title, description, image', ['id' => d_id($id)]);
        
        if ($data['data']) 
        {
            $this->session->set_flashdata('updateId', $id);
            return $this->template->load(admin('template'), $this->redirect.'/update', $data);
        }
        else
            return $this->error_404();
    }

    public function update($id)
	{
        $this->form_validation->set_rules($this->validate);
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->edit($id);
        }
        else
        {
        	$updateId = $this->session->updateId;
            $this->session->set_flashdata('updateId', $id);

            $image = $this->uploadImage();
            
            if ($image['error']) {
                $data['img_error'] = $image['message'];
                return $this->edit($id, $data);
            }else{
                $post = [
                    'title' => $this->input->post('title'),
	                'description' => $this->input->post('description'),
                    'image' => $image['img']
                ];

                $id = $this->main->update(['id' => d_id($updateId)], $post, $this->table);

                flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
            }
        }
	}

    public function delete()
    {
        $id = $this->main->update(['id' => d_id($this->input->post('id'))], ['is_deleted' => 1], $this->table);

        flashMsg($id, ucwords($this->title)." Deleted Successfully.", ucwords($this->title)." Not Deleted. Try again.", $this->redirect);
    }

	public function uploadImage()
	{
        if (!empty($_FILES['image']['name'])) {
            $this->load->helper('string');
           
            $config = [
                'upload_path'      => "assets/images/blog/",
                'allowed_types'    => 'jpg|jpeg|png',
                'file_name'        => random_string('nozero', 5),
                'file_ext_tolower' => TRUE
            ];

            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload("image"))
                return ['error' => true, 'message' => strip_tags($this->upload->display_errors())];
            else
                if ($this->input->post('image') && file_exists($config['upload_path'].$this->input->post('image')))
                    unlink($config['upload_path'].$this->input->post('image'));
                return ['error' => false, 'img' => $this->upload->data("file_name")];
        }else
            if ($this->input->post('image'))
                return ['error' => false, 'img' => $this->input->post('image')];
            else
                return ['error' => true, 'message' => "Select image to upload."];
	}

    protected $validate = [
        [
            'field' => 'title',
            'label' => 'Blog title',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'description',
            'label' => 'Blog description',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}