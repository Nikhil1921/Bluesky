<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Installment_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "inquiry i";
	public $select_column = ['i.id', 'i.name', 'i.mobile', 'i.email', 'i.fees', 'i.ielts_fees', '(i.fees + i.ielts_fees) total_fees'];
	public $search_column = ['i.id', 'i.name', 'i.mobile', 'i.email', 'i.fees', 'i.ielts_fees'];
    public $order_column = [null, 'i.id', 'i.name', 'i.mobile', 'i.email', 'i.fees', 'i.ielts_fees', null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['i.is_deleted' => 0, '(i.fees + i.ielts_fees) >' => 0]);

        $this->database();
	}

	public function count()
	{
		$this->db->select('i.id')
	             	->from($this->table)
		            ->where(['i.is_deleted' => 0, '(i.fees + i.ielts_fees) >' => 0]);

		return $this->db->get()->num_rows();
	}
}