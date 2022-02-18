<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal fade" id="fee-collection">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Fee collection history</h4>
				<?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
			</div>
			<div class="modal-body">
				<?php $collection = 0; if ($fees): ?>
				<table class="table">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Fee Collected</th>
							<th>Date & Time</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($fees as $k => $v): $collection += $v['fees'] ?>
						<tr>
							<td><?= $k + 1 ?></td>
							<td>₹ <?= $v['fees'] ?></td>
							<td><?= date("d-m-Y h:i A", strtotime($v['created_at'])) ?></td>
							<td><?= $v['remarks'] ?></td>
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
		<?= form_open($url.'/fees/'.$id) ?>
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
						<?= form_label('Fees Collect', 'fees_collect') ?>
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
				<div class="col-sm-6">
					<label>Include GST?</label>
					<div class="form-group clearfix">
						<div class="icheck-primary d-inline mr-3">
							<input type="radio" id="yes" name="include_gst" value="Yes">
							<label for="yes">Yes
							</label>
						</div>
						<div class="icheck-primary d-inline">
							<input type="radio" id="no" name="include_gst" checked="" value="No">
							<label for="no">
								No
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Fees GST ( @ 18%)', 'fees_gst') ?>
						<?= form_input([
						'name' => "fees_gst",
						'class' => "form-control",
						'id' => "fees_gst",
						'placeholder' => "Fees GST ( @ 18%)",
						'readonly' => true,
						'value' => set_value('fees_gst')
						]) ?>
						<?= form_error('fees_gst') ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('GST No.', 'gst_no') ?>
						<?= form_input([
						'name' => "gst_no",
						'class' => "form-control",
						'id' => "gst_no",
						'placeholder' => "GST No.",
						'readonly' => true,
						'value' => set_value('gst_no')
						]) ?>
						<?= form_error('gst_no') ?>
					</div>
				</div>
				<?php endif ?>
				<div class="col-md-5">
					<div class="form-group">
						<?= form_label('Collected Fees') ?>
						<?= form_input([
						'class' => "form-control",
						'value' => '₹ '.$collection,
						'disabled' => ""
						]) ?>
					</div>
				</div>
				<div class="col-md-1 mt-4">
					<?= form_button([ 'content' => '<i class="fa fa-history"></i>','type'  => 'button','class' => 'btn btn-outline-dark mr-2', 'data-toggle' => "modal", 'data-target' => "#fee-collection"]); ?>
				</div>
				<?php if ($data['ielts_fees'] == 0 || $data['ielts_fees'] - $collection > 0): ?>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Fees Type', 'fee_type') ?>
						<?= form_dropdown('fee_type', [ 'Consultancy' => 'Consultancy', 'IELTS' => 'IELTS' ], set_value('fee_type'), [
						'class' => 'form-control',
						'id' => "fee_type"
						]) ?>
						<?= form_error('fee_type') ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Payment Type', 'pay_type') ?>
						<?= form_dropdown('pay_type', [ 'Cash' => 'Cash', 'Online' => 'Online', 'Cheque' => 'Cheque', 'Card Swipe' => 'Card Swipe' ], set_value('pay_type'), [
						'class' => 'form-control',
						'id' => "pay_type"
						]) ?>
						<?= form_error('pay_type') ?>
					</div>
				</div>
				<?php endif ?>
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