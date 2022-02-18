<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Sr. No.</th>
			<th>Name</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Issue By</th>
			<th>Date</th>
			<th>Type</th>
			<th>Remarks</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($history): ?>
		<?php foreach ($history as $k => $v): ?>
		<tr>
			<td><?= $k + 1 ?></td>
			<td><?= ucwords($v->name) ?></td>
			<td><?= $v->mobile ?></td>
			<td><?= $v->email ?></td>
			<td><?= ucwords($v->issued_by) ?></td>
			<td><?= date('d-m-Y h:i A', strtotime($v->issued_at)) ?></td>
			<td><?= $v->issue_type ?></td>
			<td><?= $v->remarks ?></td>
		</tr>
		<?php endforeach ?>
		<?php else: ?>
		<tr>
			<td colspan="5" class="text-center">No History Available.</td>
		</tr>
		<?php endif ?>
	</tbody>
</table>