<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LmsEmployeeApi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        // mobile();
    }

    protected $table = 'admins';

    public function login()
    {
        post();
        verifyRequiredParams(['mobile', 'password']);

        $post = [
                'mobile'     => $this->input->post('mobile'),
                'password'   => my_crypt($this->input->post('password')),
                'is_blocked' => 0,
                'is_deleted' => 0
            ];

        if($row = $this->main->get($this->table, 'id, name, mobile, email, role, lead_type', $post))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Login Successful.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Login Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function lead_list()
    {
        get();
        $api = authenticate($this->table);
        verifyRequiredParams(['formLoad']);

        switch ($this->input->get('formLoad')) {
            case 'student_visa':
                $table = 'student_visa';
                break;

            case 'australia_visa':
                $table = 'australia_visa';
                break;
            
            case 'canada_visa':
                $table = 'canada_visa';
                break;
            
            default:
                $table = 'visitor_visa';
                break;
        }

        $where = ['is_deleted' => 0, 'cred_create' => 0, 'consulted_by' => 0, 'assigned' => $api];
        
        if($row = $this->main->getall($table, 'id, name, mobile, email', $where))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Lead List Successful.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Lead List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function add_followup()
    {
        post();
        $api = authenticate($this->table);
        verifyRequiredParams(['lead_id', 'formLoad', 'remarks', 'follow_date', 'follow_time', 'status']);

        $post = [
                    'lead_id'     => $this->input->post('lead_id'),
                    'follow_form' => $this->input->post('formLoad'),
                    'remarks'     => $this->input->post('remarks'),
                    'follow_date' => date('Y-m-d', strtotime($this->input->post('follow_date'))),
                    'follow_time' => date('H:i:s', strtotime(str_replace("m", '0', $this->input->post('follow_time')))),
                    'status'      => $this->input->post('status'),
                    'created_at'  => date('Y-m-d H:i:s')
                ];
            
        if($row = $this->main->add($post, 'follow_ups'))
        {
            if ($row && $post['status'] !== 'Follow Up') {
                $this->main->update(['lead_id' => $post['lead_id']], ['is_closed' => 1], 'follow_ups');
                $this->main->update(['id' => $post['lead_id']], ['is_deleted' => 1], $post['follow_form']);
            }

            $response['error'] = FALSE;
            $response['message'] ="Add Followup Successful.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Add Followup Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function followUps()
    {
        get();
        $api = authenticate($this->table);
        verifyRequiredParams(['lead_id', 'formLoad']);

        $post = [
                    'lead_id'     => $this->input->get('lead_id'),
                    'follow_form' => $this->input->get('formLoad')
                ];
            
        if($row = $this->main->getall('follow_ups', 'follow_date, follow_time, status, created_at, remarks', $post))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Followup(s) List Successful.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Followup(s) List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function consults()
    {
        get();
        $api = authenticate($this->table);
        /*verifyRequiredParams(['formLoad']);*/

        $where = ['is_deleted' => 0, 'role' => 'Consultant', 'is_blocked' => 0];
        /*$where = ['is_deleted' => 0, 'role' => 'Consultant', 'is_blocked' => 0, 'lead_type' => $this->input->get('formLoad')];*/
        
        if($row = $this->main->getall($this->table, 'id, name', $where))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Consults List Successful.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Consults List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function assign_consult()
    {
        post();
        $api = authenticate($this->table);
        verifyRequiredParams(['lead_id', 'formLoad', 'consultant']);

        $post = [
                    'consulted_by'    => $this->input->post('consultant'),
                    'consult_asigned_by' => $api
                ];
            
        if($row = $this->main->update(['id' => $this->input->post('lead_id')], $post, $this->input->post('formLoad')))
        {
            $follow = [
                'lead_id'     => $this->input->post('lead_id'),
                'follow_form' => $this->input->post('formLoad'),
                'follow_date' => date('Y-m-d'),
                'follow_time' => date('H:i:s'),
                'status'      => 'Assigned',
                'remarks'     => 'Assigned To Consultant',
                'created_at'  => date('Y-m-d H:i:s')
            ];

            $this->main->add($follow, 'follow_ups');
            $this->main->update(['lead_id' => $follow['lead_id']], ['is_closed' => 1], 'follow_ups');

            $response['error'] = FALSE;
            $response['message'] ="Lead Assigned Successful.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Lead Assigned Not Successful.";
            echoRespnse(400, $response);
        }
    }
}