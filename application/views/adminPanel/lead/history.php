<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Sr. No.</th>
      <th>Follow Date</th>
      <th>Follow Time</th>
      <th>Create Date</th>
      <th>Followed By</th>
      <th>Remarks</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($history): ?>
    <?php foreach ($history as $k => $v): ?>
    <tr>
      <td><?= $k + 1 ?></td>
      <td><?= date('d-m-Y', strtotime($v->follow_date)) ?></td>
      <td><?= date('h:i A', strtotime($v->follow_time)) ?></td>
      <td><?= date('d-m-Y h:i A', strtotime($v->created_at)) ?></td>
      <td><?= ucwords($v->name) ?></td>
      <td><?= $v->remarks ?></td>
      <td><?= $v->status ?></td>
    </tr>
    <?php endforeach ?>
    <?php else: ?>
    <tr>
      <td colspan="7" class="text-center">No History Available.</td>
    </tr>
    <?php endif ?>
  </tbody>
</table>