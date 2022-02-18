<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Fees_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "inquiry i";
	public $select_column = ['i.id', 'i.name', 'i.mobile', 'i.email', 'i.fees', 'i.ielts_fees', '(i.fees + i.ielts_fees - SUM(f.fees)) remain_fees', 'f.pay_type'];
	public $search_column = ['i.id', 'i.name', 'i.mobile', 'i.email', 'i.fees', 'i.ielts_fees', 'f.pay_type'];
    public $order_column = [null, 'i.id', 'i.name', 'i.mobile', 'i.email', 'i.fees', 'i.ielts_fees', null, null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['i.is_deleted' => 0])
            ->join('fee_logs f', 'f.inq_id = i.id')
            ->group_by('f.inq_id');
        
        if ($this->input->post('daterange')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
            $from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
            $to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

            $this->db->where("f.created_at BETWEEN '$from' AND '$to'");
        }
        
        if ($this->input->post('pay_type')) {
            $this->db->where(["f.pay_type" => $this->input->post('pay_type')]);
        }

        $this->database();
	}

	public function count()
	{
		$this->db->select('i.id')
	             	->from($this->table)
		            ->where(['i.is_deleted' => 0])
		            ->join('fee_logs f', 'f.inq_id = i.id')
		            ->group_by('f.inq_id');
		
		if ($this->input->post('daterange')) {
			$date = explode("-", str_replace(" ", "", $this->input->post('daterange')));
			$from = date('Y-m-d', strtotime(reset($date))).' 00:00:00';
			$to = date('Y-m-d', strtotime(end($date))).' 23:59:59';

			$this->db->where("f.created_at BETWEEN '$from' AND '$to'");
		}

        if ($this->input->post('pay_type')) {
            $this->db->where(["f.pay_type" => $this->input->post('pay_type')]);
        }

		return $this->db->get()->num_rows();
	}

	public function viewFees($id)
	{
		$id = d_id($id);
		return $this->db->select('f.fees, f.remarks, f.created_at, f.fee_type, a.name')
                        ->from('fee_logs f')
                        ->where(['f.inq_id' => $id])
                        ->join('admins a', 'a.id = f.created_by', 'left')
                        ->get()
                        ->result();
	}
}