<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<input type="hidden" name="id" value="<?= $id ?>" />
<?php if ($users): ?>
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Attendance</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $k => $u): ?>
		<tr>
			<td><?= ucfirst($u['name']) ?></td>
			<td><?= $u['mobile'] ?></td>
			<td><?= $u['email'] ?></td>
			<td>
				<div class="icheck-primary d-inline">
					<input type="checkbox" id="present_<?= e_id($u['id']) ?>" name="present[]" value="<?= e_id($u['id']) ?>" />
					<label for="present_<?= e_id($u['id']) ?>">
					</label>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php else: ?>
<div class="text-center">No users available.</div>
<?php endif ?>