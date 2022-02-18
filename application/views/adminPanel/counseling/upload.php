<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-danger card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?php $documents = json_decode($data['documents']);
    if (empty($data['documents'])): ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 alert alert-danger">
          <span>Please select documents first to upload.</span>
        </div>
      </div>
    </div>
    <?php else:
    foreach ($documents as $k => $v): ?>
    <?= form_open_multipart($url.'/upload/'.$id.'/'.$form, '', ['document' => $v->document, 'unlink' => (isset($v->img)) ? $v->img : '', 'column' => 'documents', 'table' => $table]) ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label(ucwords($v->document), 'image') ?>
            <div class="input-group">
              <div class="custom-file">
                <?= form_input([
                'type' => "file",
                'name' => "image",
                'class' => "custom-file-input",
                'id' => "image",
                'accept' => '.png,.jpeg,.jpg,',
                'onchange' => 'this.form.submit()'
                ]) ?>
                <?= form_label('Select image', 'image', ['class' => 'custom-file-label']) ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <?= (isset($v->img)) ? img(['src' => 'assets/images/documents/'.$v->img, 'height' => 100, 'width' => 100, 'class' => 'zoom-img']) : 'Upload Pending.' ?>
        </div>
      </div>
    </div>
    <?= form_close() ?>
    <?php endforeach ?>
    <?php if (isset($data['spouse_documents']) && $data['documents']): ?>
    <div class="col-12">
      <input type="text" class="form-control is-warning mb-3 text-center" value="Spouse Documents" disabled="">
    </div>
    <?php $spouse_documents = json_decode($data['spouse_documents']); foreach ($spouse_documents as $k => $v): ?>
    <?= form_open_multipart($url.'/upload/'.$id.'/'.$form, '', ['document' => $v->document, 'unlink' => (isset($v->img)) ? $v->img : '', 'column' => 'spouse_documents', 'table' => $table]) ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label(ucwords($v->document), 'image') ?>
            <div class="input-group">
              <div class="custom-file">
                <?= form_input([
                'type' => "file",
                'name' => "image",
                'class' => "custom-file-input",
                'id' => "image",
                'accept' => '.png,.jpeg,.jpg,',
                'onchange' => 'this.form.submit()'
                ]) ?>
                <?= form_label('Select image', 'image', ['class' => 'custom-file-label']) ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <?= (isset($v->img)) ? img(['src' => 'assets/images/documents/'.$v->img, 'height' => 100, 'width' => 100]) : 'Upload Pending.' ?>
        </div>
      </div>
    </div>
    <?= form_close() ?>
    <?php endforeach ?>
    <?php endif ?>
    <?php endif ?>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6">
          <?= anchor($url, 'Go Back', 'class="btn btn-outline-danger col-md-4"'); ?>
        </div>
      </div>
    </div>
  </div>
</div>