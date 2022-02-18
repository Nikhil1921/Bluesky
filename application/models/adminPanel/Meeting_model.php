<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Meeting_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "meeting m";
	public $select_column = ['i.id', 'i.name', 'i.mobile', 'i.email', 'm.meeting_date', 'm.meeting_time'];
	public $search_column = ['i.name', 'i.mobile', 'i.email', 'm.meeting_date', 'm.meeting_time'];
    public $order_column = [null, 'i.name', 'i.mobile', 'i.email', 'm.meeting_date', null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['i.is_deleted' => 0, 'm.meeting_date' => date('Y-m-d')])
            ->join('inquiry i', 'i.id = m.lead_id', 'left')
            ->group_by('i.id');
        
        $this->database();
	}

    public function count()
    {
        $this->db->select('m.id')	
            ->from($this->table)
            ->where(['i.is_deleted' => 0, 'm.meeting_date' => date('Y-m-d')])
            ->join('inquiry i', 'i.id = m.lead_id', 'left')
            ->group_by('i.id');

        $query = $this->db->get();

        return $query->num_rows();
    }
}