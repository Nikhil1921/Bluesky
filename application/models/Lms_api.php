<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class Lms_api extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

    private $table = 'inquiry';

	public function lead_list($api)
	{
		$select = ['l.id', 'l.name', 'l.mobile', 'l.email','l.created_at', 'c.country_name', 'c.visa_type', 'l.remarks'];
		
		$data = $this->db->select($select)
                         ->from($this->table.' l')
                         ->where(['l.is_deleted' => 0, "l.assigned" => $api, 'client_type' => 'Lead'])
                         ->where(['l.is_new' => 0, 'l.is_archived' => 0])
						 ->join('country c', 'c.id = l.inquiry_country')
                         ->join('follow_ups f', 'f.lead_id = l.id', 'left')
                         ->group_by('l.id')
                         ->get()
                         ->result();

		return $data;
	}
}