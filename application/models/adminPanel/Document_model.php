<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Document_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "document d";  
	public $select_column = ['d.id', 'd.document'];
	public $search_column = ['d.document'];
    public $order_column = [null, 'd.document', null];
	public $order = ['d.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['d.is_deleted' => 0]);
        
        $this->database();
	}
}