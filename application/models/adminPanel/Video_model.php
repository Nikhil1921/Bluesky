<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Video_model extends MY_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "video v";
	public $select_column = ['v.id', 'v.video_title', 'v.video_url'];
	public $search_column = ['v.video_title', 'v.video_url'];
    public $order_column = [null, 'v.video_title', 'v.video_url', null];
	public $order = ['v.id' => 'DESC'];

	public function make_query()
	{  
        $this->db->select($this->select_column)
             	 ->from($this->table)
             	 ->where(['is_deleted' => 0]);
        
        $this->database();
	}
}