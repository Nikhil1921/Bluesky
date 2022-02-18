<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        // mobile();
    }

    private $table = 'users';

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

        echoRespnse(400, $response);
    }
}