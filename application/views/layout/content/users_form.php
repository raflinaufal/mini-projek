<h2 style="margin-top:0px">Users Create</h2>
<form action="<?php echo base_url('user/create_action'); ?>" method="post">
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo set_value('name'); ?>" />
		<!-- Menampilkan error validasi untuk name -->
		<?php echo form_error('name', '<small class="text-danger">', '</small>'); ?>
	</div>

	<div class="form-group">
		<label for="email">Email</label>
		<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo set_value('email'); ?>" />
		<!-- Menampilkan error validasi untuk email -->
		<?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo set_value('password'); ?>" />
		<!-- Menampilkan error validasi untuk password -->
		<?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
	</div>

	<div class="form-group">
		<label for="role">Role</label>
		<select class="form-control" name="role" id="role">
			<option value="" disabled selected>Select Role</option>
			<option value="Admin" <?= set_value('role') == 'Admin' ? 'selected' : ''; ?>>Admin</option>
			<option value="User" <?= set_value('role') == 'User' ? 'selected' : ''; ?>>User</option>
		</select>
		<!-- Menampilkan error validasi untuk role -->
		<?php echo form_error('role', '<small class="text-danger">', '</small>'); ?>
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
	<a href="<?php echo site_url('user/user-list'); ?>" class="btn btn-default">Cancel</a>
</form>