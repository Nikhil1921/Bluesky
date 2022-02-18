<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-hover">
        <thead>
              <th>Sr. No.</th>
              <th>Date</th>
              <th>Fees</th>
              <th>Remarks</th>
              <th>Fees For</th>
              <th>Print</th>
        </thead>
        <tbody>
          <?php foreach ($fees as $k => $v): $v = (object) $v; ?>
            <tr>
              <td><?= ++$k ?></td>
              <td><?= date('d-m-Y h:i A', strtotime($v->created_at)) ?></td>
              <td><?= $v->fees ?></td>
              <td><?= $v->remarks ?></td>
              <td><?= $v->fee_type ?></td>
              <td><?= anchor($url.'/invoice/'.e_id($v->id), '<i class="fa fa-print"></i>', ['class' => 'btn btn-outline-primary mr-2']); ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>