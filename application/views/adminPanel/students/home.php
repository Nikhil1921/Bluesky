<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-<?= (in_array($this->role, ['Operation', 'Super Admin'])) ? 6 : 9 ?>">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
        <?php if (in_array($this->role, ['Operation', 'Super Admin'])): ?>
        <div class="col-md-3">
          <div class="form-group">
            <?php $cons[0] = "Select IELTS Coaching"; foreach ($consultant as $va) {
            $cons[e_id($va['id'])] = ucwords($va['name']);
            } ?>
            <?= form_dropdown('lmsemp', $cons, set_value('lms'),
            [
            'class' => 'form-control select2',
            'id' => "lmsemp"
            ]) ?>
          </div>
        </div>
        <?php endif ?>
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
      </div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item col-6">
        <a class="nav-link active change-lead text-center btn btn-outline-primary" data-toggle="pill" href="" role="tab" data-status="0">Coaching</a>
      </li>
      <li class="nav-item col-6">
        <a class="nav-link change-lead text-center btn btn-outline-primary" data-toggle="pill" href="" role="tab" data-status="1">Archived Coaching</a>
      </li>
    </ul>
    <div class="card-body table-responsive">
      <table class="table table-striped table-hover datatable">
        <thead>
          <tr>
            <th class="target">Sr. No.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Grammer</th>
            <th>Batch</th>
            <th class="target">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<input type="hidden" id="archive" value="0">