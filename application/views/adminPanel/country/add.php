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
            <?= form_label('Country Name', 'country_name') ?>
            <?= form_input([
            'name' => "country_name",
            'class' => "form-control",
            'id' => "country_name",
            'placeholder' => "Enter Country Name",
            'value' => set_value('country_name')
            ]) ?>
            <?= form_error('country_name') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Visa Type', 'visa_type') ?>
            <?= form_dropdown('visa_type', ['IELTS' => 'IELTS', 'Visitor' => 'Visitor Visa', 'Student' => 'Student Visa', 'Permanent Residency' => 'Permanent Residency'], set_value('visa_type'), [
            'class' => 'form-control',
            'id' => "visa_type"
            ]) ?>
            <?= form_error('visa_type') ?>
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