<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Today_installment_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "inquiry i";
	public $select_column = ['i.id', 'i.name', 'i.mobile', 'i.email', 'in.fees'];
	public $search_column = ['i.id', 'i.name', 'i.mobile', 'i.email', 'in.fees'];
    public $order_column = [null, 'i.id', 'i.name', 'i.mobile', 'i.email', 'in.fees', null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['i.is_deleted' => 0, '(i.fees + i.ielts_fees) >' => 0, 'fees_date' => date('Y-m-d'), 'in.status' => 'Pending'])
            ->join('installment in', 'in.inq_id = i.id')
            ->group_by('i.id');
 
        $this->database();
	}

	public function count()
	{
		$this->db->select('i.id')
	             ->from($this->table)
			     ->where(['i.is_deleted' => 0, '(i.fees + i.ielts_fees) >' => 0, 'fees_date' => date('Y-m-d'), 'in.status' => 'Pending'])
			     ->join('installment in', 'in.inq_id = i.id')
			     ->group_by('i.id');

		return $this->db->get()->num_rows();
	}
}