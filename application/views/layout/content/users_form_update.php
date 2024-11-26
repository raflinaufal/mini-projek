<h2 style="margin-top:0px"><?php echo $button; ?> User</h2>
<form action="<?php echo $action; ?>" method="post">
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
		<?php echo form_error('name', '<small class="text-danger">', '</small>'); ?>
	</div>

	<div class="form-group">
		<label for="email">Email</label>
		<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
		<?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
	</div>

	<div class="form-group">
		<label for="password">Password (Leave blank if not updating)</label>
		<input type="text" class="form-control" name="password" id="password" placeholder="Password" />
		<?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
	</div>

	<div class="form-group">
		<label for="role">Role</label>
		<select class="form-control" name="role" id="role">
			<option value="" disabled>Select Role</option>
			<option value="Admin" <?= $role == 'Admin' ? 'selected' : ''; ?>>Admin</option>
			<option value="User" <?= $role == 'User' ? 'selected' : ''; ?>>User</option>
		</select>
		<?php echo form_error('role', '<small class="text-danger">', '</small>'); ?>
	</div>

	<!-- Hidden input untuk ID -->
	<input type="hidden" name="id" value="<?php echo $id; ?>" />

	<button type="submit" class="btn btn-primary">Update</button>
	<a href="<?php echo site_url('user/user-list'); ?>" class="btn btn-default">Cancel</a>
</form>