<h2 style="margin-top:0px">Users Read</h2>
<table class="table">
	<tr>
		<td>Name</td>
		<td><?php echo $name; ?></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><?php echo $email; ?></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><?php echo $password; ?></td>
	</tr>
	<tr>
		<td>Role</td>
		<td><?php echo $role; ?></td>
	</tr>
	<tr>
		<td>Created At</td>
		<td><?php echo $created_at; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><a href="<?php echo site_url('user/user-list') ?>" class="btn btn-primary">Cancel</a></td>
	</tr>