<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Country_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "country c";
	public $select_column = ['c.id', 'c.country_name', 'c.visa_type'];
	public $search_column = ['c.country_name', 'c.visa_type'];
    public $order_column = [null, 'c.country_name', 'c.visa_type', null];
	public $order = ['c.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['c.is_deleted' => 0]);
        
        $this->database();
	}
}