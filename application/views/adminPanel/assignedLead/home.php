<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-<?= (in_array($this->role, ['Operation', 'Super Admin', 'LMS'])) ? 6 : 9 ?>">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
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
        <?php if (in_array($this->role, ['Operation', 'Super Admin', 'LMS'])): ?>
        <div class="col-md-3">
          <div class="form-group">
            <?php $cons[0] = "Select Employee"; foreach ($lms as $va) {
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
      </div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item col-6">
        <a class="nav-link active change-lead text-center btn btn-outline-primary" data-toggle="pill" href="" role="tab" data-status="0">Current Leads</a>
      </li>
      <li class="nav-item col-6">
        <a class="nav-link change-lead text-center btn btn-outline-primary" data-toggle="pill" href="" role="tab" data-status="1">Archived Leads</a>
      </li>
    </ul>
    <input type="hidden" id="new_lead" value="0">
    <input type="hidden" id="archive" value="0">
    <div class="card-body table-responsive">
      <table class="table table-striped table-hover datatable">
        <thead>
          <tr>
            <th class="target">Sr. No.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Create Date</th>
            <th>Country</th>
            <th>Visa Type</th>
            <th>LMS Employee</th>
            <th class="target">Remarks</th>
            <th class="target">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="add-follow-up">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Meeting</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body">
        <?= form_open($url.'/meeting'); ?>
        <input type="hidden" id="lead_id" name="lead_id" />
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <?= form_label('Meeting Date', 'follow_date') ?>
              <div class="input-group date" id="follow_date" data-target-input="nearest">
                <?= form_input([
                'class' => "form-control datetimepicker-input",
                'id' => "from",
                'name' => "meeting_date",
                'data-target' => "#follow_date",
                'data-toggle' => "datetimepicker",
                'placeholder' => "Select Meeting Date",
                'value' => date('m/d/Y', strtotime('+1 days'))
                ]) ?>
                <div class="input-group-append" data-target="#follow_date" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <?= form_label('Meeting Time', 'follow_time') ?>
              <div class="input-group">
                <div class="input-group date"  data-target-input="nearest" id="follow_time">
                  <input type="text" class="form-control datetimepicker-input" data-target="#follow_time" data-toggle="datetimepicker" name="meeting_time" value="<?= date('h:i A') ?>" />
                  <div class="input-group-append" data-target="#follow_time" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <?= form_label('Remarks', 'remarks') ?>
              <?= form_textarea('remarks', '', [
              'class' => 'form-control',
              'id' => 'remarks'
              ]) ?>
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