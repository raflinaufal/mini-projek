<!doctype html>
<html>

<head>
	<title>harviacode.com - codeigniter crud generator</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" />

</head>

<body>
	<h2 style="margin-top:0px">Users <?php echo $button ?></h2>
	<form action="<?php echo $action; ?>" method="post">
		<div class="form-group">
			<label for="varchar">Name <?php echo form_error('name') ?></label>
			<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
		</div>
		<div class="form-group">
			<label for="varchar">Email <?php echo form_error('email') ?></label>
			<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
		</div>
		<div class="form-group">
			<label for="varchar">Password <?php echo form_error('password') ?></label>
			<input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
		</div>
		<div class="form-group">
			<label for="enum">Role <?php echo form_error('role') ?></label>
			<input type="text" class="form-control" name="role" id="role" placeholder="Role" value="<?php echo $role; ?>" />
		</div>
		<div class="form-group">
			<label for="timestamp">Created At <?php echo form_error('created_at') ?></label>
			<input type="text" class="form-control" name="created_at" id="created_at" placeholder="Created At" value="<?php echo $created_at; ?>" />
		</div>
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
		<a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a>
	</form>
</body>

</html>