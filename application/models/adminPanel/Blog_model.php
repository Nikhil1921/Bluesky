<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Blog_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "blog b";
	public $select_column = ['b.id', 'b.title', 'CONCAT("assets/images/blog/", b.image) image'];
	public $search_column = ['b.title', 'b.image'];
    public $order_column = [null, 'b.title', null, null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['b.is_deleted' => 0]);
        
        $this->database();
	}
}