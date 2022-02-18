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
            <?= form_label('Inquiry Type', 'inquiry_type') ?>
            <?= form_dropdown('inquiry_type', ['IELTS' => 'IELTS', 'Visitor' => 'Visitor Visa', 'Student' => 'Student Visa', 'Permanent Residency' => 'Permanent Residency'], set_value('inquiry_type'), [
            'class' => 'form-control',
            'onchange' => "getCountry(this.value)",
            'data-dependent' => "inquiry_country",
            'data-value' => set_value('inquiry_country'),
            'id' => "inquiry_type"
            ]) ?>
            <?= form_error('inquiry_type') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Inquiry Country', 'inquiry_country') ?>
            <?= form_dropdown('inquiry_country', [], set_value('inquiry_country'), [
            'class' => 'form-control select2',
            'id' => "inquiry_country"
            ]) ?>
            <?= form_error('inquiry_country') ?>
          </div>
        </div>
        <?php if (!in_array($this->role, ['IELTS Operation'])): ?>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Counselor', 'counselor') ?>
            <?php $con[''] = 'Select Counselor'; foreach ($counselors as $cons):
            $con[e_id($cons['id'])] = ucwords($cons['name']);
            endforeach ?>
            <?= form_dropdown('counselor', $con, set_value('counselor'), [
            'class' => 'form-control select2',
            'id' => "counselor"
            ]) ?>
            <?= form_error('counselor') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('IELTS', 'ielts') ?>
            <?php $iel[''] = 'Select IELTS Operation'; foreach ($ielts as $i):
            $iel[e_id($i['id'])] = ucwords($i['name']);
            endforeach ?>
            <?= form_dropdown('ielts', $iel, set_value('ielts'), [
            'class' => 'form-control select2',
            'id' => "ielts"
            ]) ?>
          </div>
        </div>
        <?php endif ?>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Name', 'name') ?>
            <?= form_input([
            'name' => "name",
            'class' => "form-control",
            'id' => "name",
            'placeholder' => "Enter Name",
            'value' => set_value('name')
            ]) ?>
            <?= form_error('name') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Mobile', 'mobile') ?>
            <?= form_input([
            'name' => "mobile",
            'class' => "form-control",
            'id' => "mobile",
            'maxlength' => 10,
            'placeholder' => "Enter Mobile",
            'value' => set_value('mobile')
            ]) ?>
            <?= form_error('mobile') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Email', 'email') ?>
            <?= form_input([
            'type' => "email",
            'min' => 0,
            'name' => "email",
            'class' => "form-control",
            'id' => "email",
            'placeholder' => "Enter Email",
            'value' => set_value('email')
            ]) ?>
            <?= form_error('email') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Reference', 'reference') ?>
            <?= form_input([
            'name' => "reference",
            'class' => "form-control",
            'id' => "reference",
            'placeholder' => "Enter Reference",
            'value' => set_value('reference')
            ]) ?>
            <!-- <?= form_dropdown('reference', ['Walking' => 'Walking', 'Landline' => 'Landline', 'Mobile' => 'Mobile'], set_value('reference'), [
            'class' => 'form-control',
            'id' => "reference"
            ]) ?> -->
            <?= form_error('reference') ?>
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