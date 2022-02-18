<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
	<div class="card card-danger card-outline">
		<div class="card-header">
			<h5 class="card-title m-0"><?= ucwords($title) ?> Change</h5>
		</div>
		<?php foreach ($installments as $k => $v): ?>
		<?= form_open($url.'/installmentChange/'.$id, '', ['fee_id' => e_id($v['id'])]) ?>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<?= form_label('Installment', 'fees') ?>
						<?= form_input([
						'name' => "fees",
						'class' => "form-control",
						'id' => "fees",
						'disabled'=> 'disabled',
						'value' => set_value('fees') ? set_value('fees') : $v['fees']
						]) ?>
						<?= form_error('fees') ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="from_<?= $k+1 ?>">Date Of Installment</label>
						<div class="input-group date" id="dob_<?= $k+1 ?>" data-target-input="nearest">
							<input type="text" name="fees_date" class="form-control datetimepicker-input" id="from_<?= $k+1 ?>" data-target="#dob_<?= $k+1 ?>" data-toggle="datetimepicker" value="<?= date('m/d/Y', strtotime($v['fees_date'])) ?>" placeholder="Select Date Of Installment">
							<div class="input-group-append" data-target="#dob_<?= $k+1 ?>" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
							</div>
						</div>
						<?= form_error('fees_date') ?>
					</div>
				</div>
				<div class="col-md-4 mt-4">
					<?= form_button([ 'content' => 'Update',
					'type'  => 'submit',
					'class' => 'btn btn-outline-primary col-md-4 mt-2']) ?>
				</div>
			</div>
		</div>
		<?= form_close() ?>
		<?php endforeach ?>
		<div class="card-footer">
			<div class="row">
				<div class="col-md-6">
					<?= anchor($url, 'Cancel', 'class="btn btn-outline-danger col-md-4"'); ?>
				</div>
			</div>
		</div>
	</div>
</div>