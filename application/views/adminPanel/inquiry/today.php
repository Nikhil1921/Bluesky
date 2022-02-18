<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-<?= (in_array($this->role, ['Reception'])) ? 10 : 12 ?>">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
        <?php if (in_array($this->role, ['Reception'])): ?>
        <div class="col-sm-2">
          <?= anchor($url.'/add', 'Add', 'class="btn btn-block btn-outline-success btn-sm"'); ?>
        </div>
        <?php endif ?>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-hover datatable">
        <thead>
          <tr>
            <th class="target">Sr. No.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>First Visit</th>
            <th>Last Update</th>
            <th>Country</th>
            <th>Visa Type</th>
            <th>Reference</th>
            <th>Inquiry Type</th>
            <th class="target">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="asign-counselor">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Assign Inquiry</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body">
        <?= form_open($url.'/counselor'); ?>
        <input type="hidden" id="inquiry_id" name="inquiry_id" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <?= form_label('Counselor', 'counselor') ?>
              <?php $cons[''] = 'Select Counselor'; foreach ($counselors as $va) {
              $cons[e_id($va['id'])] = ucwords($va['name']);
              } ?>
              <?= form_dropdown('counselor', $cons, set_value('counselor'),
              [
              'class' => 'form-control',
              'id' => "counselor"
              ]) ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?= form_label('IELTS Operation', 'ielts') ?>
              <?php $iel[''] = 'Select IELTS Operation'; foreach ($ielts as $i) {
              $iel[e_id($i['id'])] = ucwords($i['name']);
              } ?>
              <?= form_dropdown('ielts', $iel, set_value('ielts'),
              [
              'class' => 'form-control',
              'id' => "ielts"
              ]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <?= form_label('Remarks', 'remarks') ?>
              <?= form_textarea([
              'type' => "remarks",
              'name' => "remarks",
              'class' => "form-control",
              'id' => "remarks",
              'placeholder' => "Enter Remarks",
              'value' => set_value('remarks')
              ]) ?>
              <?= form_error('remarks') ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <?= form_button([ 'content' => 'Close', 'type'  => 'button','class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
        <?= form_button([ 'content' => 'Save changes', 'type'  => 'submit','class' => 'btn btn-outline-primary']); ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="archive" value="0">
<input type="hidden" id="today" value="<?= date('Y-m-d') ?>">