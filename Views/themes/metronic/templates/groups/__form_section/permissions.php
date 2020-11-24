<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<td>
				<?= $form->name; ?>
				<label class="checkbox checkbox-success">
					<input type="checkbox" id="all_permission_group" name="all_permission_group" class="all_permission_group" value="">
					<span></span>
				</label>
			</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($permissions as $permission) { ?>
			<tr>
				<td>Handle: <?= ucfirst($permission->name); ?> <br /><em><?= $permission->description; ?></em></td>
				<td>
					<?php if (empty($permissionByIdGroupGroup)) { ?>
						<?php if ($form->id === '1') { ?>
							---
						<?php } else { ?>
							<label class="checkbox checkbox-success <?= ($form->id === '1') ? 'checkbox-success' : '' ?>">
								<input type="checkbox" name="permission_group[]" class="permission_group id_permission_group_<?= $form->id; ?>" value="<?= $form->id; ?>|<?= $permission->id; ?>">
								<span></span>
							</label>
						<?php } ?>
					<?php } else { ?>
						<label class="checkbox checkbox-success <?= isset($permissionByIdGroupGroup[$form->id][$permission->id]) ? 'checkbox-success' : '' ?>">
							<input type="checkbox" class="permission_group" <?= isset($permissionByIdGroupGroup[$form->id][$permission->id]) ? 'checked="checked"' : '' ?> name="permission_group[]" value="<?= $form->id; ?>|<?= $permission->id; ?>">
							<span></span>
						</label>
					<?php } ?>

				</td>
			</tr>
		<?php }  ?>
	</tbody>
</table>