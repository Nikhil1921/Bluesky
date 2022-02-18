<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row">
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('ielts'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">IELTS</span>
				<span class="info-box-number">'.$this->ielts->count().'</span>
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
		<?= anchor(admin('book'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Books</span>
				<span class="info-box-number">'.$this->main->count('book', ['is_deleted' => 0]).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?php $where = ['is_deleted' => 0, 'role' => 'IELTS Coaching']; ?>
		<?= anchor(admin('users'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">IELTS Coaches</span>
				<span class="info-box-number">'.$this->main->count("admins", $where).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
</div>