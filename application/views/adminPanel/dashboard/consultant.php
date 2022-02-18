<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('consulting'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Consulting</span>
				<span class="info-box-number">'.$this->consulting->count().'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor(admin('installment'),
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-rupee-sign"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Fees Installments</span>
				<span class="info-box-number">'.$this->fees->count().'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
</div>