<?php defined('BASEPATH') OR exit('No direct script access allowed');
$image = $status['status_image'];
$status = explode(', ', $status['status']);
?>
<div class="modal-body">
	<div class="row">
		<div class="col-6">
			<div class="form-group clearfix">
				<div class="icheck-primary d-inline">
					<?= form_checkbox('status[]', 'Express entry EOT profile creation.', in_array('Express entry EOT profile creation.', $status), ['id' => "details"]) ?>
					<?= form_label('Express entry EOT profile creation.', 'details') ?>
				</div>
			</div>
		</div>
		<div class="col-6">
			<label>
				Send SMS?
			</label>
			<div class="form-group clearfix">
				<div class="icheck-primary d-inline mr-2">
					<input type="radio" id="yes" name="sms" value="yes">
					<label for="yes">
						Yes
					</label>
				</div>
				<div class="icheck-danger d-inline">
					<input type="radio" id="no" name="sms" value="no" checked="">
					<label for="no">
						No
					</label>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group clearfix">
				<div class="icheck-primary d-inline">
					<?= form_checkbox('status[]', 'PNP profile creation.', in_array('PNP profile creation.', $status), ['id' => "images"]) ?>
					<?= form_label('PNP profile creation.', 'images') ?>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group clearfix">
				<div class="icheck-primary d-inline">
					<?= form_checkbox('status[]', 'Application submitted.', in_array('Application submitted.', $status), ['id' => "application"]) ?>
					<?= form_label('Application submitted.', 'application') ?>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group clearfix">
				<div class="icheck-primary d-inline">
					<?= form_checkbox('status[]', 'WES/IQAS/ICAS/ICES/CES application done.', in_array('WES/IQAS/ICAS/ICES/CES application done.', $status), ['id' => "app_done"]) ?>
					<?= form_label('WES/IQAS/ICAS/ICES/CES application done.', 'app_done') ?>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group clearfix">
				<div class="icheck-primary d-inline">
					<?= form_checkbox('status[]', 'Submission proof.', in_array('Submission proof.', $status), ['id' => "proof"]) ?>
					<?= form_label('Submission proof.', 'proof') ?>
				</div>
			</div>
		</div>
		<div class="col-<?= ($image) ? 10 : 12 ?>">
			<div class="form-group">
				<label for="image">Submission proof image.</label>
				<div class="input-group">
					<div class="custom-file">
						<input type="file" name="image" class="custom-file-input" id="image" accept=".png,.jpeg,.jpg">
						<label class="custom-file-label" for="image">Choose file (jpg, jpeg, png only.)</label>
					</div>
				</div>
			</div>
		</div>
		<?php if ($image):
		echo img(['src' => 'assets/images/status/'.$image, 'class' => 'col-2']);
		endif ?>
	</div>
</div>