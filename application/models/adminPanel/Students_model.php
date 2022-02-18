<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Students_model extends MY_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "inquiry i";
	public $select_column = ['i.id', 'i.name', 'i.mobile', 'i.email','i.grammer', 'b.batch_name'];
	public $search_column = ['i.name', 'i.mobile', 'i.email','i.grammer', 'b.batch_name'];
    public $order_column = [null, 'i.name', 'i.mobile', 'i.email','i.grammer', 'b.batch_name', null, null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['i.is_deleted' => $this->input->post('archive'), 'i.ielts' => 1])
            ->join('ielts_batch b', 'b.id = i.batch', 'left');

        if (in_array($this->role, ['IELTS Coaching']))
        	$this->db->where(['b.coach_id' => $this->id]);

        if ($this->input->post('lmsemp'))
            $this->db->where(['b.coach_id' => d_id($this->input->post('lmsemp'))]);

        $this->database();
	}

    public function count()
    {
        $this->db->select('i.id')
            ->from($this->table)
            ->where(['i.is_deleted' => $this->input->post('archive') ? $this->input->post('archive') : 0, 'i.ielts' => 1])
            ->join('ielts_batch b', 'b.id = i.batch', 'left');

        if (in_array($this->role, ['IELTS Coaching']))
            $this->db->where(['b.coach_id' => $this->id]);

        if ($this->input->post('lmsemp'))
            $this->db->where(['b.coach_id' => d_id($this->input->post('lmsemp'))]);
        

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function viewAttendance()
    {
        $id = d_id($this->input->post('id'));
        return $this->db->select('a.attendance, a.att_date, b.batch_name, c.name coach')
                        ->from('attendance a')
                        ->where(['a.stu_id' => $id])
                        ->join('ielts_batch b', 'b.id = a.batch_id', 'left')
                        ->join('admins c', 'c.id = a.coach_id', 'left')
                        ->get()
                        ->result_array();
    }

    public function getCoaching()
    {
        $id = d_id($this->input->post('id'));
        
        $this->db->select('remarks, created_at')
                 ->from('coach_logs')
                 ->where(['created_by' => $id]);

        if ($this->input->post('page_entry') !== 'All')
            $this->db->limit($this->input->post('page_entry'));

        if ($this->input->post('daterangereport')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterangereport')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("created_at BETWEEN '$from' AND '$to'");
        }

        return $this->db->get()->result_array();
    }
}