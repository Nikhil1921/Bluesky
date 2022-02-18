<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Book_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "book b";
	public $select_column = ['b.id', 'b.book', 'CONCAT("assets/images/books/", b.image) image', 'i.name', 'i.mobile', 'b.current_issue', 'b.return_date'];
	public $search_column = ['b.book', 'b.image', 'i.name', 'i.mobile'];
    public $order_column = [null, 'b.book', null, 'i.name', 'i.mobile', 'b.return_date', null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['b.is_deleted' => 0])
            ->join('inquiry i', 'i.id = b.current_issue', 'left');
        
        $this->database();
	}

	public function getHistory()
	{
		$id = d_id($this->input->post('id'));
		return $this->db->select('i.name, i.mobile, i.email, a.name issued_by, bl.created_at issued_at, bl.issue_type, bl.remarks')
                        ->from('book_logs bl')
                        ->where(['bl.book_id' => $id])
                        ->join('inquiry i', 'i.id = bl.user_id', 'left')
                        ->join('admins a', 'a.id = bl.issued_by', 'left')
                        ->get()
                        ->result();
	}
}