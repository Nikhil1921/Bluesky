<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Followup_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

    public $table = "follow_ups f";
    public $select_column = ['l.id', 'l.name', 'l.mobile', 'l.email', 'f.follow_date', 'f.follow_time', 'f.created_at', 'f.status', 'f.remarks'];
    public $search_column = ['l.name', 'l.mobile', 'l.email', 'f.follow_date', 'f.follow_time', 'f.created_at', 'f.status', 'f.remarks'];
    public $order_column = [null, 'l.name', 'l.mobile', 'l.email', 'f.follow_date', 'f.follow_time', 'f.created_at', 'f.status', 'f.remarks', null];
    public $order = ['l.id' => 'DESC'];
    
	public function make_query()
    {  
        $que = "f.id IN (SELECT MAX(id) FROM follow_ups WHERE status != 'Not Interested' AND is_closed = '0'";
        if (in_array($this->role, ['LMS Employee', 'Reception']))
            $que .= " AND assigned = '".$this->id."'";

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date)));
            $to = date('Y-m-d', strtotime(end($date)));

            $que .= " AND f.follow_date BETWEEN '$from' AND '$to'";
        }else{
            $date = date('Y-m-d');
            $que .= " AND f.follow_date = '$date'";
        }
        if ($this->input->post('lmsemp')){
            $lms = d_id($this->input->post('lmsemp'));
            $que .= " AND f.created_by = '$lms'";
        }
        
        $que .= " GROUP BY lead_id)";
        
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where($que)
            ->join('inquiry l', 'l.id = f.lead_id');

        $i = 0;

        foreach ($this->search_column as $item)
        {
            if($_POST['search']['value'])
            {
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->search_column) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count()
    {
        $count = "f.id IN (SELECT MAX(id) FROM follow_ups WHERE status != 'Not Interested' AND is_closed = '0'";
        
        if (in_array($this->role, ['LMS Employee', 'Reception']))
            $count .= " AND assigned = '".$this->id."' ";

        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date)));
            $to = date('Y-m-d', strtotime(end($date)));

            $count .= " AND f.follow_date BETWEEN '$from' AND '$to'";
        }else{
            $date = date('Y-m-d');

            $count .= " AND f.follow_date = '$date'";
        }

        if ($this->input->post('lmsemp')){
            $lms = d_id($this->input->post('lmsemp'));
            $count .= " AND f.created_by = '$lms'";
        }
        
        $count .= " GROUP BY lead_id)";

        return $this->db->select($this->select_column)
            ->from($this->table)
            ->where($count)
            ->join('inquiry l', 'l.id = f.lead_id')
            ->get()
            ->num_rows();
    }

    public function getFollowup()
    {
        $id = d_id($this->input->post('id'));
        $query = $this->db->select('fu.created_at visit_date, fu.remarks, i.name, i.mobile, i.email,i.created_at first_visit, c.country_name, c.visa_type, fu.status') 
                        ->from("follow_ups fu")
                        ->where(['fu.created_by' => $id])
                        ->join('inquiry i', 'i.id = fu.lead_id')
                        ->join('country c', 'c.id = i.inquiry_country');
        
        if ($this->input->post('page_entry') != 'All')
            $this->db->limit($this->input->post('page_entry'));

        if ($this->input->post('daterangereport')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterangereport')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("fu.created_at BETWEEN '$from' AND '$to'");
        }
        
        $query = $this->db->get()->result_array();
        return $query;
    }
}