<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-10">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
        <?php if (in_array($this->role, ['IELTS Operation'])): ?>
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
            <th>Book</th>
            <th class="target">Image</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Return Date</th>
            <th class="target">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="issue-book">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Issue Book</h4>
        <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
      </div>
      <div class="modal-body">
        <?= form_open($url.'/issue-book'); ?>
        <input type="hidden" class="inquiry_id" name="book_id" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <?= form_label('Student', 'student') ?>
              <?php $student[''] = 'Select Student'; foreach ($students as $va) {
              $student[e_id($va['id'])] = ucwords($va['name']);
              } ?>
              <?= form_dropdown('student', $student, set_value('student'),
              [
              'class' => 'form-control select2',
              'id' => "student"
              ]) ?>
            </div>
          </div>
        <div class="col-6">
          <div class="form-group">
            <?= form_label('Return Date', 'from_date') ?>
            <div class="input-group date" id="from_date" data-target-input="nearest">
              <?= form_input([
              'class' => "form-control datetimepicker-input",
              'id' => "from",
              'name' => "return",
              'data-target' => "#from_date",
              'data-toggle' => "datetimepicker",
              'placeholder' => "Select Return Date",
              'value' => date('m/d/Y', strtotime('+7 days'))
              ]) ?>
              <div class="input-group-append" data-target="#from_date" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
              </div>
            </div>
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