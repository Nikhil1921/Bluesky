<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-<?= (in_array($this->role, ['Operation', 'Super Admin'])) ? 4 : 7 ?>">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
        <div class="col-sm-2">
          <?= form_dropdown('client_type', [ '' => 'Select Type', 'Inquiry' => 'Inquiry', 'Lead' => 'Lead' ], set_value('client_type'), [
          'class' => 'form-control select2',
          'id' => "client_type"
          ]) ?>
        </div>
        <?php if (in_array($this->role, ['Operation', 'Super Admin'])): ?>
        <div class="col-md-3">
          <div class="form-group">
            <?php $cons[0] = "Select Counseler"; foreach ($counselers as $va) {
            $cons[e_id($va['id'])] = ucwords($va['name']);
            } ?>
            <?= form_dropdown('lmsemp', $cons, set_value('lms'),
            [
            'class' => 'form-control select2',
            'id' => "lmsemp"
            ]) ?>
          </div>
        </div>
        <?php endif ?>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="form-control float-right" id="daterange">
            <div class="input-group-prepend" id="cleardaterange">
              <span class="input-group-text">
                <i class="fa fa-undo"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item col-6">
        <a class="nav-link active change-lead text-center btn btn-outline-primary" data-toggle="pill" href="" role="tab" data-status="0">Counseling</a>
      </li>
      <li class="nav-item col-6">
        <a class="nav-link change-lead text-center btn btn-outline-primary" data-toggle="pill" href="" role="tab" data-status="1">Archived Counseling</a>
      </li>
    </ul>
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
            <?php if (in_array($this->role, ['Counselor'])): ?>
            <!-- <th class="target">IELTS</th> -->
            <th class="target">Creds</th>
            <?php endif ?>
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
        <h4 class="modal-title">Add Counseling</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body">
        <?= form_open($url.'/counseling'); ?>
        <input type="hidden" class="inquiry_id" name="inquiry_id" />
        <div class="col-md-12">
          <div class="form-group">
            <?= form_label('Remarks', 'remarks') ?>
            <?= form_textarea([
            'type' => "remarks",
            'name' => "remarks",
            'class' => "form-control",
            /*'id' => "remarks",*/
            'placeholder' => "Enter Remarks",
            'value' => set_value('remarks')
            ]) ?>
            <?= form_error('remarks') ?>
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
<div class="modal fade" id="<?= ($consultant) ? 'asign-consultant' : '' ?>">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Assign Lead</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body">
        <?= form_open($url.'/consult'); ?>
        <input type="hidden" class="inquiry_id" name="inquiry_id" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <?= form_label('Consultant', 'consultant') ?>
              <?php $consul[''] = 'Select Consultant'; foreach ($consultant as $consult) {
              $consul[e_id($consult['id'])] = ucwords($consult['name']);
              } ?>
              <?= form_dropdown('consultant', $consul, set_value('consultant'),
              [
              'class' => 'form-control select2',
              'id' => "consultant"
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
              /*'id' => "remarks",*/
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