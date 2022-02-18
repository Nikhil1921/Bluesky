<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Material_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "material m";
	public $select_column = ['m.id', 'm.title'];
	public $search_column = ['m.title'];
    public $order_column = [null, 'm.title', null];
	public $order = ['m.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['m.is_deleted' => 0]);
        
        $this->database();
	}
}