<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Consulting_model extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "inquiry i";
	public $select_column = ['i.id', 'i.name', 'i.mobile', 'i.email','i.created_at', 'i.updated_at', 'c.country_name', 'c.visa_type', 'i.reference', 'i.client_type', 'i.ielts', 'i.cred_create'];
	public $search_column = ['i.name', 'i.mobile', 'i.email','i.created_at', 'i.updated_at', 'c.country_name', 'c.visa_type', 'i.reference', 'i.client_type'];
    public $order_column = [null, 'i.name', 'i.mobile', 'i.email','i.created_at', 'i.updated_at', 'c.country_name', 'c.visa_type', 'i.reference', 'i.client_type', null, null];
	public $order = ['il.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['i.is_deleted' => $this->input->post('archive')])
            ->join('inquery_logs il', 'il.inq_id = i.id', 'left')
            ->join('country c', 'c.id = i.inquiry_country', 'left')
            ->group_by('i.id');

        if ($this->input->post('client_type'))
        	$this->db->where(['i.client_type' => $this->input->post('client_type')]);

        if (in_array($this->role, ['Consultant']))
        	$this->db->where(['il.counselor' => $this->id]);

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("il.created_at BETWEEN '$from' AND '$to'");
        }else{
        	$from = date('Y-m-d').' 00:00:00';
            $to = date('Y-m-d').' 23:59:59';
            if ($_SERVER["HTTP_HOST"] !== 'localhost')
        		$this->db->where("il.created_at BETWEEN '$from' AND '$to'");
        }

        if ($this->input->post('lmsemp'))
            $this->db->where(['il.created_by' => d_id($this->input->post('lmsemp'))]);

        $this->database();
	}

    public function count()
    {
        $this->db->select('i.id')
                ->from($this->table)
                ->where(['i.is_deleted' => $this->input->post('archive') ? $this->input->post('archive') : 0])
                ->join('inquery_logs il', 'il.inq_id = i.id', 'left')
                ->group_by('i.id');
        
        if ($this->input->post('client_type'))
        	$this->db->where(['i.client_type' => $this->input->post('client_type')]);

        if (in_array($this->role, ['Consultant']))
        	$this->db->where(['il.counselor' => $this->id]);

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("il.created_at BETWEEN '$from' AND '$to'");
        }else{
        	$from = date('Y-m-d').' 00:00:00';
            $to = date('Y-m-d').' 23:59:59';
            if ($_SERVER["HTTP_HOST"] !== 'localhost')
        		$this->db->where("il.created_at BETWEEN '$from' AND '$to'");
        }

        if ($this->input->post('lmsemp'))
            $this->db->where(['il.created_by' => d_id($this->input->post('lmsemp'))]);

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
}