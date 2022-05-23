<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Inquiry_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "inquiry i";
	public $select_column = ['i.id', 'i.name', 'i.mobile', 'i.email','i.created_at', 'i.updated_at', 'c.country_name', 'c.visa_type', 'i.reference', 'i.client_type', 'i.inquiry_country', 'i.remarks'];
	public $search_column = ['i.name', 'i.mobile', 'i.email','i.created_at', 'i.updated_at', 'c.country_name', 'c.visa_type', 'i.reference', 'i.client_type'];
    public $order_column = [null, 'i.name', 'i.mobile', 'i.email','i.created_at', 'i.updated_at', 'c.country_name', 'c.visa_type', 'i.reference', 'i.client_type', null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['i.is_deleted' => $this->input->post('archive')])
            ->join('inquery_logs il', 'il.inq_id = i.id', 'left')
            ->join('country c', 'c.id = i.inquiry_country')
            ->group_by('i.id');

        if ($this->input->post('client_type'))
            $this->db->where(['i.client_type' => $this->input->post('client_type')]);

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("il.created_at BETWEEN '$from' AND '$to'");
        }

        if ($this->input->post('today')) {
            $date = $this->input->post('today');
            $this->db->where("il.created_at = '$date'");
        }
        
        $this->database();
	}

    public function count()
    {
        $this->db->select('i.id')
                ->from($this->table)
                ->where(['i.is_deleted' => $this->input->post('archive')])
                ->join('inquery_logs il', 'il.inq_id = i.id', 'left')
                ->group_by('i.id');
        
        if ($this->input->post('client_type'))
            $this->db->where(['i.client_type' => $this->input->post('client_type')]);

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("il.created_at BETWEEN '$from' AND '$to'");
        }

        if ($this->input->post('today')) {
            $date = $this->input->post('today');
            $this->db->where("il.created_at = '$date'");
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getHistory()
    {
        $id = d_id($this->input->post('id'));
        return $this->db->select('i.created_at, a.name, i.remarks, c.name created_by') 
                        ->from("inquery_logs i")
                        ->where(['i.inq_id' => $id])
                        ->join('admins a', 'a.id = i.counselor', 'left')
                        ->join('admins c', 'c.id = i.created_by', 'left')
                        ->get()->result();
    }

    public function getInqury()
    {
        $id = d_id($this->input->post('id'));
        $query = $this->db->select('il.created_at visit_date, a.name counselor, i.name, i.mobile, i.email,i.created_at first_visit, c.country_name, c.visa_type, i.reference, il.remarks')
                        ->from("inquery_logs il")
                        ->where(['il.created_by' => $id])
                        ->join('admins a', 'a.id = il.counselor')
                        ->join('inquiry i', 'i.id = il.inq_id')
                        ->join('country c', 'c.id = i.inquiry_country');
        
        if ($this->input->post('page_entry') != 'All')
            $this->db->limit($this->input->post('page_entry'));

        if ($this->input->post('daterangereport')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterangereport')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("il.created_at BETWEEN '$from' AND '$to'");
        }
        
        $query = $this->db->get()->result_array();
        
        return $query;
    }

    public function getClient($id)
    {
        return $this->db->select($this->select_column)
                        ->from($this->table)
                        ->where(['i.id' => $id])
                        ->join('country c', 'c.id = i.inquiry_country')
                        ->get()->row_array();
    }

    public function visa_type($id)
    {
        return $this->db->select($this->select_column)
                        ->from($this->table)
                        ->where(['i.id' => $id])
                        ->join('country c', 'c.id = i.inquiry_country')
                        ->get()->row_array();
    }

    public function getInquiry($id, $visa)
    {
        switch ($visa) {
            case 'Visitor':
            case 'IELTS':
                return $this->db->select('i.id, i.name, i.mobile, i.email, c.country_name, c.visa_type, c.id c_id, v.dob, v.purpose, v.documents, i.created_at, i.ielts, i.batch, i.grammer')
                        ->from('inquiry i')
                        ->where(['i.id' => $id])
                        ->join('country c', 'c.id = i.inquiry_country')
                        ->join('visitor_visa v', 'v.i_id = i.id', 'left')
                        ->get()
                        ->row_array();
                break;
            
            case 'Student':
                return $this->db->select('i.id, i.name, i.mobile, i.email, c.country_name, c.visa_type, c.id c_id, v.dob, v.documents, i.created_at, v.education, v.back_log, v.language_data, v.overall_band, i.ielts, i.batch, i.grammer')
                        ->from('inquiry i')
                        ->where(['i.id' => $id])
                        ->join('country c', 'c.id = i.inquiry_country')
                        ->join('student_visa v', 'v.i_id = i.id', 'left')
                        ->get()
                        ->row_array();
                break;
            
            case 'Permanent-Residency':
                return $this->db->select('i.id, i.name, i.mobile, i.email, c.country_name, c.visa_type, c.id c_id, v.dob, v.documents, v.status, v.education, v.work_experience, v.work_position_held, v.work_total_experience, v.language_data, v.spouse_name, v.spouse_date, v.tef_status, v.comprehenstion, v.exprestion, v.spouse_education, v.spouse_work_position_held, v.spouse_work_total_experience, v.spouse_language_data, v.overall_band, v.spouse_overall_band, v.french_status, v.spouse_documents, i.created_at, v.spouse_status, i.ielts, i.batch, i.grammer')
                        ->from('inquiry i')
                        ->where(['i.id' => $id])
                        ->join('country c', 'c.id = i.inquiry_country')
                        ->join('pr_visa v', 'v.i_id = i.id', 'left')
                        ->get()
                        ->row_array();
                break;
            
            default:
                return [];
                break;
        }
    }

    public function getStatus()
    {
        $id = d_id($this->input->get('id'));
        return $this->db->select('status, status_type')
                        ->from('inquiry i')
                        ->where(['i.id' => $id])
                        ->join('country c', 'i.inquiry_country = c.id')
                        ->get()
                        ->row_array();
    }

    public function viewBatch()
    {
        $id = d_id($this->input->post('id'));
        
        return $this->db->select('id, name, mobile, email, grammer')
                        ->from('inquiry')
                        ->where(['batch' => $id])
                        ->get()
                        ->result_array();
    }
}