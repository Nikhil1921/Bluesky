<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'inquiry';
    protected $title = 'inquiry';
    private $table = "inquiry";
    protected $redirect = "inquiry";
    protected $access = ['Operation', 'Super Admin', 'Reception'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['counselors'] = $this->main->getall('admins', 'id, name', ['role' => 'Counselor', 'is_blocked' => 0, 'is_deleted' => 0]);
        $data['ielts'] = $this->main->getall('admins', 'id, name', ['role' => 'IELTS Operation', 'is_blocked' => 0, 'is_deleted' => 0]);

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('inquiry_model'));
        $sr = $_POST['start'] + 1;
        $data = array();
        
        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = date('d-m-Y', strtotime($row->created_at));
            $sub_array[] = date('d-m-Y h:i A', strtotime($row->updated_at));
            $sub_array[] = ucwords($row->country_name);
            $sub_array[] = ucwords($row->visa_type);
            $sub_array[] = ucfirst($row->reference);
            $sub_array[] = $row->client_type;

            $action = '<div class="ml-0 table-display row">'.form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'onclick' => "viewHistory(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);
            
            if (in_array($this->role, ['Reception'])) 
                $action .= form_button([ 'content' => '<i class="fas fa-user"></i>','type'  => 'button','class' => 'mr-2 btn btn-outline-primary', 'onclick' => "counselor(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-counselor"]);

            $action .= '</div>';
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('inquiry_model'), 'inquiry');

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->inquiry->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('inquiry_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function add()
    {
        if (!in_array($this->role, ['Reception']))
            return redirect(admin('unauthorized'));

        $this->form_validation->set_rules($this->validate);
        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "add";
            $data['url'] = $this->redirect;
            $data['select'] = TRUE;
            $data['counselors'] = $this->main->getall('admins', 'id, name', ['role' => 'Counselor', 'is_blocked' => 0, 'is_deleted' => 0]);
            $data['ielts'] = $this->main->getall('admins', 'id, name', ['role' => 'IELTS Operation', 'is_blocked' => 0, 'is_deleted' => 0]);
            
            return $this->template->load(admin('template'), $this->redirect.'/add', $data);
        }
        else
        {
            $post = [
                'name'            => $this->input->post('name'),
                'mobile'          => $this->input->post('mobile'),
                'email'           => $this->input->post('email'),
                'inquiry_country' => d_id($this->input->post('inquiry_country')),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
                'created_by'      => $this->id,
                'client_type'     => 'Inquiry',
                'ielts'           => ($this->input->post('ielts')) ? 1 : 0,
                'reference'       => ($this->input->post('reference')) ? $this->input->post('reference') : 'Walking'
            ];
            
            $id = $this->main->add($post, $this->table);
            
            if ($id) {
                /*if ($post['ielts'])
                    $remark = ($this->input->post('remarks')) ? 'Assigned to IELTS - '.$this->input->post('remarks') : 'Assigned to IELTS';
                else
                    $remark = ($this->input->post('remarks')) ? $this->input->post('remarks') : null;*/

                $inq = [
                    'inq_id'      => $id,
                    'created_by'  => $this->id,
                    'counselor'   => ($post['ielts']) ? d_id($this->input->post('ielts')) : d_id($this->input->post('counselor')),
                    'remarks'     => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                    'created_at'  => $post['created_at']
                ];

                $this->main->add($inq, 'inquery_logs');
            }

            flashMsg($id, ucwords($this->title)." Added Successfully.", ucwords($this->title)." Not Added. Try again.", $this->redirect);
        }
    }

    public function counselor()
    {
        if (!$this->input->post('inquiry_id') || (!$this->input->post('counselor') && !$this->input->post('ielts'))) 
            flashMsg(0, "", "Something not going good. Try again.", $this->redirect);
        
        $emp = ($this->input->post('ielts')) ? $this->input->post('ielts') : $this->input->post('counselor');

        $post = [
                'inq_id'     => d_id($this->input->post('inquiry_id')),
                'created_by' => $this->id,
                'counselor'  => d_id($emp),
                'remarks'    => ($this->input->post('remarks')) ? $this->input->post('remarks') : null,
                'created_at' => date("Y-m-d H:i:s")
            ];
        
        $id = $this->main->add($post, 'inquery_logs');
        
        if ($id)
            $this->main->update(['id' => $post['inq_id']], ['updated_at' => $post['created_at'], 'ielts' => ($this->input->post('ielts')) ? 1 : 0], $this->table);

        flashMsg($id, "Inquiry Assigned Successfully.", "Inquiry Not Assigned. Try again.", $this->redirect);
    }

    public function counselor_check($str)
    {   
        if (!$str && !$this->input->post('ielts'))
        {
            $this->form_validation->set_message('counselor_check', '%s is Required');
            return FALSE;
        } else
            return TRUE;
    }

    public function today()
    {   
        $data['name'] = 'today';
        $data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['counselors'] = $this->main->getall('admins', 'id, name', ['role' => 'Counselor', 'is_blocked' => 0, 'is_deleted' => 0]);
        $data['ielts'] = $this->main->getall('admins', 'id, name', ['role' => 'IELTS Operation', 'is_blocked' => 0, 'is_deleted' => 0]);

        $this->template->load(admin('template'), $this->redirect.'/today', $data);
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
            'rules' => 'required|exact_length[10]',
            'errors' => [
                'required' => "%s is Required",
                'exact_length' => "%s is invalid"
            ]
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'inquiry_type',
            'label' => 'Inquiry Type',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'inquiry_country',
            'label' => 'Inquiry Country',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'counselor',
            'label' => 'Counselor',
            'rules' => 'callback_counselor_check'
        ]
    ];
}