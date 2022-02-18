<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class News_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "news n";
	public $select_column = ['n.id', 'n.news', 'CONCAT("assets/images/news/", n.image) image'];
	public $search_column = ['n.news', 'n.image'];
    public $order_column = [null, 'n.news', null, null];
	public $order = ['n.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)
             	 ->from($this->table)
             	 ->where(['is_deleted' => 0]);
        
        $this->database();
	}
}