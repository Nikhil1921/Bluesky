<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal fade" id="fee-collection">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Fee Installment(s)</h4>
				<?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
			</div>
			<div class="modal-body">
				<?php $collection = 0; if ($installments): ?>
				<table class="table">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Fee Collected</th>
							<th>Date</th>
							<th>Remarks</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($installments as $k => $v): $collection += $v['fees'] ?>
						<tr>
							<td><?= $k + 1 ?></td>
							<td>₹ <?= $v['fees'] ?></td>
							<td><?= date("d-m-Y", strtotime($v['fees_date'])) ?></td>
							<td><?= $v['remarks'] ?></td>
							<td><?= $v['status'] ?></td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<?php else: ?>
				<div class="col-md-12 text-center">
					<span>No fee collection history available</span>
				</div>
				<?php endif ?>
			</div>
			<div class="modal-footer justify-content-between">
				<?= form_button([ 'content' => 'Close', 'type'  => 'button','class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
				<?= form_button([ 'content' => 'Close history', 'type'  => 'button','class' => 'btn btn-outline-primary', 'data-dismiss' => "modal"]); ?>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="card card-danger card-outline">
		<div class="card-header">
			<h5 class="card-title m-0"><?= ucwords($title) ?></h5>
		</div>
		<?= form_open($url.'/installment/'.$id) ?>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Total Fees', 'fees') ?>
						<?= form_input([
						'class' => "form-control",
						'value' => set_value('fees') ? set_value('fees') : $data['ielts_fees'],
						'disabled' => 'disabled'
						]) ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Remaining Fees') ?>
						<?= form_input([
						'name' => "remaining",
						'class' => "form-control",
						'value' => '₹ '.($data['ielts_fees'] - $collection),
						'readonly' => "readonly"
						]) ?>
					</div>
				</div>
				<?php if ($data['ielts_fees'] == 0 || $data['ielts_fees'] - $collection > 0): ?>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Fees installment', 'fees_collect') ?>
						<?= form_input([
						'name' => "fees_collect",
						'class' => "form-control",
						'id' => "fees_collect",
						'placeholder' => "Enter Fees",
						'value' => set_value('fees_collect')
						]) ?>
						<?= form_error('fees_collect') ?>
					</div>
				</div>
				<?php endif ?>
				<div class="col-md-6 mt-4">
					<?= form_button([ 'content' => 'View Installment(s)','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'data-toggle' => "modal", 'data-target' => "#fee-collection"]); ?>
				</div>
				<?php if ($data['ielts_fees'] == 0 || $data['ielts_fees'] - $collection > 0): ?>
				<div class="col-md-6">
					<div class="form-group">
						<label for="from">Date Of Installment</label>
						<div class="input-group date" id="dob" data-target-input="nearest">
							<input type="text" name="fees_date" class="form-control datetimepicker-input" id="from" data-target="#dob" data-toggle="datetimepicker" value="<?= set_value('fees_date') ?>" placeholder="Select Date Of Installment">
							<div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
							</div>
						</div>
						<?= form_error('fees_date') ?>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('Remarks', 'remarks') ?>
						<?= form_input([
						'name' => "remarks",
						'class' => "form-control",
						'id' => "remarks",
						'placeholder' => "Enter Remarks",
						'value' => set_value('remarks')
						]) ?>
					</div>
				</div>
				<?php endif ?>
			</div>
		</div>
		<div class="card-footer">
			<div class="row">
				<?php if ($data['ielts_fees'] == 0 || $data['ielts_fees'] - $collection > 0): ?>
				<div class="col-md-6">
					<?= form_button([ 'content' => 'Save',
					'type'  => 'submit',
					'class' => 'btn btn-outline-primary col-md-4']) ?>
				</div>
				<?php endif ?>
				<div class="col-md-6">
					<?= anchor($url, 'Cancel', 'class="btn btn-outline-danger col-md-4"'); ?>
				</div>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>