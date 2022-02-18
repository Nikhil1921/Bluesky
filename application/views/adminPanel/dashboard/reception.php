<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('inquiry/today'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Inquiries (Today)</span>
				<span class="info-box-number">'.$this->inquiry->count().'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('meeting'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Meeting</span>
				<span class="info-box-number">'.$this->inquiry->count().'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('assignedLead'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Leads</span>
				<span class="info-box-number">'.$this->lead_model->count().'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('followUp'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Follow Up(s)</span>
				<span class="info-box-number">'.$this->inquiry->count().'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
</div>