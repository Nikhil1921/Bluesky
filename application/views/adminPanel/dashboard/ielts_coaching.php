<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('material'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Material</span>
				<span class="info-box-number">'.$this->main->count('material', ['is_deleted' => 0]).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('ieltsBatch'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Batch</span>
				<span class="info-box-number">'.$this->main->count('ielts_batch', ['is_deleted' => 0]).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('students'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Students</span>
				<span class="info-box-number">'.$this->students->count().'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
</div>