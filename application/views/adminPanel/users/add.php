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
            <?= form_label('Password', 'password') ?>
            <?= form_input([
            'type' => "password",
            'min' => 0,
            'name' => "password",
            'class' => "form-control",
            'id' => "password",
            'placeholder' => "Enter Password"
            ]) ?>
            <?= form_error('password') ?>
          </div>
        </div>
        <?php if (in_array($this->role, ['Operation', 'Super Admin'])): ?>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Role', 'role') ?>
            <?= form_dropdown('role', ['Operation' => 'Operation', 'Reception' => 'Reception', 'LMS' => 'LMS', 'LMS Employee' => 'LMS Employee', 'Consultant' => 'Consultant', 'Counselor' => 'Counselor', 'IELTS Operation' => 'IELTS Operation', 'IELTS Coaching' => 'IELTS Coaching', 'Accountant' => 'Accountant'], set_value('role'), [
            'class' => 'form-control',
            'id' => "role"
            ]) ?>
            <?= form_error('role') ?>
          </div>
        </div>
        <?php elseif (in_array($this->role, ['IELTS Operation'])): ?>
        <?= form_input([
        'type' => "hidden",
        'name' => "role",
        'value' => 'IELTS Coaching'
        ]) ?>
        <?php else: ?>
        <?= form_input([
        'type' => "hidden",
        'name' => "role",
        'value' => 'LMS Employee'
        ]) ?>
        <?php endif ?>
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