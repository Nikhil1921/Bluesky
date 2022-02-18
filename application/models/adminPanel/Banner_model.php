<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Banner_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "banners b";
	public $select_column = ['b.id', 'CONCAT("assets/images/banners/", b.image) image'];
	public $search_column = ['b.image'];
    public $order_column = [null, null, null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)
             	 ->from($this->table);
        
        $this->database();
	}
}