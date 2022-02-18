<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?= form_open($url.'/add') ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Batch Name', 'batch_name') ?>
            <?= form_input([
            'name' => "batch_name",
            'class' => "form-control",
            'id' => "batch_name",
            'placeholder' => "Enter Batch Name",
            'value' => set_value('batch_name')
            ]) ?>
            <?= form_error('batch_name') ?>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <?= form_label('Coach', 'coach_id') ?>
            <?php $coach[''] = 'Select Coach'; foreach ($coachs as $c) {
            $coach[e_id($c['id'])] = ucwords($c['name']);
            } ?>
            <?= form_dropdown('coach_id', $coach, set_value('coach_id'),
            [
            'class' => 'form-control select2',
            'id' => "coach_id"
            ]) ?>
            <?= form_error('coach_id') ?>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <?= form_label('From Date', 'from_date') ?>
            <div class="input-group date" id="from_date" data-target-input="nearest">
              <?= form_input([
              'class' => "form-control datetimepicker-input",
              'id' => "from",
              'name' => "from_date",
              'data-target' => "#from_date",
              'data-toggle' => "datetimepicker",
              'placeholder' => "Select From Date",
              'value' => (set_value('from_date')) ? set_value('from_date') : date('m/d/Y')
              ]) ?>
              <div class="input-group-append" data-target="#from_date" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
              </div>
            </div>
            <?= form_error('from_date') ?>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <?= form_label('From Time', 'from_time') ?>
            <div class="input-group">
              <div class="input-group date"  data-target-input="nearest" id="from_time">
                <input type="text" class="form-control datetimepicker-input" data-target="#from_time" data-toggle="datetimepicker" name="from_time" value="<?= (set_value('from_time')) ? set_value('from_time') : date('h:i A') ?>" />
                <div class="input-group-append" data-target="#from_time" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div>
              </div>
            </div>
            <?= form_error('from_time') ?>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <?= form_label('To Date', 'to_date') ?>
            <div class="input-group date" id="to_date" data-target-input="nearest">
              <?= form_input([
              'class' => "form-control datetimepicker-input",
              'id' => "from",
              'name' => "to_date",
              'data-target' => "#to_date",
              'data-toggle' => "datetimepicker",
              'placeholder' => "Select To Date",
              'value' => (set_value('to_date')) ? set_value('to_date') : date('m/d/Y')
              ]) ?>
              <div class="input-group-append" data-target="#to_date" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
              </div>
            </div>
            <?= form_error('to_date') ?>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <?= form_label('To Time', 'to_time') ?>
            <div class="input-group">
              <div class="input-group date"  data-target-input="nearest" id="to_time">
                <input type="text" class="form-control datetimepicker-input" data-target="#to_time" data-toggle="datetimepicker" name="to_time" value="<?= (set_value('to_time')) ? set_value('to_time') : date('h:i A') ?>" />
                <div class="input-group-append" data-target="#to_time" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div>
              </div>
            </div>
            <?= form_error('to_time') ?>
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