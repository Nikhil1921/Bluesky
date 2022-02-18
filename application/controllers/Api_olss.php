<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        // mobile();
    }

    public function visitor_visa()
    {
        post();
        verifyRequiredParams(['name', 'mobile', 'email', 'dob', 'purpose', 'counrty']);

        $params = $this->input->post();
        $data = [
                    'name'         => $params['name'],
                    'mobile'       => $params['mobile'],
                    'email'        => $params['email'],
                    'created_date' => date("Y-m-d H:i:s"),
                    'dob'          => $params['dob'],
                    'purpose'      => $params['purpose'],
                    'counrty'      => $params['counrty']
                ];

        if($row = $this->main->add($data, 'visitor_visa'))
        {
            //$this->send_mail_visitor_visa($params);
            $response['error'] = FALSE;
            $response['message'] ="Visitor Visa Sent Successfully.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Visitor Visa Sent Error..?";
            echoRespnse(400, $response);
        }
    }

    public function student_visa()
    {
        post();
        verifyRequiredParams(['name', 'mobile', 'dob', 'email', 'education', 'back_log', 'counrty', 'overall_band', 'language_data']);

        $params = $this->input->post();
        $data = [
                    'name'          => $params['name'],
                    'mobile'        => $params['mobile'],
                    'dob'           => $params['dob'],
                    'email'         => $params['email'],
                    'education'     => $params['education'],
                    'back_log'      => $params['back_log'],
                    'created_date'  => date("Y-m-d H:i:s"),
                    'counrty'       => $params['counrty'],
                    'overall_band'  => $params['overall_band'],
                    'language_data' => $params['language_data']
                ];

        if($row = $this->main->add($data, 'student_visa'))
        {
            //$this->send_mail_student_visa($params);
            $response['error'] = FALSE;
            $response['message'] ="Student Visa Sent Successfully.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Student Visa Sent Error..?";
            echoRespnse(400, $response);
        }
    }

    public function australia_visa()
    {
        post();
        verifyRequiredParams(['name', 'phone', 'dob', 'email', 'status', 'education', 'work_experience', 'work_position_held', 'work_total_experience', 'language_data', 'spousename', 'spouse_date', 'comprehenstion', 'exprestion', 'overall_band', 'spouse_education', 'spouse_work_position_held', 'spouse_work_total_experience', 'spouse_status', 'spouse_language_data', 'spouseoverallband']);

        $params = $this->input->post();
        $data = [
                    'name'                         => $params['name'],
                    'mobile'                       => $params['phone'],
                    'dob'                          => $params['dob'],
                    'email'                        => $params['email'],
                    'created_date'                 => date("Y-m-d H:i:s"),
                    'status'                       => $params['status'],
                    'education'                    => $params['education'],
                    'work_experience'              => $params['work_experience'],
                    'work_position_held'           => $params['work_position_held'],
                    'work_total_experience'        => $params['work_total_experience'],
                    'language_data'                => $params['language_data'],
                    'spouse_name'                  => $params['spousename'],
                    'spouse_date'                  => $params['spouse_date'],
                    'australia_status'             => $params['australia_status'],
                    'comprehenstion'               => $params['comprehenstion'],
                    'exprestion'                   => $params['exprestion'],
                    'overall_band'                 => $params['overall_band'],
                    'spouse_education'             => $params['spouse_education'],
                    'spouse_work_position_held'    => $params['spouse_work_position_held'],
                    'spouse_work_total_experience' => $params['spouse_work_total_experience'],
                    'spouse_status'                => $params['spouse_status'],
                    'spouse_language_data'         => $params['spouse_language_data'],
                    'spouse_overall_band'          =>$params['spouseoverallband']
                ];

        if($row = $this->main->add($data, 'australia_visa'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Australia Visa Sent Successfully.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Australia Visa Sent Error..?";
            echoRespnse(400, $response);
        }
    }

    public function canada_visa()
    {
        post();
        verifyRequiredParams(['name', 'phone', 'dob', 'email', 'status', 'education', 'work_experience', 'work_position_held', 'work_total_experience', 'overall_band', 'spouseoverallband', 'language_data', 'spousename', 'spouse_date', 'comprehenstion', 'exprestion', 'spouse_education', 'spouse_work_position_held', 'spouse_work_total_experience', 'spouse_status', 'spouse_language_data', 'french_status', 'canada_status', 'IELTS_name_1', 'IELTS_name_2', 'api_status', 'IELTS_exam_self', 'IELTS_exam_spouse']);

        $params = $this->input->post();
        $data = [
                    'name'                         => $params['name'],
                    'mobile'                       => $params['phone'],
                    'dob'                          => $params['dob'],
                    'email'                        => $params['email'],
                    'status'                       => $params['status'],
                    'education'                    => $params['education'],
                    'created_date'                 => date("Y-m-d H:i:s"),
                    'work_experience'              => $params['work_experience'],
                    'work_position_held'           => $params['work_position_held'],
                    'work_total_experience'        => $params['work_total_experience'],
                    'overall_band'                 => $params['overall_band'],
                    'spouse_overall_band'          => $params['spouseoverallband'],
                    'language_data'                => $params['language_data'],
                    'spouse_name'                  => $params['spousename'],
                    'spouse_date'                  => $params['spouse_date'],
                                                
                    'comprehenstion'               => $params['comprehenstion'],
                    'exprestion'                   => $params['exprestion'],

                    'spouse_education'             => $params['spouse_education'],

                    'spouse_work_position_held'    => $params['spouse_work_position_held'],
                    'spouse_work_total_experience' => $params['spouse_work_total_experience'],

                    'spouse_status'                => $params['spouse_status'],

                    'spouse_language_data'         => $params['spouse_language_data'],
                    'french_status'                => $params['french_status'],
                    'canada_status'                => $params['canada_status'],
                    'IELTS_name_1'                 => $params['IELTS_name_1'],
                    'IELTS_name_2'                 => $params['IELTS_name_2'],

                    'api_status'                   => $params['api_status'],
                    'IELTS_exam_self'              => $params['IELTS_exam_self'],
                    'IELTS_exam_spouse'            => $params['IELTS_exam_spouse']
                ];

        if($row = $this->main->add($data, 'canada_visa'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Canada Visa Sent Successfully.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Canada Visa Sent Error..?";
            echoRespnse(400, $response);
        }
    }
}