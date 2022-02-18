<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
	<div class="card card-success card-outline">
		<div class="card-header">
			<h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
		</div>
		<?= form_open($url.'/visa_type/'.e_id($data['id'])) ?>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Visa Type') ?>
						<?= form_dropdown('visa_type', ['IELTS' => 'IELTS', 'Visitor' => 'Visitor Visa', 'Student' => 'Student Visa', 'Permanent Residency' => 'Permanent Residency'],  $data['visa_type'], [
						'class' => 'form-control',
						'onchange' => "getCountry(this.value)",
						'data-dependent' => "inquiry_country",
						'data-value' => e_id($data['inquiry_country']),
						'id' => "inquiry_type"
						]) ?>
						<?= form_error('visa_type') ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Country', 'inquiry_country') ?>
						<?= form_dropdown('inquiry_country', [], set_value('inquiry_country'), [
						'class' => 'form-control select2',
						'id' => "inquiry_country"
						]) ?>
						<?= form_error('inquiry_country') ?>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('Remarks', 'remarks') ?>
						<?= form_textarea('remarks', $data['remarks'], ['class' => 'form-control']); ?>
						<?= form_error('remarks') ?>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-md-6">
					<?= form_button([ 'content' => 'Save',
					'type'  => 'submit',
					'class' => 'btn btn-outline-primary col-md-4']) ?>
				</div>
				<div class="col-md-6">
					<?= anchor($url, 'Cancel', 'class="btn btn-outline-danger col-md-4"'); ?>
				</div>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>