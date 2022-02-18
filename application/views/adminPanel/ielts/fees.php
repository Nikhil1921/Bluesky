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
			<h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
		</div>
		<?= form_open($url.'/update-fees/'.$id) ?>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Total Fees', 'fees') ?>
						<?= form_input([
						'name' => "fees",
						'class' => "form-control",
						'id' => "fees",
						'placeholder' => "Enter Fees",
						'value' => set_value('fees') ? set_value('fees') : $data['ielts_fees']
						]) ?>
						<?= form_error('fees') ?>
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