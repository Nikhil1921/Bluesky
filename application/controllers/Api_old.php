<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Comman');
        date_default_timezone_set("Asia/Kolkata");
    }
    

	public function visitor_visa()
	{
    	$params = $this->input->post();

		if ($params['name'] == "" || $params['mobile'] == "" || $params['email'] == "") {
			$resp = array('status' => 400,'message' =>  'Name & Mobile No can\'t empty');
		} else {
    		

    		//echo pre($this->input->post());
			$data = array('name'              => $params['name'],
						  'mobile'              => $params['mobile'],
						  'email'              => $params['email'],
						  'created_date'               => date("Y-m-d H:i:s"),
						  'dob'              => $params['dob'],
						  'purpose'              => $params['purpose'],
						   'counrty'              => $params['counrty']);

		    
		    $insert = $this->Comman->insert_data('visitor_visa',$data);

		    if($insert){
			    $resp = array('status' => 200,'message' =>  'Visitor Visa Sent Successfully.');
			    //$this->send_mail_visitor_visa($params);
		    }else{
		    	$resp = array('status' => 200,'message' =>  'Visitor Visa Sent Error..?');
		    }
    	
		}

		json_output(200,$resp);
    	
	}

	public function student_visa()
	{
    	$params = $this->input->post();

		if ($params['name'] == "" ) {
			$resp = array('status' => 400,'message' =>  'Name can\'t empty');
		} else {
    		
    		$data = array('name'              => $params['name'],
						  'mobile'              => $params['mobile'],
						  'dob'              => $params['dob'],
						  'email'              => $params['email'],
						  'education'              => $params['education'],
						  'back_log'              => $params['back_log'],
						  'created_date'               => date("Y-m-d H:i:s"),
						   'counrty'              => $params['counrty'],
						    'overall_band'              => $params['overall_band'],
						 'language_data'              => $params['language_data']);

		    
		    $insert = $this->Comman->insert_data('student_visa',$data);

		    if($insert){
			    $resp = array('status' => 200,'message' =>  'Student Visa Sent Successfully.');
			    //$this->send_mail_student_visa($params,'');
		    }else{
		    	$resp = array('status' => 200,'message' =>  'Student Visa Sent Error..?');
		    }
		}

		json_output(200,$resp);
    	
	}

	public function australia_visa()
	{
    	$params = $this->input->post();

		if ($params['name'] == "") {
			$resp = array('status' => 400,'message' =>  'Name can\'t empty');
		} else {
    		//$this->send_mail_australia_visa($params,''); 
    		$data = array('name'              => $params['name'],
						 'mobile'              => $params['phone'],
							'dob'              => $params['dob'],
							'email'              => $params['email'],
							'created_date'               => date("Y-m-d H:i:s"),
							'status'              => $params['status'],
							'education'              => $params['education'],
							'work_experience'              => $params['work_experience'],
							'work_position_held'              => $params['work_position_held'],
							'work_total_experience'              => $params['work_total_experience'],
							
							'language_data'              => $params['language_data'],
							'spouse_name'              => $params['spousename'],
							'spouse_date'              => $params['spouse_date'],
							'australia_status'              => $params['australia_status'],
							'comprehenstion'              => $params['comprehenstion'],
							'exprestion'              => $params['exprestion'],
							  'overall_band'              => $params['overall_band'],

							'spouse_education'              => $params['spouse_education'],

							'spouse_work_position_held'              => $params['spouse_work_position_held'],
							'spouse_work_total_experience'              => $params['spouse_work_total_experience'],

							'spouse_status'              => $params['spouse_status'],

							'spouse_language_data'              => $params['spouse_language_data'],

							  'spouse_overall_band'  =>$params['spouseoverallband']
						);

		    
		    $insert = $this->Comman->insert_data('australia_visa',$data);

		    if($insert){
			    $resp = array('status' => 200,'message' =>  'Australia Visa Sent Successfully.');
		    }else{
		    	$resp = array('status' => 200,'message' =>  'Australia Visa Sent Error..?');
		    }
		}

		json_output(200,$resp);
    	
	}
	
	
	public function name()
	{
    	$params = $this->input->post();

		if ($params['name'] == "") {
			$resp = array('status' => 400,'message' =>  'Name can empty');
		} else {
    		//$this->send_mail_australia_visa($params,''); 
    		$data = array('name'              => $params['name'],
						    'status'              => $params['status'],
							'dob'              => $params['dob'],
							'email'              => $params['email'],
							'education'              => $params['education'],
							'created_date'               => date("Y-m-d H:i:s")
						);

		    
		    $insert = $this->Comman->insert_data('australia_visa',$data);

		    if($insert){
			    $resp = array('status' => 200,'message' =>  'Australia Visa Sent Successfully.');
		    }else{
		    	$resp = array('status' => 200,'message' =>  'Australia Visa Sent Error..?');
		    }
		}

		json_output(200,$resp);
    	
	}

	public function canada_visa()
	{
    	$params = $this->input->post();

		if ($params['name'] == "" ) {
			$resp = array('status' => 400,'message' =>  'Name can\'t empty');
		} else {
		    
						
    		$data = array('name'              => $params['name'],
						 'mobile'              => $params['phone'],
							'dob'              => $params['dob'],
							'email'              => $params['email'],
							'status'              => $params['status'],
							'education'              => $params['education'],
							'created_date'               => date("Y-m-d H:i:s"),
							'work_experience'              => $params['work_experience'],
							'work_position_held'              => $params['work_position_held'],
							'work_total_experience'              => $params['work_total_experience'],
							
							
							
							
							  'overall_band'              => $params['overall_band'],
							  'spouse_overall_band'  => $params['spouseoverallband'],
							'language_data'              => $params['language_data'],
							'spouse_name'              => $params['spousename'],
							'spouse_date'              => $params['spouse_date'],
							
							'comprehenstion'              => $params['comprehenstion'],
							'exprestion'              => $params['exprestion'],

							'spouse_education'              => $params['spouse_education'],

							'spouse_work_position_held'              => $params['spouse_work_position_held'],
							'spouse_work_total_experience'              => $params['spouse_work_total_experience'],

							'spouse_status'              => $params['spouse_status'],

							'spouse_language_data'              => $params['spouse_language_data'],
							'french_status'              => $params['french_status'],
							'canada_status'              => $params['canada_status'],
							'IELTS_name_1'              => $params['IELTS_name_1'],
							'IELTS_name_2'              => $params['IELTS_name_2'],

							'api_status'              => $params['api_status'],
							'IELTS_exam_self'              => $params['IELTS_exam_self'],
							'IELTS_exam_spouse'              => $params['IELTS_exam_spouse']);

		    
		    $insert = $this->Comman->insert_data('canada_visa',$data);

		    if($insert){
			    $resp = array('status' => 200,'message' =>  'Canada Visa Sent Successfully.');
		    }else{
		    	$resp = array('status' => 200,'message' =>  'Canada Visa Sent Error..?');
		    }
		}

		json_output(200,$resp);
    	
	}



	public function send_mail_visitor_visa($data)
	{ 

		$config = Array(
	          'protocol' => 'smtp',
	          'smtp_host' => 'mail.denseteklearning.com',
	          'smtp_port' => 587,
	          'smtp_user' => 'demo@denseteklearning.com', // change it to yours
	          'smtp_pass' => 'Demo@123', // change it to yours
	          'mailtype' => 'html',
	          'charset' => 'iso-8859-1',
	          'wordwrap' => TRUE
	        );

		$this->email->initialize($config);


		$message= ''; 

		$html = file_get_contents("application/views/visitor_visa.php");
		

		$variables = array(
		        "{{name}}" => $data['name'],
		        "{{mobile}}" => $data['mobile'],
		        "{{dob}}" => $data['dob'],
		        "{{email}}" => $data['email'],
		        "{{purpose}}" => $data['purpose'],
		        "{{counrty}}" => $data['counrty']
		 );

    	foreach ($variables as $key => $value){
        	$html = str_replace($key, $value, $html);
        }
        

        $message .= $html; 
        
        
                	//  echo ($message); exit;


		$this->email->set_newline("\r\n");
	    $this->email->from('demo@denseteklearning.com');
	    $this->email->to($data['email']);
	    $this->email->subject('BlueSky || Visitor Visa || '.$data['name']. ' || '.$data['mobile']);
	    $this->email->message($message);


		//Send mail 
		if($this->email->send()){ 
		
		} else {  
		  
		}

	}

	public function send_mail_student_visa($data,$filename)
	{ 

		$config = Array(
	          'protocol' => 'smtp',
	          'smtp_host' => 'mail.denseteklearning.com',
	          'smtp_port' => 587,
	          'smtp_user' => 'demo@denseteklearning.com', // change it to yours
	          'smtp_pass' => 'Demo@123', // change it to yours
	          'mailtype' => 'html',
	          'charset' => 'iso-8859-1',
	          'wordwrap' => TRUE
	        );

		$this->email->initialize($config);

		    	
		$languge =  json_decode($data['language_data']); 

		if(!empty($languge)){

	    	$overallband_data =  array_chunk((array) $languge[0],100); 
	    	$languge_data =  array_chunk((array) $languge[1],100);
	    	$listening_data =  array_chunk((array) $languge[2],100);
	    	$reading_data =  array_chunk((array) $languge[3],100);
	    	$writting_data =  array_chunk((array) $languge[4],100);
	    	$speaking_data =  array_chunk((array) $languge[5],100);

    	} else {
    		$overallband_data =  []; 
	    	$languge_data =   []; 
	    	$listening_data =   []; 
	    	$reading_data =   []; 
	    	$writting_data =   []; 
	    	$speaking_data =   []; 
    	}



    	$education =  json_decode($data['education']); 


    	if(!empty($education)){

	    	$degree_data =  array_chunk((array) $education[0],100); 
	    	$subject_data =  array_chunk((array) $education[1],100); 
	    	$board_data =  array_chunk((array) $education[2],100); 
	    	$cgpa_data =  array_chunk((array) $education[3],100); 
	    	$passYear_data =  array_chunk((array) $education[4],100);
	    	$medium_data =  array_chunk((array) $education[5],100);

    	} else {
    		$degree_data =  []; 
	    	$subject_data =   []; 
	    	$board_data =   []; 
	    	$cgpa_data =   []; 
	    	$passYear_data =   []; 
	    	$medium_data =   []; 
    	}


		$message= '';

		$message .= '<!DOCTYPE>
						<html>
						  <head>
						    <meta http-equiv="Content-Type" content="
						    text/html; charset=UTF-8"
						     />
						    <title>BlueSky</title>
						    
						    <style>
						      
						    * { margin: 0; padding: 0; }
						    body {
						    font-size: 15px;
						    color: #000;
						    line-height: 22px;
						    font-weight: 400;
						    background: #ffffff;
						    font-family: "Rasa", serif;
						    
						    
						    }
						    #page-wrap { width: 800px; margin: 0 auto; }
						    textarea { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
						    table { border-collapse: collapse; }
						    table td, table th { border: 1px solid black; padding: 5px;     text-align: left;}
						    #header {height: 14px;
						    width: 100%;
						    margin: 20px 0;
						    background: #222;
						    text-align: center;
						    color: white;
						    font: bold 15px Sans-Serif;
						    text-decoration: uppercase;
						    letter-spacing: 5px;
						    padding: 22px 0px;
						    font-size: 20px;
						   font-weight: bold; }
						    #address { width: 316px; height: 150px; float: left; text-align: justify;}
						    #customer { overflow: hidden; }
						    #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; max-height: 100px; overflow: hidden; }
						    #logo:hover, #logo.edit { border: 1px solid #000; margin-top: 0px; max-height: 125px; }
						    #logoctr { display: none; }
						    #logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 5px; }
						    #logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
						    #logohelp input { margin-bottom: 5px; }
						    .edit #logohelp { display: block; }
						    .edit #save-logo, .edit #cancel-logo { display: inline; }
						    .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
						    #customer-title { font-size: 20px; font-weight: bold; float: left;border: 1px solid #000; }
						    .meta-width
						    {
						    width: 49%;
						    
						    }
						    .mr-r
						    {
						    margin:0 2% 0 0;
						    }
						    .mr-b-p
						    {
						    margin-bottom:20px;
						    }
						    #meta {   float:left;  }
						    #meta td.meta-head { text-align: left; background: #eee; }
						    #meta td textarea { width: 100%; height: 20px; text-align: right; }
						    #items { clear: both; width: 100%; }
						    #items th { background: #eee; }
						    #items textarea { width: 80px; height: 50px; }
						    #items tr.item-row td { border: 0; vertical-align: top;border: 1px solid black; }
						    #items td.description { width: 300px; }
						    #items td.item-name { width: 175px; }
						    #items td.description textarea, #items td.item-name textarea { width: 100%; }
						    #items td.total-line { border-right: 0; text-align: right; }
						    #items td.total-value { border-left: 0; padding: 10px; border: 1px solid #000; }
						    #items td.total-value textarea { height: 20px; background: none; }
						    #items td.balance { background: #eee; }
						    #items td.blank { border: 0; }
						    #terms { text-align: center; margin: 20px 0 0 0; }
						    #terms h5 { text-transform: uppercase; font: 13px Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
						    #terms textarea { width: 100%; text-align: center;}
						    textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delete:hover { background-color:#EEFF88; }
						    .delete-wpr { position: relative; }
						    .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px;    font-family: sans-serif; font-size: 12px; }
						    #address1
						    {
						    width: 325px;
						    float: right;
						    margin-top: 15px;
						    }
						    #logo
						    {
						    text-align: right;
						    position: relative;
						    margin-top: 0px;
						    border: 1px solid #fff;
						    max-width: 540px;
						    max-height: 130px;
						    overflow: hidden;
						    }
						    .im
						    {
						      width: 225px;
						    display: block;
						    padding-right: 35px;
						    margin-top: -52px;
						    }
						    .education_title{
						            font-size: 23px;
						    border: 1px solid;
						    padding: 7px;
						    font-weight: bold;
						    }
						    </style>
						  </head>
						  <body>
						    <div id="page-wrap">
						      <p id="header"> Student Visa</p>
						      <div id="identity">
						        <div id="address">
						         
						             <table id="meta" class="meta-width mr-r" style="width: 100%">
						          <tr>
						            <td class="meta-head" style="font-weight: bold;">Name</td>
						            <td> '.$data['name'].'</td>
						          </tr>

						           <tr>
						            <td class="meta-head" style="font-weight: bold;">Email</td>
						            <td> '.$data['email'].'</td>
						          </tr>

						          <tr>
						            <td class="meta-head" style="font-weight: bold;">Contact No</td>
						            <td> '.$data['mobile'].'</td>
						          </tr>
						         
						    
						          <tr>
						            <td class="meta-head" style="font-weight: bold;">Date Of Birth</td>
						             <td>'. $data['dob'].'</td>
						          </tr>
						          <tr>
						            <td class="meta-head" style="font-weight: bold;">Counrty</td>
						            <td>'.$data['counrty'].'</td>
						          </tr>

						        <tr>
						            <td class="meta-head" style="font-weight: bold;">Backlogs</td>
						            <td>'.$data['back_log'].'</td>
						          </tr>
						      </table>
						        </div>

						            <div id="logo">
						                    <div id="logohelp">
						                        <input id="imageloc" type="text" size="50" value=""/><br/>
						                    </div>
						                    <img class="im" id="image" src="http://demo.denseteklearning.com/bluesky/logo.png" alt="logo"/>
						                </div>

						      </div>';

						      if(!empty($degree_data)){
							
							$message .= '<div style="clear:both"></div>
						      <p class="education_title" style="margin-top: 5%">Education Details:</p>
						      <div id="customer">
						      <table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Degree Awarded</th>
						                    <th>Code Subject</th>
						                    <th>Board</th>
						                    <th>CGPA/Percentage</th>
						                    <th>Passing Year</th>
						                    <th>Medium</th>
						                </tr>';

						                foreach ($degree_data[0] as $key => $value) {
						                
						                
								                $message .= '
									                
									                <tr>
									                    <td>
									                       '.$value.'
									                    </td>
									                    <td>
									                         '.$subject_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$board_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$cgpa_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$passYear_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$medium_data[0][$key].'
									                    </td>
									                </tr>';}
						                
						                $message .= '</table></div>';}
 								

								      if(!empty($degree_data)){
									
									$message .= '<div style="clear:both"></div>
						      <p class="education_title" style="margin-top: 35px;">Language Proficiency:</p>
						      <div id="customer">
						      <table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Exam Name</th>
						                    <th>Overall Band</th>
						                    <th>Listening</th>
						                    <th>Reading</th>
						                    <th>Writing</th>
						                    <th>Speaking</th>
						                </tr>';

						                foreach ($languge_data[0] as $key => $value) {
						                	
						               
						                
								                $message .= '<tr>
								                    <td>
								                        '.$value.'
								                    </td>
								                    <td>
								                        '.$overallband_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$listening_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$reading_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$writting_data[0][$key].'
								                    </td>
								                     <td>
								                         '.$speaking_data[0][$key].'
								                    </td>
								                </tr>';

						                 }
						                
						           						                
						    $message .= '</table></div>';}
						  $message .= '
						    
						    </div>
						    
						  </body>
						</html>'; 

		//$message .= 'Your pdf link: ' . base_url()."pdf/visitor_visa/".$filename; 

		$this->email->set_newline("\r\n");
	    $this->email->from('demo@denseteklearning.com');
	    $this->email->to('densetek.nitin@gmail.com');
	    $this->email->subject('BlueSky || Student Visa || '.$data['name']);
	    $this->email->message($message);


		//Send mail 
		if($this->email->send()){ 
		
		} else {  
			
		}

	}


	public function send_mail_australia_visa($data,$filename)
	{ 

		$config = Array(
	          'protocol' => 'smtp',
	          'smtp_host' => 'mail.denseteklearning.com',
	          'smtp_port' => 587,
	          'smtp_user' => 'demo@denseteklearning.com', // change it to yours
	          'smtp_pass' => 'Demo@123', // change it to yours
	          'mailtype' => 'html',
	          'charset' => 'iso-8859-1',
	          'wordwrap' => TRUE
	        );

		$this->email->initialize($config);

		//echo "<pre>"; print_r($data); exit;



		$languge =  json_decode($data['language_data']); 

    	if(!empty($languge)){

	    	$overallband_data =  array_chunk((array) $languge[0],100); 
	    	$languge_data =  array_chunk((array) $languge[1],100);
	    	$listening_data =  array_chunk((array) $languge[2],100);
	    	$reading_data =  array_chunk((array) $languge[3],100);
	    	$writting_data =  array_chunk((array) $languge[4],100);
	    	$speaking_data =  array_chunk((array) $languge[5],100);

    	} else {
    		$overallband_data =  []; 
	    	$languge_data =   []; 
	    	$listening_data =   []; 
	    	$reading_data =   []; 
	    	$writting_data =   []; 
	    	$speaking_data =   []; 
    	}



    	$spouse_languge =  json_decode($data['spouse_language_data']); 


    	if(!empty($spouse_languge)){

	    	$spouse_overallband_data =  array_chunk((array) $spouse_languge[0],100); 
	    	$spouse_languge_data =  array_chunk((array) $spouse_languge[1],100);
	    	$spouse_listening_data =  array_chunk((array) $spouse_languge[2],100);
	    	$spouse_reading_data =  array_chunk((array) $spouse_languge[3],100);
	    	$spouse_writting_data =  array_chunk((array) $spouse_languge[4],100);
	    	$spouse_speaking_data =  array_chunk((array) $spouse_languge[5],100);

	    } else{

	    	$spouse_overallband_data =   []; 
	    	$spouse_languge_data =   []; 
	    	$spouse_listening_data =   []; 
	    	$spouse_reading_data =   []; 
	    	$spouse_writting_data =   []; 
	    	$spouse_speaking_data =   []; 

	    }


		$education =  json_decode($data['education']); 

    	if(!empty($education)){

	    	$degree_data =  array_chunk((array) $education[0],100); 
	    	$subject_data =  array_chunk((array) $education[1],100); 
	    	$board_data =  array_chunk((array) $education[2],100); 
	    	$cgpa_data =  array_chunk((array) $education[3],100); 
	    	$passYear_data =  array_chunk((array) $education[4],100);
	    	$medium_data =  array_chunk((array) $education[5],100);

    	} else {
    		$degree_data =  []; 
	    	$subject_data =   []; 
	    	$board_data =   []; 
	    	$cgpa_data =   []; 
	    	$passYear_data =   []; 
	    	$medium_data =   []; 
    	}


    	$spouse_education =  json_decode($data['spouse_education']); 


    	if(!empty($spouse_education)){

	    	$spouse_degree_data =  array_chunk((array) $spouse_education[0],100); 
	    	$spouse_subject_data =  array_chunk((array) $spouse_education[1],100); 
	    	$spouse_board_data =  array_chunk((array) $spouse_education[2],100); 
	    	$spouse_cgpa_data =  array_chunk((array) $spouse_education[3],100); 
	    	$spouse_passYear_data =  array_chunk((array) $spouse_education[4],100);
	    	$spouse_medium_data =  array_chunk((array) $spouse_education[5],100);

	    } else {
	    	$spouse_degree_data =  []; 
	    	$spouse_subject_data = []; 
	    	$spouse_board_data =  []; 
	    	$spouse_cgpa_data =  []; 
	    	$spouse_passYear_data =  []; 
	    	$spouse_medium_data =  []; 

	    }
    	

		$message= ''; 

		$message .= '<!DOCTYPE>
							<html>
							  <head>
							    <meta http-equiv="Content-Type" content="
							    text/html; charset=UTF-8"
							     />
							    <title>BlueSky</title>
							    
							    <style>
							    #image{
							     margin-top: -51px;
							}

							    .msg2381420674409477934 .m_2381420674409477934im {
   
									    margin-top: -51px;
									}
							      
							    * { margin: 0; padding: 0; }
							    body {
							    font-size: 15px;
							    color: #000;
							    line-height: 22px;
							    font-weight: 400;
							    background: #ffffff;
							    font-family: "Rasa", serif;
							    
							    
							    }
							    #page-wrap { width: 800px; margin: 0 auto; }
							    textarea { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
							    table { border-collapse: collapse; }
							    table td, table th { border: 1px solid black; padding: 5px;     text-align: left;}
							    #header {height: 14px;
							    width: 100%;
							    margin: 20px 0;
							    background: #222;
							    text-align: center;
							    color: white;
							    font: bold 15px Sans-Serif;
							    text-decoration: uppercase;
							    letter-spacing: 5px;
							    padding: 22px 0px;
							    font-size: 20px;
							   font-weight: bold; }
							    #address { width: 316px; height: 150px; float: left; text-align: justify;}
							    #customer { overflow: hidden; }
							    #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; max-height: 100px; overflow: hidden; }
							    #logo:hover, #logo.edit { border: 1px solid #000; margin-top: 0px; max-height: 125px; }
							    #logoctr { display: none; }
							    #logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 5px; }
							    #logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
							    #logohelp input { margin-bottom: 5px; }
							    .edit #logohelp { display: block; }
							    .edit #save-logo, .edit #cancel-logo { display: inline; }
							    .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
							    #customer-title { font-size: 20px; font-weight: bold; float: left;border: 1px solid #000; }
							    .meta-width
							    {
							    width: 49%;
							    
							    }
							    .mr-r
							    {
							    margin:0 2% 0 0;
							    }
							    .mr-b-p
							    {
							    margin-bottom:20px;
							    }
							    #meta {   float:left;  }
							    #meta td.meta-head { text-align: left; background: #eee; }
							    #meta td textarea { width: 100%; height: 20px; text-align: right; }
							    #items { clear: both; width: 100%; }
							    #items th { background: #eee; }
							    #items textarea { width: 80px; height: 50px; }
							    #items tr.item-row td { border: 0; vertical-align: top;border: 1px solid black; }
							    #items td.description { width: 300px; }
							    #items td.item-name { width: 175px; }
							    #items td.description textarea, #items td.item-name textarea { width: 100%; }
							    #items td.total-line { border-right: 0; text-align: right; }
							    #items td.total-value { border-left: 0; padding: 10px; border: 1px solid #000; }
							    #items td.total-value textarea { height: 20px; background: none; }
							    #items td.balance { background: #eee; }
							    #items td.blank { border: 0; }
							    #terms { text-align: center; margin: 20px 0 0 0; }
							    #terms h5 { text-transform: uppercase; font: 13px Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
							    #terms textarea { width: 100%; text-align: center;}
							    textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delete:hover { background-color:#EEFF88; }
							    .delete-wpr { position: relative; }
							    .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px;    font-family: sans-serif; font-size: 12px; }
							    #address1
							    {
							    width: 325px;
							    float: right;
							    margin-top: 15px;
							    }
							    #logo
							    {
							    text-align: right;
							    position: relative;
							    margin-top: 0px;
							    border: 1px solid #fff;
							    max-width: 540px;
							    max-height: 130px;
							    overflow: hidden;
							    }
							    .im
							    {
							      width: 225px;
							    display: block;
							    padding-right: 35px;
							    margin-top: -85px !important;
							    }
							    .education_title{
							            font-size: 23px;
							    border: 1px solid;
							    padding: 7px;
							    font-weight: bold;
							    }
							    </style>
							  </head>
							  <body>
							    <div id="page-wrap">
							      <p id="header"> Australia Visa</p>
							      <div id="identity">
							        <div id="address">
							         
							             <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Name</td>
							            <td> '.$data['name'].'</td>
							          </tr>
							         
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Date Of Birth</td>
							             <td>'. $data['dob'].'</td>
							          </tr>

							        <tr>
							            <td class="meta-head" style="font-weight: bold;">Current Status</td>
							            <td>'.$data['status'].'</td>
							          </tr>
							      </table>
							        </div>

							            <div id="logo">
							                    <div id="logohelp">
							                        <input id="imageloc" type="text" size="50" value=""/><br/>
							                    </div>
							                    <img class="im" id="image" src="http://demo.denseteklearning.com/bluesky/logo.png" alt="logo"/>
							                </div>

							      </div>
							      <div style="clear:both"></div>';

							      if(!empty($degree_data)){

							      $message .= '<p class="education_title" style="margin-top: 5%">Education Details:</p>
							      <div id="customer">
							     	<table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Degree Awarded</th>
						                    <th>Code Subject</th>
						                    <th>Board</th>
						                    <th>CGPA/Percentage</th>
						                    <th>Passing Year</th>
						                    <th>Medium</th>
						                </tr>';

						                

						                foreach ($degree_data[0] as $key => $value) {
						                
						                
								                $message .= '
									                
									                <tr>
									                    <td>
									                       '.$value.'
									                    </td>
									                    <td>
									                         '.$subject_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$board_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$cgpa_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$passYear_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$medium_data[0][$key].'
									                    </td>
									                </tr>';} 
						                
						              $message .= '</table>
							      </div>';
							  }


							      $message .= ' <div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 5%">Work Experience:</p>
							      <div id="customer">

							         <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Are you currently working?</td>

							            ';

						              
						               		$message .= '   <td>'.$data['work_experience'].'</td>';
						               
						               
						               $message .= '</tr> <tr>
							            <td class="meta-head" style="font-weight: bold;">Position Held</td>
							            ';

						               $message .= '   <td>'.$data['work_position_held'].'</td>';
						               
						               $message .= '
							          </tr>

							           <tr>
							            <td class="meta-head" style="font-weight: bold;">Total years of Experience</td>
							            ';

						                $message .= '   <td>'.$data['work_total_experience'].'</td>';
						               
						               $message .= '
							          </tr>

							      </table>
							     
							      </div>';
							          if(!empty($languge_data)){

							      $message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 35px;">Language Proficiency:</p>
							      <div id="customer">
							      <table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Exam Name</th>
						                    <th>Overall Band</th>
						                    <th>Listening</th>
						                    <th>Reading</th>
						                    <th>Writing</th>
						                    <th>Speaking</th>
						                </tr>';

						                foreach ($languge_data[0] as $key => $value) {
						                	
						               
						                
								                $message .= '<tr>
								                    <td>
								                        '.$value.'
								                    </td>
								                    <td>
								                        '.$overallband_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$listening_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$reading_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$writting_data[0][$key].'
								                    </td>
								                     <td>
								                         '.$speaking_data[0][$key].'
								                    </td>
								                </tr>';

						                 }
						                
						            $message .= '</table>
							      </div>'; }

							       $message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 35px;">Spouse Details</p>
							      <div id="customer">
							      <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Spouse Name</td>
							            <td> '.$data['spouse_name'].'</td>
							          </tr>
							         
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Date Of Birth</td>
							             <td>'. $data['spouse_date'].'</td>
							          </tr>
							      </table>
							      </div>

							        <div style="clear:both"></div>
						      <div id="customer" style=" margin-top:5%">
						      <table id="meta" class="meta-width mr-r" cellspacing="0" cellpadding="0" style="width: 100%;border-collapse: collapse; border: none;">
						          <tr>
						            <td class="" style="font-weight: bold;border: 0;">Do You know Australia? </td>
						            <td style="border: 0;"> '.$data['australia_status'].'</td>
						          </tr>
						         
						         
						      </table>
						      </div>


						      <div style="clear:both; margin-top:5%"></div>

						      <div class="compre-tow">
						        <table id="tblOne" style="width:45%; float:left">
						          <tr  class="sub_title"><td colspan="2" class="meta-head" style="font-weight: bold;    background: #eee;">Comprehenstion</td></tr>

						                  <tr>
						                    <th class="meta-head" style="font-weight: bold;">Oral</th>
						              
						                    <th class="meta-head" style="font-weight: bold;">Written</th>
						                  </tr>
						                 
						                  <tr>
						                    <td colspan="2">'.$data['comprehenstion'].'</td>
						                  </tr>
						        </table>
						        <table id="tblTwo" style="width:45%; float:left;    margin-left: 80px;">
						          <tr  class="sub_title"><td colspan="2" class="meta-head" style="font-weight: bold;background:#eee;">Comprehenstion</td></tr>
						                <tr>
						                    <th class="meta-head" style="font-weight: bold;">Oral</th>
						                
						                    <th class="meta-head" style="font-weight: bold;">Written</th>
						                  </tr>
						                 
						                  <tr>
						                    <td colspan="2">'.$data['exprestion'].'</td>
						                  </tr>
						        </table> 
						      </div>';


   								if(!empty($spouse_degree_data)){


						        $message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 5%">Education Details:</p>
							      <div id="customer">
							     	<table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Degree Awarded</th>
						                    <th>Code Subject</th>
						                    <th>Board</th>
						                    <th>CGPA/Percentage</th>
						                    <th>Passing Year</th>
						                    <th>Medium</th>
						                </tr>';

						                foreach ($spouse_degree_data[0] as $key => $value) {
						                
						                
								                $message .= '
									                
									                <tr>
									                    <td>
									                       '.$value.'
									                    </td>
									                    <td>
									                         '.$spouse_subject_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$spouse_board_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$spouse_cgpa_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$spouse_passYear_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$spouse_medium_data[0][$key].'
									                    </td>
									                </tr>';}
						                
						              $message .= '</table>
							      </div>';}


						         $message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 5%">Work Experience:</p>
							      <div id="customer">

							         <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Are you currently working?</td>

							            ';

						              
						               		$message .= '   <td>'.$data['spouse_status'].'</td>';
						               
						               
						               $message .= '</tr> <tr>
							            <td class="meta-head" style="font-weight: bold;">Position Held</td>
							            ';

						               $message .= '   <td>'.$data['spouse_work_position_held'].'</td>';
						               
						               $message .= '
							          </tr>

							           <tr>
							            <td class="meta-head" style="font-weight: bold;">Total years of Experience</td>
							            ';

						                $message .= '   <td>'.$data['spouse_work_total_experience'].'</td>';
						               
						               $message .= '
							          </tr>

							      </table>
							     
							      </div>';

							         if(!empty($spouse_languge_data)){
							            $message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 35px;">Language Proficiency:</p>
							      <div id="customer">
							      <table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Exam Name</th>
						                    <th>Overall Band</th>
						                    <th>Listening</th>
						                    <th>Reading</th>
						                    <th>Writing</th>
						                    <th>Speaking</th>
						                </tr>';

						                foreach ($spouse_languge_data[0] as $key => $value) {
						                	
						               
						                
								                $message .= '<tr>
								                    <td>
								                        '.$value.'
								                    </td>
								                    <td>
								                        '.$spouse_overallband_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$spouse_listening_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$spouse_reading_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$spouse_writting_data[0][$key].'
								                    </td>
								                     <td>
								                         '.$spouse_speaking_data[0][$key].'
								                    </td>
								                </tr>';

						                 }
						                
						            $message .= '</table>
							      </div>';}

							    
							      $message .= '</div>
							    
							  </body>
							</html>';  

		$this->email->set_newline("\r\n");
	    $this->email->from('demo@denseteklearning.com');
	    $this->email->to('densetek.nitin@gmail.com');
	    $this->email->subject('BlueSky || Australia Visa || '.$data['name']);
	    $this->email->message($message);


		//Send mail 
		if($this->email->send()){ 
		
		} else {  
	
		}

	}

	public function send_mail_canada_visa($data,$filename)
	{ 

		$config = Array(
	          'protocol' => 'smtp',
	          'smtp_host' => 'mail.denseteklearning.com',
	          'smtp_port' => 587,
	          'smtp_user' => 'demo@denseteklearning.com', // change it to yours
	          'smtp_pass' => 'Demo@123', // change it to yours
	          'mailtype' => 'html',
	          'charset' => 'iso-8859-1',
	          'wordwrap' => TRUE
	        );

		$this->email->initialize($config);



		$languge =  json_decode($data['language_data']); 

    	if(!empty($languge)){

	    	$overallband_data =  array_chunk((array) $languge[0],100); 
	    	$languge_data =  array_chunk((array) $languge[1],100);
	    	$listening_data =  array_chunk((array) $languge[2],100);
	    	$reading_data =  array_chunk((array) $languge[3],100);
	    	$writting_data =  array_chunk((array) $languge[4],100);
	    	$speaking_data =  array_chunk((array) $languge[5],100);

    	} else {
    		$overallband_data =  []; 
	    	$languge_data =   []; 
	    	$listening_data =   []; 
	    	$reading_data =   []; 
	    	$writting_data =   []; 
	    	$speaking_data =   []; 
    	}



    	$spouse_languge =  json_decode($data['spouse_language_data']); 


    	if(!empty($spouse_languge)){

	    	$spouse_overallband_data =  array_chunk((array) $spouse_languge[0],100); 
	    	$spouse_languge_data =  array_chunk((array) $spouse_languge[1],100);
	    	$spouse_listening_data =  array_chunk((array) $spouse_languge[2],100);
	    	$spouse_reading_data =  array_chunk((array) $spouse_languge[3],100);
	    	$spouse_writting_data =  array_chunk((array) $spouse_languge[4],100);
	    	$spouse_speaking_data =  array_chunk((array) $spouse_languge[5],100);

	    } else{

	    	$spouse_overallband_data =   []; 
	    	$spouse_languge_data =   []; 
	    	$spouse_listening_data =   []; 
	    	$spouse_reading_data =   []; 
	    	$spouse_writting_data =   []; 
	    	$spouse_speaking_data =   []; 

	    }


		$education =  json_decode($data['education']); 

    	if(!empty($education)){

	    	$degree_data =  array_chunk((array) $education[0],100); 
	    	$subject_data =  array_chunk((array) $education[1],100); 
	    	$board_data =  array_chunk((array) $education[2],100); 
	    	$cgpa_data =  array_chunk((array) $education[3],100); 
	    	$passYear_data =  array_chunk((array) $education[4],100);
	    	$medium_data =  array_chunk((array) $education[5],100);

    	} else {
    		$degree_data =  []; 
	    	$subject_data =   []; 
	    	$board_data =   []; 
	    	$cgpa_data =   []; 
	    	$passYear_data =   []; 
	    	$medium_data =   []; 
    	}


    	$spouse_education =  json_decode($data['spouse_education']); 


    	if(!empty($spouse_education)){

	    	$spouse_degree_data =  array_chunk((array) $spouse_education[0],100); 
	    	$spouse_subject_data =  array_chunk((array) $spouse_education[1],100); 
	    	$spouse_board_data =  array_chunk((array) $spouse_education[2],100); 
	    	$spouse_cgpa_data =  array_chunk((array) $spouse_education[3],100); 
	    	$spouse_passYear_data =  array_chunk((array) $spouse_education[4],100);
	    	$spouse_medium_data =  array_chunk((array) $spouse_education[5],100);

	    } else {
	    	$spouse_degree_data =  []; 
	    	$spouse_subject_data = []; 
	    	$spouse_board_data =  []; 
	    	$spouse_cgpa_data =  []; 
	    	$spouse_passYear_data =  []; 
	    	$spouse_medium_data =  []; 

	    }
    	

		$message= ''; 

		$message .= '<!DOCTYPE>
							<html>
							  <head>
							    <meta http-equiv="Content-Type" content="
							    text/html; charset=UTF-8"
							     />
							    <title>BlueSky</title>
							    
							    <style>
							    #image{
							     margin-top: -51px;
							}

							    .msg2381420674409477934 .m_2381420674409477934im {
   
									    margin-top: -51px;
									}
							      
							    * { margin: 0; padding: 0; }
							    body {
							    font-size: 15px;
							    color: #000;
							    line-height: 22px;
							    font-weight: 400;
							    background: #ffffff;
							    font-family: "Rasa", serif;
							    
							    
							    }
							    #page-wrap { width: 800px; margin: 0 auto; }
							    textarea { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
							    table { border-collapse: collapse; }
							    table td, table th { border: 1px solid black; padding: 5px;     text-align: left;}
							    #header {height: 14px;
							    width: 100%;
							    margin: 20px 0;
							    background: #222;
							    text-align: center;
							    color: white;
							    font: bold 15px Sans-Serif;
							    text-decoration: uppercase;
							    letter-spacing: 5px;
							    padding: 22px 0px;
							    font-size: 20px;
							   font-weight: bold; }
							    #address { width: 316px; height: 150px; float: left; text-align: justify;}
							    #customer { overflow: hidden; }
							    #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; max-height: 100px; overflow: hidden; }
							    #logo:hover, #logo.edit { border: 1px solid #000; margin-top: 0px; max-height: 125px; }
							    #logoctr { display: none; }
							    #logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 5px; }
							    #logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
							    #logohelp input { margin-bottom: 5px; }
							    .edit #logohelp { display: block; }
							    .edit #save-logo, .edit #cancel-logo { display: inline; }
							    .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
							    #customer-title { font-size: 20px; font-weight: bold; float: left;border: 1px solid #000; }
							    .meta-width
							    {
							    width: 49%;
							    
							    }
							    .mr-r
							    {
							    margin:0 2% 0 0;
							    }
							    .mr-b-p
							    {
							    margin-bottom:20px;
							    }
							    #meta {   float:left;  }
							    #meta td.meta-head { text-align: left; background: #eee; }
							    #meta td textarea { width: 100%; height: 20px; text-align: right; }
							    #items { clear: both; width: 100%; }
							    #items th { background: #eee; }
							    #items textarea { width: 80px; height: 50px; }
							    #items tr.item-row td { border: 0; vertical-align: top;border: 1px solid black; }
							    #items td.description { width: 300px; }
							    #items td.item-name { width: 175px; }
							    #items td.description textarea, #items td.item-name textarea { width: 100%; }
							    #items td.total-line { border-right: 0; text-align: right; }
							    #items td.total-value { border-left: 0; padding: 10px; border: 1px solid #000; }
							    #items td.total-value textarea { height: 20px; background: none; }
							    #items td.balance { background: #eee; }
							    #items td.blank { border: 0; }
							    #terms { text-align: center; margin: 20px 0 0 0; }
							    #terms h5 { text-transform: uppercase; font: 13px Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
							    #terms textarea { width: 100%; text-align: center;}
							    textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delete:hover { background-color:#EEFF88; }
							    .delete-wpr { position: relative; }
							    .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px;    font-family: sans-serif; font-size: 12px; }
							    #address1
							    {
							    width: 325px;
							    float: right;
							    margin-top: 15px;
							    }
							    #logo
							    {
							    text-align: right;
							    position: relative;
							    margin-top: 0px;
							    border: 1px solid #fff;
							    max-width: 540px;
							    max-height: 130px;
							    overflow: hidden;
							    }
							    .im
							    {
							      width: 225px;
							    display: block;
							    padding-right: 35px;
							    margin-top: -85px !important;
							    }
							    .education_title{
							            font-size: 23px;
							    border: 1px solid;
							    padding: 7px;
							    font-weight: bold;
							    }
							    </style>
							  </head>
							  <body>
							    <div id="page-wrap">
							      <p id="header"> Australia Visa</p>
							      <div id="identity">
							        <div id="address">
							         
							             <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Name</td>
							            <td> '.$data['name'].'</td>
							          </tr>
							         
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Date Of Birth</td>
							             <td>'. $data['dob'].'</td>
							          </tr>

							        <tr>
							            <td class="meta-head" style="font-weight: bold;">Current Status</td>
							            <td>'.$data['status'].'</td>
							          </tr>
							      </table>
							        </div>

							            <div id="logo">
							                    <div id="logohelp">
							                        <input id="imageloc" type="text" size="50" value=""/><br/>
							                    </div>
							                    <img class="im" id="image" src="http://demo.denseteklearning.com/bluesky/logo.png" alt="logo"/>
							                </div>

							      </div>';

							      if(!empty($degree_data)){
    							
    								$message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 5%">Education Details:</p>
							      <div id="customer">
							     	<table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Degree Awarded</th>
						                    <th>Code Subject</th>
						                    <th>Board</th>
						                    <th>CGPA/Percentage</th>
						                    <th>Passing Year</th>
						                    <th>Medium</th>
						                </tr>';

						                foreach ($degree_data[0] as $key => $value) {
						                
						                
								                $message .= '
									                
									                <tr>
									                    <td>
									                       '.$value.'
									                    </td>
									                    <td>
									                         '.$subject_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$board_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$cgpa_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$passYear_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$medium_data[0][$key].'
									                    </td>
									                </tr>';}
						                
						              $message .= '</table></div>';}


  										$message .= '


							       <div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 5%">Work Experience:</p>
							      <div id="customer">

							         <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Are you currently working?</td>

							            ';

						              
						               		$message .= '   <td>'.$data['work_experience'].'</td>';
						               
						               
						               $message .= '</tr> <tr>
							            <td class="meta-head" style="font-weight: bold;">Position Held</td>
							            ';

						               $message .= '   <td>'.$data['work_position_held'].'</td>';
						               
						               $message .= '
							          </tr>

							           <tr>
							            <td class="meta-head" style="font-weight: bold;">Total years of Experience</td>
							            ';

						                $message .= '   <td>'.$data['work_total_experience'].'</td>';
						               
						               $message .= '
							          </tr>

							      </table>
							     
							      
									 </div>';

									      if(!empty($languge_data)){
										
										$message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 35px;">Language Proficiency:</p>
							      <div id="customer">
							      <table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Exam Name</th>
						                    <th>Overall Band</th>
						                    <th>Listening</th>
						                    <th>Reading</th>
						                    <th>Writing</th>
						                    <th>Speaking</th>
						                </tr>';

						                foreach ($languge_data[0] as $key => $value) {
						                	
						               
						                
								                $message .= '<tr>
								                    <td>
								                        '.$value.'
								                    </td>
								                    <td>
								                        '.$overallband_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$listening_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$reading_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$writting_data[0][$key].'
								                    </td>
								                     <td>
								                         '.$speaking_data[0][$key].'
								                    </td>
								                </tr>';

						                 }
						                
						            $message .= '</table></div>';}


  									$message .= '


							           <div style="clear:both"></div>
						      <div id="customer" style=" margin-top:5%">
						      <table id="meta" class="meta-width mr-r" cellspacing="0" cellpadding="0" style="width: 100%;border-collapse: collapse; border: none;">
						          <tr>
						            <td class="" style="font-weight: bold;border: 0;">Do You know French? </td>
						            <td style="border: 0;"> '.$data['french_status'].'</td>
						          </tr>
						         
						          <tr>
						            <td class="" style="font-weight: bold;border: 0;">Have you given TEF Canada?</td>
						             <td style="border: 0;">'. $data['canada_status'].'</td>
						          </tr>
						      </table>
						      </div>


							      <div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 35px;">Spouse Details</p>
							      <div id="customer">
							      <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Spouse Name</td>
							            <td> '.$data['spouse_name'].'</td>
							          </tr>
							         
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Date Of Birth</td>
							             <td>'. $data['spouse_date'].'</td>
							          </tr>
							      </table>
							      </div>

							        <div style="clear:both"></div>
						      <div id="customer" style=" margin-top:5%">
						      <table id="meta" class="meta-width mr-r" cellspacing="0" cellpadding="0" style="width: 100%;border-collapse: collapse; border: none;">
						          <tr>
						            <td class="" style="font-weight: bold;border: 0;">Have you given an IELTS/CELPIP? </td>
						            <td style="border: 0;"> '.$data['IELTS_name_1'].'</td>
						          </tr>
						         
						         
						      </table>
						      </div>


						      <div style="clear:both; margin-top:5%"></div>

						      <div class="compre-tow">
						        <table id="tblOne" style="width:45%; float:left">
						          <tr  class="sub_title"><td colspan="2" class="meta-head" style="font-weight: bold;    background: #eee;">Comprehenstion</td></tr>

						                  <tr>
						                    <th class="meta-head" style="font-weight: bold;">Oral</th>
						              
						                    <th class="meta-head" style="font-weight: bold;">Written</th>
						                  </tr>
						                 
						                  <tr>
						                    <td colspan="2">'.$data['comprehenstion'].'</td>
						                  </tr>
						        </table>
						        <table id="tblTwo" style="width:45%; float:left;    margin-left: 80px;">
						          <tr  class="sub_title"><td colspan="2" class="meta-head" style="font-weight: bold;background:#eee;">Comprehenstion</td></tr>
						                <tr>
						                    <th class="meta-head" style="font-weight: bold;">Oral</th>
						                
						                    <th class="meta-head" style="font-weight: bold;">Written</th>
						                  </tr>
						                 
						                  <tr>
						                    <td colspan="2">'.$data['exprestion'].'</td>
						                  </tr>
						        </table> 
						      </div>';

							      if(!empty($spouse_degree_data)){
								
								$message .= '<div style="clear:both"></div>

							      <p class="education_title" style="margin-top: 5%">Education Details:</p>
							      <div id="customer">
							     	<table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Degree Awarded</th>
						                    <th>Code Subject</th>
						                    <th>Board</th>
						                    <th>CGPA/Percentage</th>
						                    <th>Passing Year</th>
						                    <th>Medium</th>
						                </tr>';

						                foreach ($spouse_degree_data[0] as $key => $value) {
						                
						                
								                $message .= '
									                
									                <tr>
									                    <td>
									                       '.$value.'
									                    </td>
									                    <td>
									                         '.$spouse_subject_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$spouse_board_data[0][$key].'
									                    </td>
									                     <td>
									                       '.$spouse_cgpa_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$spouse_passYear_data[0][$key].'
									                    </td>
									                     <td>
									                        '.$spouse_medium_data[0][$key].'
									                    </td>
									                </tr>';}
						                
						                $message .= '</table></div>';}
  										$message .= '


							        <div style="clear:both"></div>
						      <div id="customer" style=" margin-top:5%">
						      <table id="meta" class="meta-width mr-r" cellspacing="0" cellpadding="0" style="width: 100%;border-collapse: collapse; border: none;">
						          <tr>
						            <td class="" style="font-weight: bold;border: 0;">Have you given an IELTS/CELPIP? </td>
						            <td style="border: 0;"> '.$data['IELTS_name_2'].'</td>
						          </tr>
						         
						         
						      </table>
						      </div>


						        <div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 5%">Work Experience:</p>
							      <div id="customer">

							         <table id="meta" class="meta-width mr-r" style="width: 100%">
							          <tr>
							            <td class="meta-head" style="font-weight: bold;">Are you currently working?</td>

							            ';

						              
						               		$message .= '   <td>'.$data['spouse_status'].'</td>';
						               
						               
						               $message .= '</tr> <tr>
							            <td class="meta-head" style="font-weight: bold;">Position Held</td>
							            ';

						               $message .= '   <td>'.$data['spouse_work_position_held'].'</td>';
						               
						               $message .= '
							          </tr>

							           <tr>
							            <td class="meta-head" style="font-weight: bold;">Total years of Experience</td>
							            ';

						                $message .= '   <td>'.$data['spouse_work_total_experience'].'</td>';
						               
						               $message .= '
							          </tr>

							      </table>
							     
							      </div>';

						      if(!empty($spouse_languge_data)){
							
								$message .= '<div style="clear:both"></div>
							      <p class="education_title" style="margin-top: 35px;">Language Proficiency:</p>
							      <div id="customer">
							      <table id="items"  style="width: 100%">
						                
						                <tr>
						                    <th>Exam Name</th>
						                    <th>Overall Band</th>
						                    <th>Listening</th>
						                    <th>Reading</th>
						                    <th>Writing</th>
						                    <th>Speaking</th>
						                </tr>';

						                foreach ($spouse_languge_data[0] as $key => $value) {
						                	
						               
						                
								                $message .= '<tr>
								                    <td>
								                        '.$value.'
								                    </td>
								                    <td>
								                        '.$spouse_overallband_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$spouse_listening_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$spouse_reading_data[0][$key].'
								                    </td>
								                     <td>
								                        '.$spouse_writting_data[0][$key].'
								                    </td>
								                     <td>
								                         '.$spouse_speaking_data[0][$key].'
								                    </td>
								                </tr>';

						                 }
						                
						               $message .= '</table></div>';}
  										$message .= '
							    
							    </div>
							    
							  </body>
							</html>';  

		$this->email->set_newline("\r\n");
	    $this->email->from('demo@denseteklearning.com');
	    $this->email->to('densetek.nitin@gmail.com');
	    $this->email->subject('BlueSky || Canada Visa || '.$data['name']);
	    $this->email->message($message);


		//Send mail 
		if($this->email->send()){ 
	
		} else {  
	
		}

	}


	public function visitor_visa_pdf()
	{

		$data = array('name' => "1111",
			/*'mobile' => $data['mobile'],
			'dob' => $data['dob'],
			'email' => $data['email'],
			'purpose' => $data['purpose'],
			'counrty' => $data['counrty'],*/
            'date'               => date("Y-m-d H:i:s"));


		//print_r($data);exit;

		$mpdf = new \Mpdf\Mpdf(); 

			//$stylesheet = file_get_contents(base_url('frontend_assets/css/bootstrap.min.css'));

			//$stylesheet = file_get_contents(base_url('frontend_assets/css/style.css'));


			//$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);



		$mpdf->WriteHTML($this->load->view('visitor_visa.php',$data,true),\Mpdf\HTMLParserMode::HTML_BODY); 

		//$filename = 'pdf/visitor_visa/'.date("H_i_s").'.pdf';

		$mpdf->Output("112.pdf",'I');

		//$this->send_mail($data['email'],$filename); 

	}

	
}