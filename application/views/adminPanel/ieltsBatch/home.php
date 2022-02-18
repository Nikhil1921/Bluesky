<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-10">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
        <?php if (in_array($this->role, ['Operation', 'Super Admin', 'IELTS Operation'])): ?>
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
            <th>Batch name</th>
            <th>From date</th>
            <th>To date</th>
            <th>From time</th>
            <th>To time</th>
            <?php if (!in_array($this->role, ['Operation', 'Super Admin', 'IELTS Coaching'])): ?>
            <th>Coach</th>
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
<div class="modal fade" id="ielts-batch">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Batch details</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body" id="show-batch">
        
      </div>
      <div class="modal-footer justify-content-between">
        <?= form_button([ 'content' => 'Close', 'type'  => 'button','class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
        <?= form_button([ 'content' => 'Close Batch details', 'type'  => 'button','class' => 'btn btn-outline-primary', 'data-dismiss' => "modal"]); ?>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="make-attendance">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Batch attendance</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <?= form_open($url.'/saveAttendance', 'id="attendance-sheet"') ?>
      <div class="modal-body" id="view-batch">
        
      </div>
      <div class="modal-footer justify-content-between">
        <?= form_button([ 'content' => 'Close', 'type'  => 'button','class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
        <?= form_button([ 'content' => 'Save attendance', 'type'  => 'button', 'class' => 'btn btn-outline-primary', 'onclick' => "saveAttendance('attendance-sheet')"]); ?>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>