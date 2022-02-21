<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('ApiModel', 'api');
        // mobile();
    }

    private $table = 'users';
    private $banner = 'assets/images/banners/';
    private $blog = 'assets/images/blog/';
    private $news = 'assets/images/news/';
    private $docs = "assets/images/documents/";

    public function login()
    {
        post();
        verifyRequiredParams(['mobile', 'password']);

        $post = [
                    'mobile'     => $this->input->post('mobile'),
                    'password'   => my_crypt($this->input->post('password')),
                    'is_deleted' => 0
                ];

        if($row = $this->main->get($this->table, 'inq_id', $post))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Login success.";
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Login not success.";
        }

        echoRespnse(200, $response);
    }
    
    public function banners()
    {
        get();

        if($row = $this->main->getall('banners', 'CONCAT("'.base_url($this->banner).'", image) banner', []))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Banner list success.";
        }
        else
        {
            $response["error"] = TRUE;
            $response['message'] = "Banner list not success.";
        }

        echoRespnse(200, $response);
    }
    
    public function videos()
    {
        get();

        if($row = $this->main->getall('video', 'video_title, video_url, description, , CONCAT("'.base_url($this->blog).'", image) image', ['is_deleted' => 0]))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Video list success.";
        }
        else
        {
            $response["error"] = TRUE;
            $response['message'] = "Video list not success.";
        }

        echoRespnse(200, $response);
    }
    
    public function blogs()
    {
        get();

        if($row = $this->main->getall('blog', 'title, description, CONCAT("'.base_url($this->blog).'", image) image', ['is_deleted' => 0]))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Blog list success.";
        }
        else
        {
            $response["error"] = TRUE;
            $response['message'] = "Blog list not success.";
        }

        echoRespnse(200, $response);
    }
    
    public function news()
    {
        get();

        if($row = $this->main->getall('news', 'news, CONCAT("'.base_url($this->news).'", image) image', ['is_deleted' => 0]))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="News list success.";
        }
        else
        {
            $response["error"] = TRUE;
            $response['message'] = "News list not success.";
        }

        echoRespnse(200, $response);
    }
    
    public function profile()
    {
        get();
        $api = authenticate($this->table);

        if($row = $this->api->profile($api))
        {
            $row->path = base_url($this->docs);
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Profile success.";
        }
        else
        {
            $response["error"] = TRUE;
            $response['message'] = "Profile not success.";
        }

        echoRespnse(200, $response);
    }

    public function upload()
    {
        post();
        $api = authenticate($this->table);
        verifyRequiredParams(['visa_type', 'document']);
        $this->load->helper('string');
        $config = [
            'upload_path'      => $this->docs,
            'allowed_types'    => 'jpg|jpeg|png',
            'file_name'        => random_string('nozero', 5),
            'file_ext_tolower' => TRUE
        ];
        
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload("image")) { 
            $response["error"] = TRUE;
            $response['message'] = strip_tags($this->upload->display_errors());
        }else{
            $document = $this->input->post('document');
            
            switch ($this->input->post('visa_type')) {
                case 'Student':
                    $table = 'student_visa';
                    break;
                
                case 'Permanent Residency':
                    $table = 'pr_visa';
                    break;
                
                default:
                    $table = 'visitor_visa';
                    break;
            }
            
            $images = json_decode($this->main->check($table, ['i_id' => $api], 'documents'));
            
            foreach ($images as $k => $v) {
                if ($v->document == $document) {
                    $unlink = $v->img;
                    $v->img = $this->upload->data("file_name");
                    
                    $config_manip = [
                        'image_library' => 'gd2',
                        'source_image' => $this->upload->data('full_path'),
                        'new_image' => $this->upload->data('file_path'),
                        'maintain_ratio' => TRUE,
                        'width' => 1900,
                        'height' => 900
                    ];
               
                    $this->load->library('image_lib', $config_manip);
                    $this->image_lib->resize();
               
                    $this->image_lib->clear();
                }else continue;
            }
            
            $images = json_encode($images);

            $uid = $this->main->update(['i_id' => $api], ['documents' => $images], $table);
            
            if($uid){
                if ($unlink && is_file($this->docs.$unlink))
                    unlink($this->docs.$unlink);
                $response["error"] = FALSE;
                $response['message'] = 'Document upload success.';
            }
            else{
                if (is_file($this->docs.$this->upload->data("file_name")))
                    unlink($this->docs.$this->upload->data("file_name"));
                $response["error"] = FALSE;
                $response['message'] = 'Document upload not success.';
            }
        }
        
        echoRespnse(200, $response);
    }
}