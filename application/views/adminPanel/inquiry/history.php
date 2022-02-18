<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Sr. No.</th>
			<th>Log Date</th>
			<th>Counselor/Consultant</th>
			<th>Created By</th>
			<th>Remarks</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($history): ?>
		<?php foreach ($history as $k => $v): ?>
		<tr>
			<td><?= $k + 1 ?></td>
			<td><?= date('d-m-Y h:i A', strtotime($v->created_at)) ?></td>
			<td><?= ucwords($v->name) ?></td>
			<td><?= ucwords($v->created_by) ?></td>
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