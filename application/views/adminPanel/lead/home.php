<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-<?= (in_array($this->role, ['LMS'])) ? 7 : 9 ?>">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="form-control float-right" id="daterange">
            <div class="input-group-prepend" id="cleardaterange">
              <span class="input-group-text">
                <i class="fa fa-undo"></i>
              </span>
            </div>
          </div>
        </div>
        <?php if (in_array($this->role, ['LMS'])): ?>
        <div class="col-sm-2">
          <?= anchor($url.'/import', 'Import', 'class="btn btn-block btn-outline-success btn-sm"') ?>
        </div>
        <?php endif ?>
      </div>
    </div>
    <input type="hidden" id="new_lead" value="1">
    <input type="hidden" id="archive" value="0">
    <div class="card-header">
      <form name="assign-lms" id="assign-lms" action="<?= base_url($url.'/lms') ?>" onsubmit="return false;" class="float-right">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <?php foreach ($lms as $va) {
              $cons[e_id($va['id'])] = ucwords($va['name']);
              } ?>
              <?= form_dropdown('lms', $cons, set_value('lms'),
              [
              'class' => 'form-control',
              'id' => "lms"
              ]) ?>
            </div>
          </div>
          <div class="col-md-6">
            <?= form_button([ 'content' => 'Save changes', 'type'  => 'submit', 'class' => 'btn btn-outline-primary']); ?>
          </div>
        </div>
      </form>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-hover datatable">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Create Date</th>
            <th>Country</th>
            <th>Visa Type</th>
            <!-- <th>Action</th> -->
            <th></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>