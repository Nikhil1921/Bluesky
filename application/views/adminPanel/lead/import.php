<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?= form_open_multipart($url.'/import') ?>
    <div class="card-body">
      <div class="row">
        <!-- <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Lead Type', 'lead_type') ?>
            <?= form_dropdown('lead_type', ['Visitor' => 'Visitor Visa', 'Student' => 'Student Visa', 'Permanent Residency' => 'Permanent Residency'], set_value('lead_type'), [
              'class' => 'form-control',
              'onchange' => "getCountry(this.value)",
              'data-dependent' => "lead_country",
              'data-value' => set_value('lead_country'),
              'id' => "inquiry_type"
            ]) ?>
            <?= form_error('lead_type') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Lead Country', 'lead_country') ?>
            <?= form_dropdown('lead_country', [], set_value('lead_country'), [
              'class' => 'form-control select2',
              'id' => "lead_country"
            ]) ?>
            <?= form_error('lead_country') ?>
          </div>
        </div> -->
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Excel File', 'lead') ?>
            <div class="input-group">
              <div class="custom-file">
                <?= form_input([
                'type' => 'file',
                'name' => "lead",
                'class' => "custom-file-input",
                'id' => "lead",
                'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, .csv'
                ]) ?>
                <?= form_label('Choose Excel File', 'lead', 'class="custom-file-label"') ?>
              </div>
            </div>
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