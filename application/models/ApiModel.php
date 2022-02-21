<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class ApiModel extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

    private $table = 'inquiry';

	public function profile($api)
	{
		$select = 'name, mobile, email, inquiry_country, status, fees, ielts_fees, batch, grammer, status_image, remarks, ielts, grammer, c.country_name, c.visa_type';
		
		$data = $this->db->select($select)
                         ->from($this->table.' i')
                         ->where(['i.is_deleted' => 0, 'i.id' => $api])
						 ->join('country c', 'c.id = i.inquiry_country')
                         ->get()
                         ->row();
		
		switch ($data->visa_type) {
            case 'Visitor':
            case 'IELTS':
                $data->data = $this->db->select('v.dob, v.purpose, v.documents')
										->from('visitor_visa v')
										->where(['v.i_id' => $api])
										->get()
										->row();
                break;
            
            case 'Student':
                $data->data = $this->db->select('v.dob, v.documents, v.education, v.back_log, v.language_data, v.overall_band')
										->from('student_visa v')
										->where(['v.i_id' => $api])
										->get()
										->row();
                break;
            
            case 'Permanent Residency':
                $data->data = $this->db->select('v.dob, v.documents, v.status, v.education, v.work_experience, v.work_position_held, v.work_total_experience, v.language_data, v.spouse_name, v.spouse_date, v.tef_status, v.comprehenstion, v.exprestion, v.spouse_education, v.spouse_work_position_held, v.spouse_work_total_experience, v.spouse_language_data, v.overall_band, v.spouse_overall_band, v.french_status, v.spouse_documents, v.spouse_status')
										->from('pr_visa v')
										->where(['v.i_id' => $api])
										->get()
										->row();
                break;
            
            default:
                $data->data = [];
                break;
        }

		return $data;
	}
}