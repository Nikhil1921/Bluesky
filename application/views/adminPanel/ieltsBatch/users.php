<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<?php if ($users): ?>
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Grammer</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $k => $u): ?>
		<tr>
			<td><?= ucfirst($u['name']) ?></td>
			<td><?= $u['mobile'] ?></td>
			<td><?= $u['email'] ?></td>
			<td><?= $u['grammer'] ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>' ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php else: ?>
<div class="text-center">No users available.</div>
<?php endif ?>