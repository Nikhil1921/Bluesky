<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Users_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "admins u";  
	public $select_column = ['u.id', 'u.name', 'u.mobile', 'u.email', 'u.role'];
	public $search_column = ['u.name', 'u.mobile', 'u.email', 'u.role'];
    public $order_column = [null, 'u.name', 'u.mobile', 'u.email', 'u.role', null];
	public $order = ['u.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['u.is_deleted' => 0]);
            
        if (in_array($this->role, ['LMS']))
            $this->db->where(['u.role' => 'LMS Employee']);
        else if (in_array($this->role, ['IELTS Operation']))
            $this->db->where(['u.role' => 'IELTS Coaching']);
        else
            $this->db->where(['u.role != ' => 'Super Admin']);
        
        $this->database();
	}
}