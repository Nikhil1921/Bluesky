<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Ielts_batch_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "ielts_batch b";  
	public $select_column = ['b.id', 'b.batch_name', 'b.from_date', 'b.to_date', 'b.from_time', 'b.to_time', 'a.name', 'b.coach_id'];
	public $search_column = ['b.batch_name', 'b.from_date', 'b.to_date', 'b.from_time', 'b.to_time', 'a.name'];
    public $order_column = [null, 'b.batch_name', 'b.from_date', 'b.to_date', 'b.from_time', 'b.to_time', 'a.name', null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['b.is_deleted' => 0])
            ->join('admins a', 'a.id = b.coach_id', 'left');
        
        if (in_array($this->role, ['IELTS Coaching']))
            $this->db->where(['b.coach_id' => $this->id]);
        
        $this->database();
	}
}