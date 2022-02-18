<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Lead extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->role, $this->access)) 
            return redirect(admin('unauthorized'));
    }

	protected $name = 'lead';
    protected $title = 'lead';
    private $table = "inquiry";
    protected $redirect = "lead";
    protected $access = ['Operation', 'Super Admin', 'LMS'];

	public function index()
	{
        $data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['access'] = $this->access;
        $data['dataTables'] = TRUE;
        $data['daterangepicker'] = TRUE;
        $data['lms'] = $this->main->getall('admins', 'id, name', "is_blocked = 0 AND is_deleted = 0 AND (role = 'LMS Employee' OR role = 'Reception')");

        $this->template->load(admin('template'), $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables(admin('lead_model'));
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
            $sub_array[] = ucwords($row->country_name);
            $sub_array[] = ucwords($row->visa_type);

            /*$action = '<div class="ml-0 table-display row">'.form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'onclick' => "viewFollowUps(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#history"]);
            
            if (in_array($this->role, ['LMS']))
                $action .= form_button([ 'content' => '<i class="fas fa-user"></i>','type'  => 'button','class' => 'mr-2 btn btn-outline-primary', 'onclick' => "consultant(".e_id($row->id).")", 'data-toggle' => "modal", 'data-target' => "#asign-consultant"]);

            $action .= '</div>';
            $sub_array[] = $action;*/
            $sub_array[] = e_id($row->id);

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        $this->load->model(admin('lead_model'));

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->lead_model->count(),
            "recordsFiltered"   => $this->main->get_filtered_data(admin('lead_model')),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        ];
        
        echo json_encode($output);
    }

    public function import()
    {
        if (!in_array($this->role, ['LMS']))
            return redirect(admin('unauthorized'));

        /*$this->form_validation->set_rules($this->validate);*/
        if(!empty($_FILES["lead"]["name"]))
        /*if($this->form_validation->run() === TRUE && !empty($_FILES["lead"]["name"]))*/
        {
            // ini_set('max_execution_time', 0);
            set_time_limit(0);
            $path = $_FILES["lead"]["tmp_name"];
            $object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row <= $highestRow; $row++)
                {
                    $check = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    if (ucwords($check) === 'Visitor Visa')
                        $visa = 'Visitor';
                    else if (ucwords($check) === 'Student Visa')
                        $visa = 'Student';
                    else if (ucwords($check) === 'Permanent Residency')
                        $visa = 'Permanent Residency';
                    else
                        $visa = 'IELTS';
                    
                    $data = [
                        'name'            => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                        'mobile'          => str_replace(" ", "", $worksheet->getCellByColumnAndRow(4, $row)->getValue()),
                        'email'           => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                        'inquiry_country' => $this->main->check('country', ['visa_type' => $visa, 'is_deleted' => 0], 'id'),
                        'created_at'      => date("Y-m-d H:i:s"),
                        'updated_at'      => date("Y-m-d H:i:s"),
                        'client_type'     => 'Lead',
                        'reference'       => 'LMS',
                        'remarks'         => $check,
                        'created_by'      => $this->id
                    ];
                    
                    $len = strlen($data['mobile']);

                    if ($len > 10)
                        $data['mobile'] = substr($data['mobile'], ($len - 10));

                    if (!$this->main->check($this->table, ['mobile' => $data['mobile'], 'is_deleted' => 0], 'id')) {
                        
                        $id = $this->main->add($data, $this->table);
                        
                        if ($id) {
                            $post = [
                                        'lead_id'     => $id,
                                        'follow_date' => date('Y-m-d'),
                                        'follow_time' => date('H:i:s', strtotime($data['created_at'])),
                                        'remarks'     => "Lead Created.",
                                        'created_by'  => $this->id,
                                        'created_at'  => $data['created_at'],
                                        'status'      => "Lead Created"
                                    ];
                            
                            $this->main->add($post, 'follow_ups');
                        }
                    }
                    
                    /*$check = $this->main->check($this->table, ['mobile' => $data['mobile'], 'is_deleted' => 0], 'id');

                    if (!$check)
                        $id = $this->main->update(['id' => $check], $data, $this->table);
                    else{
                        $check = $id = $this->main->add($data, $this->table);
                        if ($id) {
                            $post = [
                                        'lead_id'     => $check,
                                        'follow_date' => date('Y-m-d'),
                                        'follow_time' => date('H:i:s', strtotime($data['created_at'])),
                                        'remarks'     => "Lead Created.",
                                        'created_by'  => $this->id,
                                        'created_at'  => $data['created_at'],
                                        'status'      => "Lead Created"
                                    ];
                            
                            $this->main->add($post, 'follow_ups');
                        }
                    }*/
                }
            }
            
	        flashMsg(
	            $id, ucwords($this->title).' Imported Successfully.', ucwords($this->title).' Not Imported, Please Try Again.', $this->redirect
	                );
        }else{
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "import";
            $data['url'] = $this->redirect;
            
            return $this->template->load(admin('template'), $this->redirect.'/import', $data);
        }
    }

    public function lms()
    {
    	$lms = d_id($this->input->post('lms'));
        $lead_id = d_id($this->input->post('id'));
        $date = date("Y-m-d H:i:s");
        $id = $this->main->update(['id' => $lead_id], ['assigned' => $lms, 'is_new' => 0, 'updated_at' => $date], $this->table);

        if ($id) {
            $post = [
                        'lead_id'     => $lead_id,
                        'follow_date' => date('Y-m-d'),
                        'follow_time' => date('H:i:s', strtotime($date)),
                        'remarks'     => "Lead assigned.",
                        'created_by'  => $this->id,
                        'created_at'  => $date,
                        'status'      => "Assigned To LMS Employee"
                    ];
            
            $this->main->add($post, 'follow_ups');
            
            echo "All leads assigned to : ".ucwords($this->main->check('admins', ['id' => $lms], 'name'));
        }else
            echo "Something went wrong.";
    }

    protected $validate = [
        [
            'field' => 'lead_type',
            'label' => 'Lead Type',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'lead_country',
            'label' => 'Lead Country',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}