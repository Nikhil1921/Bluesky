<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-danger card-outline">
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
    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover datatable">
        <thead>
          <tr>
            <th class="target">Sr. No.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Last Follow</th>
            <th>Status</th>
            <th class="target">Remarks</th>
            <!-- <th class="target">IELTS</th> -->
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
        <h4 class="modal-title">Add Follow Up</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body">
        <?= form_open($url.'/follow'); ?>
        <input type="hidden" id="lead_id" name="lead_id" />
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <?= form_label('Follow Up', 'follow') ?>
              <?php
              $con['Follow Up'] = 'Follow Up';
              $con['Not Interested'] = 'Not Interested' ?>
              <?= form_dropdown('follow', $con, '',
              [
              'class' => 'form-control',
              'id' => 'follow'
              ]) ?>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <?= form_label('Follow Date', 'follow_date') ?>
              <div class="input-group date" id="follow_date" data-target-input="nearest">
                <?= form_input([
                'class' => "form-control datetimepicker-input",
                'id' => "from",
                'name' => "follow_date",
                'data-target' => "#follow_date",
                'data-toggle' => "datetimepicker",
                'placeholder' => "Select Follow Date",
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
              <?= form_label('Follow Time', 'follow_time') ?>
              <div class="input-group">
                <div class="input-group date"  data-target-input="nearest" id="follow_time">
                  <input type="text" class="form-control datetimepicker-input" data-target="#follow_time" data-toggle="datetimepicker" name="follow_time" value="<?= date('h:i A') ?>" />
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
<div class="modal fade" id="follow-ups">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Follow Up(s)</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body" id="show-history">
      </div>
      <div class="modal-footer justify-content-between">
        <?= form_button([ 'content' => 'Close', 'type'  => 'button','class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
        <?= form_button([ 'content' => 'Close Follow Up(s)', 'type'  => 'button','class' => 'btn btn-outline-primary', 'data-dismiss' => "modal"]); ?>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="asign-counselor">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Assign Lead</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body">
        <?= form_open($url.'/counselor'); ?>
        <input type="hidden" id="inquiry_id" name="lead_id" />
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