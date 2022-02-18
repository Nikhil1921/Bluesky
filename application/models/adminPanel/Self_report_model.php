<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Self_report_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "inquiry l";
	public $select_column = ['l.id', 'l.name', 'l.mobile', 'l.email','l.created_at', 'c.country_name', 'c.visa_type', 'a.name employee', 'l.remarks'];
	public $search_column = ['l.name', 'l.mobile', 'l.email','l.created_at', 'c.country_name', 'c.visa_type', 'a.name'];
    public $order_column = ['l.id', 'l.name', 'l.mobile', 'l.email','l.created_at', 'c.country_name', 'c.visa_type', 'a.name', null];
	public $order = ['l.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['l.is_deleted' => 0, 'f.is_closed' => 1, 'client_type' => 'Lead'])
            ->where(["l.assigned" => $this->id])
            ->join('follow_ups f', 'f.lead_id = l.id', 'left')
            ->join('country c', 'c.id = l.inquiry_country')
            ->join('admins a', 'a.id = l.assigned', 'left')
            ->group_by('l.id');

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("f.created_at BETWEEN '$from' AND '$to'");
        }
        
        $this->database();
	}

    public function count()
    {
        $this->db->select('l.id')
                ->from($this->table)
                ->where(['l.is_deleted' => 0, 'f.is_closed' => 1, 'client_type' => 'Lead'])
                ->where(["l.assigned" => $this->id])
                ->join('follow_ups f', 'f.lead_id = l.id', 'left')
                ->join('country c', 'c.id = l.inquiry_country')
                ->join('admins a', 'a.id = l.assigned', 'left')
                ->group_by('l.id');

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("f.created_at BETWEEN '$from' AND '$to'");
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getHistory()
    {
        $id = d_id($this->input->post('id'));
        return $this->db->select('f.follow_date, f.follow_time, f.remarks, f.created_at, f.status, a.name')
                        ->from("follow_ups f")
                        ->where(['f.lead_id' => $id])
                        ->join('admins a', 'a.id = f.created_by')
                        ->get()->result();
    }
}