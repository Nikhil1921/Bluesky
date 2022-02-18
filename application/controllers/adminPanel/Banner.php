<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access))
            return redirect(admin('unauthorized'));
    }

	protected $name = 'banner';
    protected $title = 'banners';
    private $table = "banners";
    protected $redirect = "banner";
    protected $access = ['Operation', 'Super Admin'];

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
        $fetch_data = $this->main->make_datatables(admin('banner_model'));
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = img(['src' => $row->image, 'width' => 100, 'height' => 80]);
            $action = '<div class="ml-0 table-display row">';
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
            "recordsTotal"      => $this->main->count($this->table, ['id != ' => 0]),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('banner_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        );
        
        echo json_encode($output);
    }

    public function add()
	{
        $image = $this->uploadImage();
        if ($image['error'])
            flashMsg(0, '', $image['message'], $this->redirect);
        else{
            $post = [ 'image' => $image['img'] ];

            $id = $this->main->add($post, $this->table);

            flashMsg($id, ucwords($this->name)." Added Successfully.", ucwords($this->name)." Not Added. Try again.", $this->redirect);
        }
	}

    public function delete()
    {
        $bid = d_id($this->input->post('id'));
        $img = $this->main->check($this->table, ['id' => $bid], 'image');
        
        $id = $this->main->delete($this->table, ['id' => $bid]);
        
        if ($id && $img && file_exists("assets/images/banners/".$img))
            unlink("assets/images/banners/".$img);
        
        flashMsg($id, ucwords($this->name)." Deleted Successfully.", ucwords($this->name)." Not Deleted. Try again.", $this->redirect);
    }

	public function uploadImage()
	{
        $this->load->helper('string');
       
        $config = [
            'upload_path'      => "assets/images/banners/",
            'allowed_types'    => 'jpg|jpeg|png',
            'file_name'        => random_string('nozero', 5),
            'file_ext_tolower' => TRUE
        ];

        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload("image"))
            return ['error' => true, 'message' => strip_tags($this->upload->display_errors())];
        else
            return ['error' => false, 'img' => $this->upload->data("file_name")];
	}
}