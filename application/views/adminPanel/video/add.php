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
            <?= form_label('Video title', 'video_title') ?>
            <?= form_input([
            'name' => "video_title",
            'class' => "form-control",
            'id' => "video_title",
            'placeholder' => "Enter video title",
            'value' => set_value('video_title')
            ]) ?>
            <?= form_error('video_title') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Video url', 'video_url') ?>
            <?= form_input([
            'name' => "video_url",
            'class' => "form-control",
            'id' => "video_url",
            'placeholder' => "Enter video url",
            'value' => set_value('video_url')
            ]) ?>
            <?= form_error('video_url') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label("Image", 'image') ?>
            <div class="input-group">
              <div class="custom-file">
                <?= form_input([
                'type' => "file",
                'name' => "image",
                'class' => "custom-file-input",
                'id' => "image",
                'accept' => '.png,.jpeg,.jpg,'
                ]) ?>
                <?= form_label('Select image', 'image', ['class' => 'custom-file-label']) ?>
              </div>
            </div>
            <?= (isset($img_error)) ? '<strong class="text-danger" style="font-size: 0.8rem;">* '.$img_error.'</strong>' : '' ?>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <?= form_label('Video Description', 'description') ?>
            <?= form_textarea([
            'name' => "description",
            'class' => "form-control",
            'id' => "description",
            'placeholder' => "Enter Video description",
            'value' => set_value('description')
            ]) ?>
            <?= form_error('description') ?>
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