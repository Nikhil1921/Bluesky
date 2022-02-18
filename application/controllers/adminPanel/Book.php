<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access))
            return redirect(admin('unauthorized'));
    }

	protected $name = 'book';
    protected $title = 'books';
    private $table = "book";
    protected $redirect = "book";
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
        $fetch_data = $this->main->make_datatables(admin('book_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = ucfirst($row->book);
            $sub_array[] = img(['src' => $row->image, 'width' => 100, 'height' => 80]);
            $sub_array[] = ($row->name) ? $row->name : '<span class="badge badge-danger">Not issued</span>';
            $sub_array[] = ($row->mobile) ? $row->mobile : '<span class="badge badge-danger">Not issued</span>';
            $sub_array[] = ($row->name) ? date('d-m-Y', strtotime($row->return_date)) : '<span class="badge badge-danger">Not issued</span>';

            $action = '<div class="ml-0 table-display row">';
            $action .= anchor($this->redirect.'/update/'.e_id($row->id), '<i class="fa fa-edit"></i>', 'class="btn btn-outline-primary mr-2"')
                    ;
            if (in_array($this->role, ['IELTS Operation']))
                if (!$row->name)
                    $action .= form_button([ 'content' => '<i class="fa fa-user"></i>','type'  => 'button','class' => 'btn btn-outline-primary mr-2', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#issue-book"]);
                else
                    $action .= form_open($this->redirect.'/returnBook', ['id' => 'book'.e_id($row->id)], ['id' => e_id($row->id), 'student' => e_id($row->current_issue)]).form_button([ 'content' => '<i class="fas fa-file-signature"></i>','type'  => 'button','class' => 'btn btn-outline-success mr-2', 'onclick' => "returnBook(".e_id($row->id).")"]).form_close();


            $action .= form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'onclick' => "viewBookHistory(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);

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
            "recordsFiltered"   => $this->main->get_filtered_data(admin('book_model')),
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
	                'book' => $this->input->post('book'),
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
        $data['data'] = $this->main->get($this->table, 'book, image', ['id' => d_id($id)]);
        
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
                    'book' => $this->input->post('book'),
                    'image' => $image['img']
                ];

                $id = $this->main->update(['id' => d_id($updateId)], $post, $this->table);

                flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
            }
        }
	}

	public function issue_book()
	{
        if (!$this->input->post('book_id') || !$this->input->post('student') || !$this->input->post('return'))
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        $post = [
            'book_id'    => d_id($this->input->post('book_id')),
            'user_id'    => d_id($this->input->post('student')),
            'created_at' => date("Y-m-d H:i:s"),
            'issued_by'  => $this->id,
            'issue_type' => 'Issue',
            'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null
        ];
        
        $id = $this->main->add($post, 'book_logs');
        
        if ($id)
            $this->main->update(['id' => $post['book_id']], ['current_issue' => $post['user_id'], 'return_date' => date("Y-m-d", strtotime($this->input->post('return')))], $this->table);
        
        flashMsg($id, ucwords($this->title)." Issued Successfully.", ucwords($this->title)." Not Issued. Try again.", $this->redirect);
	}

    public function returnBook()
    {
        if (!$this->input->post('id') || !$this->input->post('student'))
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        
        $post = [
            'book_id'    => d_id($this->input->post('id')),
            'user_id'    => d_id($this->input->post('student')),
            'created_at' => date("Y-m-d H:i:s"),
            'issued_by'  => $this->id,
            'issue_type' => 'Return',
            'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null
        ];
        
        $id = $this->main->add($post, 'book_logs');
        
        if ($id)
            $this->main->update(['id' => $post['book_id']], ['current_issue' => 0, 'return_date' => date("Y-m-d")], $this->table);
        
        flashMsg($id, ucwords($this->title)." Issued Successfully.", ucwords($this->title)." Not Issued. Try again.", $this->redirect);
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
                'upload_path'      => "assets/images/books/",
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
            'field' => 'book',
            'label' => 'Book Name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}