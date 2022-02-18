<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<?php if ($history): ?>
<table class="table">
	<thead>
		<tr>
			<th>No.</th>
			<th>Date</th>
			<th>Batch</th>
			<th>Attendance</th>
			<th>Coach</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($history as $k => $a): ?>
		<tr>
			<td><?= $k+1 ?></td>
			<td><?= date('d-m-Y', strtotime($a['att_date'])) ?></td>
			<td><?= ucwords($a['batch_name']) ?></td>
			<td><?= '<span class="badge badge-'.(($a['attendance'] === 'Absent') ? 'danger' : 'success').'">'.$a['attendance'].'</span>' ?></td>
			<td><?= ucwords($a['coach']) ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php else: ?>
<div class="text-center">No history available.</div>
<?php endif ?>