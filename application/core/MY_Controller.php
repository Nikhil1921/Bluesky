<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        if ((!empty($this->session->adminId)))
            $this->id = $this->session->adminId;
        else
            return redirect(admin('login'));

        $this->redirect = admin($this->redirect);
        $this->role = $this->session->role;
        $this->lead = $this->session->lead_type;
    }

    public function getCountry()
    {
        if ($this->input->is_ajax_request()) {
            $country = $this->main->getall('country', 'id, country_name, ', ['is_deleted' => 0, 'visa_type' => $this->input->post('visa')]);
            $return = '<option value="" selected="" disabled="">Select Country</option>';
            foreach ($country as $c) {
                $return .= '<option value="'.e_id($c['id']).'">'.$c['country_name'].'</option>';
            }
            echo $return;
        }else
           return $this->error_404();
    }

    public function followUps()
    {
        if (!$this->input->is_ajax_request()) 
           $this->error_404();
        else{
            $this->load->model(admin('lead_model'));
            $data['history'] = $this->lead_model->getHistory();
            return $this->load->view(admin('lead/history'), $data);
        }
    }

    public function viewBatch()
    {
        if (!$this->input->is_ajax_request()) 
           $this->error_404();
        else{
            $this->load->model(admin('inquiry_model'), 'inquiry');
            $data['users'] = $this->inquiry->viewBatch();
            
            return $this->load->view(admin('ieltsBatch/users'), $data);
        }
    }

    public function viewHistory()
    {
        if (!$this->input->is_ajax_request()) 
           $this->error_404();
        else{
            $this->load->model(admin('inquiry_model'), 'inquiry');
            $data['history'] = $this->inquiry->getHistory();
            
            return $this->load->view(admin('inquiry/history'), $data);
        }
    }

    public function viewBookHistory()
    {
        if (!$this->input->is_ajax_request()) 
           $this->error_404();
        else{
            $this->load->model(admin('book_model'), 'book');
            $data['history'] = $this->book->getHistory();
            
            return $this->load->view(admin('book/history'), $data);
        }
    }

    public function view_client($id, $visa)
    {
        $data['name'] = $this->name;
        $data['operation'] = "view";
        $data['url'] = $this->redirect;
        $this->load->model(admin('inquiry_model'), 'inquiry');
        $data['data'] = $this->inquiry->getInquiry(d_id($id), $visa);
        
        if ($data['data']){
            $data['title'] = $data['data']['visa_type'].' visa';
            switch ($data['data']['visa_type']) {
                case 'Visitor':
                    return $this->template->load(admin('template'), admin('counseling/visitor'), $data);
                    break;

                case 'IELTS':
                    return $this->template->load(admin('template'), admin('counseling/ielts'), $data);
                    break;

                case 'Student':
                    return $this->template->load(admin('template'), admin('counseling/student'), $data);
                    break;

                case 'Permanent Residency':
                    return $this->template->load(admin('template'), admin('counseling/pr_visa'), $data);
                    break;
                
                default:
                    return $this->error_404();
                    break;
            }
        }
        else
            return $this->error_404();
    }

    public function update_details($id, $visa)
    {
        $data['name'] = $this->name;
        $data['operation'] = "update";
        $data['url'] = $this->redirect;
        $data['daterangepicker'] = TRUE;
        $data['select'] = TRUE;
        $data['documents'] = $this->main->getall('document', 'document', ['is_deleted' => 0]);
        $this->load->model(admin('inquiry_model'), 'inquiry');
        $data['data'] = $this->inquiry->getInquiry(d_id($id), $visa);

        $data['title'] = $data['data']['visa_type'].' visa';
        if ($data['data'])
            $data['country'] = $this->main->getall('country', 'id, country_name', ['is_deleted' => 0, 'visa_type' => $data['data']['visa_type']]);
        
        if ($data['data'])
            switch ($data['data']['visa_type']) {
                case 'Visitor':
                    
                    return $this->template->load(admin('template'), admin('counseling/edit/visitor'), $data);
                    break;

                case 'IELTS':
                    
                    return $this->template->load(admin('template'), admin('counseling/edit/ielts'), $data);
                    break;

                case 'Student':
                    
                    return $this->template->load(admin('template'), admin('counseling/edit/student'), $data);
                    break;

                case 'Permanent Residency':
                    
                    return $this->template->load(admin('template'), admin('counseling/edit/pr_visa'), $data);
                    break;
                
                default:
                    return $this->error_404();
                    break;
            }
        else
            return $this->error_404();
    }

    public function visa_type($id)
    {
        $this->form_validation->set_rules('visa_type', 'Visa Type', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('inquiry_country', 'Lead Country', 'required', ['required' => '%s is required.']);
        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['operation'] = "update";
            $data['url'] = $this->redirect;
            $data['select'] = TRUE;
            $this->load->model(admin('inquiry_model'), 'inquiry');
            $data['data'] = $this->inquiry->visa_type(d_id($id));

            $data['title'] = $data['data']['visa_type'].' visa';
            
            if ($data['data'])
                return $this->template->load(admin('template'), admin('counseling/edit/visa_type'), $data);
            else
                return $this->error_404();
        }else{
            $post = [
                        'inquiry_country' => d_id($this->input->post('inquiry_country')),
                        'remarks'         => $this->input->post('remarks')
                    ];

            $uid = $this->main->update(['id' => d_id($id)], $post, 'inquiry');

            if ($uid) {
                $log = [
                    'inq_id'     => d_id($id),
                    'remarks'    => 'Country update.',
                    'created_by' => $this->id,
                    'counselor'  => $this->id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            
                $this->main->add($log, 'inquery_logs');
            }

            flashMsg($uid, "Country Updated Successfully.", "Country Not Updated. Try again.", $this->redirect);
        }
    }

    public function update_post($id)
    {
        $visa = $this->input->post('visa_type');
        $imgs = (array) json_decode($this->input->post('imgs'));
        
        if ($this->input->post('documents')) {
            foreach ($this->input->post('documents') as $d => $doc){
                $documents[$d]['document'] = $doc;
                if ($imgs && $imgs[$doc])
                    $documents[$d]['img'] = $imgs[$doc];
            }
            $documents = json_encode($documents);
        }else
            $documents = null;

        switch ($visa) {
            case 'Visitor':
            case 'IELTS':
                $this->form_validation->set_rules($this->visitor);
                if ($this->form_validation->run() == FALSE)
                    return $this->update_details($id, $visa);
                else{
                    $post = [
                        'i_id'      => d_id($id),
                        'dob'       => date("Y-m-d", strtotime($this->input->post('dob'))),
                        'purpose'   => $this->input->post('purpose'),
                        'documents' => $documents
                    ];
                    
                    $uid = ($this->main->check('visitor_visa', ['i_id' => d_id($id)], 'i_id')) ? $this->main->update(['i_id' => d_id($id)], $post, 'visitor_visa') : $this->main->add($post, 'visitor_visa');
                }
                break;

            case 'Student':
                $post = [
                    'i_id'          => d_id($id),
                    'dob'           => date("Y-m-d", strtotime($this->input->post('dob'))),
                    'documents'     => $documents,
                    'education'     => ($this->input->post('education')) ? json_encode($this->input->post('education')) : null,
                    'back_log'      => $this->input->post('back_log'),
                    'language_data' => ($this->input->post('laungauge')) ? json_encode($this->input->post('laungauge')) : null,
                    'overall_band'  => $this->input->post('overall_band')
                ];
                
                $uid = ($this->main->check('student_visa', ['i_id' => d_id($id)], 'i_id')) ? $this->main->update(['i_id' => d_id($id)], $post, 'student_visa') : $this->main->add($post, 'student_visa');
                
                break;

            case 'Permanent Residency':
                $sp_imgs = (array) json_decode($this->input->post('sp_imgs'));
                if ($this->input->post('spouse_documents')) {
                    foreach ($this->input->post('spouse_documents') as $sd => $doc){
                        $spouse_documents[$sd]['document'] = $doc;
                        if ($sp_imgs && $sp_imgs[$doc])
                            $spouse_documents[$sd]['img'] = $sp_imgs[$doc];
                    }
                    $spouse_documents = json_encode($spouse_documents);
                }else
                    $spouse_documents = null;
                $post = [
                    'i_id'                         => d_id($id),
                    'dob'                          => date("Y-m-d", strtotime($this->input->post('dob'))),
                    'status'                       => ($this->input->post('status')) ? $this->input->post('status') : "Unmarried",
                    'education'                    => ($this->input->post('education')) ? json_encode($this->input->post('education')) : '',
                    'work_experience'              => $this->input->post('work_experience'),
                    'work_position_held'           => $this->input->post('work_position_held'),
                    'work_total_experience'        => $this->input->post('work_total_experience'),
                    'language_data'                => ($this->input->post('laungauge')) ? json_encode($this->input->post('laungauge')) : '',
                    'spouse_name'                  => $this->input->post('spouse_name'),
                    'spouse_date'                  => date("Y-m-d", strtotime($this->input->post('spouse_date'))),
                    'tef_status'                   => $this->input->post('tef_status'),
                    'comprehenstion'               => ($this->input->post('comprehenstion')) ? json_encode($this->input->post('comprehenstion')) : '',
                    'exprestion'                   => ($this->input->post('exprestion')) ? json_encode($this->input->post('exprestion')) : '',
                    'overall_band'                 => $this->input->post('overall_band'),
                    'spouse_education'             => ($this->input->post('spouse_education')) ? json_encode($this->input->post('spouse_education')) : '',
                    'spouse_work_position_held'    => $this->input->post('spouse_work_position_held'),
                    'spouse_work_total_experience' => $this->input->post('spouse_work_total_experience'),
                    'spouse_status'                => $this->input->post('sp_work_experience'),
                    'spouse_language_data'         => ($this->input->post('spouse_laungauge')) ? json_encode($this->input->post('spouse_laungauge')) : '',
                    'spouse_overall_band'          => $this->input->post('spouse_overall_band'),
                    'documents'                    => $documents,
                    'french_status'                => $this->input->post('french_status'),
                    'spouse_documents'             => $spouse_documents
                    
                ];
                
                $uid = ($this->main->check('pr_visa', ['i_id' => d_id($id)], 'i_id')) ? $this->main->update(['i_id' => d_id($id)], $post, 'pr_visa') : $this->main->add($post, 'pr_visa');
                
                break;

            default:
                return redirect($this->redirect);
                break;
        }
        
        if ($uid){
            $log = [
                'inq_id'     => d_id($id),
                'remarks'    => 'Details updated.',
                'created_by' => $this->id,
                'counselor'  => $this->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
        
            $this->main->add($log, 'inquery_logs');
            
            $update = ['inquiry_country' => d_id($this->input->post('inquiry_country')), 'updated_at' => $log['created_at']];

            if ($this->input->post('batch'))
                $update['batch'] = d_id($this->input->post('batch'));

            if ($this->input->post('grammer'))
                $update['grammer'] = 1;

            $this->main->update(['id' => d_id($id)], $update, $this->table);
        }
        
        flashMsg($uid, "Details Updated Successfully.", "Details Not Updated. Try again.", $this->redirect);
    }

    public function upload($id, $visa)
    {
        if ($this->input->server('REQUEST_METHOD') === 'GET') 
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title.' images';
            $data['operation'] = "upload";
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['form'] = $visa;
            
            switch (str_replace('-', ' ', $visa)) {
                case 'Permanent Residency':
                    $data['data'] = $this->main->get('pr_visa', 'documents, spouse_documents', ['i_id' => d_id($id)]);
                    $data['table'] = 'pr_visa';
                    break;
                
                case 'Student':
                    $data['data'] = $this->main->get('student_visa', 'documents', ['i_id' => d_id($id)]);
                    $data['table'] = 'student_visa';
                    break;

                case 'Visitor':
                case 'IELTS':
                    $data['data'] = $this->main->get('visitor_visa', 'documents', ['i_id' => d_id($id)]);
                    $data['table'] = 'visitor_visa';
                    break;
                
                default:
                    return $this->error_404();
                    break;
            }
            
            if ($data['data'])
                return $this->template->load(admin('template'), admin('counseling/upload'), $data);
            else
                return $this->error_404();
        }else{
            
            $this->load->helper('string');
            $config = [
                'upload_path'      => "assets/images/documents/",
                'allowed_types'    => 'jpg|jpeg|png',
                'file_name'        => random_string('nozero', 5),
                'file_ext_tolower' => TRUE
            ];

            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload("image")) { 
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                return redirect($this->redirect.'/upload/'.$id.'/'.$visa);
            }else{
                $table = $this->input->post('table');
                $column = $this->input->post('column');
                $unlink = $this->input->post('unlink');

                if ($unlink && file_exists($config['upload_path'].$unlink))
                    unlink($config['upload_path'].$unlink);
                $i_id = d_id($id);
                $images = json_decode($this->main->check($table, ['i_id' => $i_id], $column));
                $document = $this->input->post('document');
                foreach ($images as $k => $v) {
                    if ($v->document == $document) {
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
                    }
                }
                
                $images = json_encode($images);

                $uid = $this->main->update(['i_id' => $i_id], [$column => $images], $table);

                if ($uid){
                    $log = [
                        'inq_id'     => $i_id,
                        'remarks'    => $document.' Image Uploaded.',
                        'created_by' => $this->id,
                        'counselor'  => $this->id,
                        'created_at' => date("Y-m-d H:i:s")
                    ];
                
                    $this->main->add($log, 'inquery_logs');
                }

                flashMsg($uid, "Image Uploaded.", "Image Not Uploaded. Try again.", $this->redirect.'/upload/'.$id.'/'.$visa);
            }
        }
    }

    public function creds()
    {
        $table = $this->input->post('table');
        $inq_id = d_id($this->input->post('id'));

        $user = $this->main->get($this->table, 'mobile', ['id' => $inq_id]);

        $post = [
            'mobile'     => $user['mobile'],
            'password'   => my_crypt($user['mobile']),
            'inq_id'     => $inq_id,
            'is_deleted' => 0
        ];
        
        $id = ($this->main->check("users", ['inq_id' => $inq_id], 'inq_id')) ? $this->main->update(['inq_id' => $inq_id], $post, "users") : $this->main->add($post, "users");

        if ($id) {
            
            $log = [
                'inq_id'     => $inq_id,
                'remarks'    => 'Credentials created.',
                'created_by' => $this->id,
                'counselor'  => $this->id,
                'created_at' => date("Y-m-d H:i:s")
            ];
        
            $this->main->add($log, 'inquery_logs');

            $this->main->update(['id' => $inq_id], ['is_deleted' => 0, 'cred_create' => 1, 'updated_at' => $log['created_at']], $this->table);
        }

        flashMsg($id, "Credentials Created Successfully.", "Credentials Not Created. Try again.", $this->redirect);
    }

    public function statusCheck()
    {
        if (!$this->input->is_ajax_request()) 
           $this->error_404();
        else{
            $this->load->model(admin('inquiry_model'), 'inquiry');
            $data['status'] = $this->inquiry->getStatus();
            
            return $this->load->view(admin('inquiry/status'), $data);
        }
    }

    public function status()
    {
        if (!$this->input->post('inquiry_id')) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        /* $img = null;
        if ($_FILES['image']['name']) {
            
            $config = [
                'upload_path'      => "assets/images/status/",
                'allowed_types'    => 'jpg|jpeg|png',
                'file_name'        => $this->input->post('inquiry_id'),
                'file_ext_tolower' => TRUE
            ];

            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload("image")) { 
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                return redirect($this->redirect);
            }else{
                $img = $this->upload->data("file_name");
            }
        } */
        
        $inq_id = d_id($this->input->post('inquiry_id'));
        $post = $this->input->post();
        unset($post['inquiry_id']);
        $status = json_encode($post);
        // $status = implode(", ", $this->input->post('status'));
        /* if ($this->input->post('sms') === 'yes') {
            $mobile = $this->main->check($this->table, ['id' => $inq_id], 'mobile');
            $sms = 'Your second installment is due in next 2 days. Failure of the timely payment will result in revoking of the profile. Kindly make the payment. Ignore if already paid.';
            send_sms($sms, $mobile);
        } */
        
        $id = $this->main->update(['id' => $inq_id], ['updated_at' => date("Y-m-d H:i:s"), 'status' => $status], $this->table);

        if ($id){
            $post = [
                    'inq_id'     => $inq_id,
                    'remarks'    => "Status updated.",
                    'created_by' => $this->id,
                    'counselor'  => $this->id,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            
            $this->main->add($post, 'inquery_logs');
        }

        flashMsg($id, "Status updated Successfully.", "Status Not updated. Try again.", $this->redirect);
    }

    public function error_404()
    {
        $this->load->view('error_404');
    }

    public function fees_check($fee)
    {
        $remaining = str_replace('₹ ', '', $this->input->post('remaining'));
        
        if ($fee && $remaining && $fee > $remaining)
        {
            $this->form_validation->set_message('fees_check', '%s shold be less than or equal to remaining fees.');
            return FALSE;
        } else
            return TRUE;
    }

    protected $visitor = [
        [
            'field' => 'inquiry_country',
            'label' => 'Country Of Visit',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'dob',
            'label' => 'Date Of Birth',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'purpose',
            'label' => 'Purpose Of Visit',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}
