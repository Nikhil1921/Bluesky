<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Sr. No.</th>
			<th>Date</th>
			<th>Collected By</th>
			<th>Fees</th>
			<th>Remarks</th>
			<th>Fees For</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($history): ?>
		<?php foreach ($history as $k => $v): ?>
		<tr>
			<td><?= $k + 1 ?></td>
			<td><?= date('d-m-Y h:i A', strtotime($v->created_at)) ?></td>
			<td><?= ucwords($v->name) ?></td>
			<td><?= $v->fees ?></td>
			<td><?= $v->remarks ?></td>
			<td><?= $v->fee_type ?></td>
		</tr>
		<?php endforeach ?>
		<?php else: ?>
		<tr>
			<td colspan="6" class="text-center">No History Available.</td>
		</tr>
		<?php endif ?>
	</tbody>
</table>