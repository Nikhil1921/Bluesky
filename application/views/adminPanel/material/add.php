<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?= form_open_multipart($url.'/add') ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Title', 'title') ?>
            <?= form_input([
            'name' => "title",
            'class' => "form-control",
            'id' => "title",
            'placeholder' => "Enter title",
            'value' => set_value('title')
            ]) ?>
            <?= form_error('title') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label("Material", 'image') ?>
            <div class="input-group">
              <div class="custom-file">
                <?= form_input([
                'type' => "file",
                'name' => "image",
                'class' => "custom-file-input",
                'id' => "image",
                'accept' => '.png,.jpeg,.jpg,.pdf'
                ]) ?>
                <?= form_label('Select material', 'image', ['class' => 'custom-file-label']) ?>
              </div>
            </div>
            <?= (isset($img_error)) ? '<strong class="text-danger" style="font-size: 0.8rem;">* '.$img_error.'</strong>' : '' ?>
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