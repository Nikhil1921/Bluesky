<?php defined('BASEPATH') OR exit('No direct script access allowed');
$data['data'] = (array) json_decode($status['status']); ?>
<div class="modal-body">
	<div class="row">
		<?php switch($status['status_type']): 
			case 'PR CANADA':
				echo '<div class="col-12"><div class="alert alert-primary">Status for PR CANADA</div></div>';
				$this->load->view(admin('status-forms/pr-canada'), $data);
			break; 
			case 'STUDENT CANADA':
				echo '<div class="col-12"><div class="alert alert-primary">Status for STUDENT CANADA</div></div>';
				$this->load->view(admin('status-forms/student-canada'), $data);
			break; 
			case 'STUDENT USA':
				echo '<div class="col-12"><div class="alert alert-primary">Status for STUDENT USA</div></div>';
				$this->load->view(admin('status-forms/student-usa'), $data);
			break; 
			case 'STUDENT UK': 
				echo '<div class="col-12"><div class="alert alert-primary">Status for STUDENT UK</div></div>';
				$this->load->view(admin('status-forms/student-uk'), $data);
			break; 
			case 'STUDENT AUSTRALIA': 
				echo '<div class="col-12"><div class="alert alert-primary">Status for STUDENT AUSTRALIA</div></div>';
				$this->load->view(admin('status-forms/student-australia'), $data);
			break; 
			default: 
				echo '<div class="col-12">
						<div class="text-center">No form for status available.</div>
					</div>';
			break; endswitch ?>
	</div>
</div>