<!doctype html>
<html>

<head>
	<title>harviacode.com - codeigniter crud generator</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>" />

</head>

<body>
	<div class="row" style="margin-bottom: 10px">
		<div class="col-md-4">
			<h2 style="margin-top:0px">Users List</h2>
		</div>
		<div class="col-md-4 text-center">
			<div style="margin-top: 4px" id="message">
				<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
			</div>
		</div>
		<div class="col-md-4 text-right">
			<?php echo anchor(site_url('user/create'), 'Create', 'class="btn btn-primary"'); ?>
		</div>
	</div>
	<table class="table table-bordered table-striped" id="mytable">
		<thead>
			<tr>
				<th width="80px">No</th>
				<th>Name</th>
				<th>Email</th>
				<th>Password</th>
				<th>Role</th>
				<th>Created At</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$start = 0;
			foreach ($users_data as $users) {
			?>
				<tr>
					<td><?php echo ++$start ?></td>
					<td><?php echo $users->name ?></td>
					<td><?php echo $users->email ?></td>
					<td><?php echo $users->password ?></td>
					<td><?php echo $users->role ?></td>
					<td><?php echo $users->created_at ?></td>
					<td style="text-align:center" width="200px">
						<?php
						echo anchor(site_url('user/read/' . $users->id), 'Read');
						echo ' | ';
						echo anchor(site_url('user/update/' . $users->id), 'Update');
						echo ' | ';
						echo anchor(site_url('user/delete_user/' . $users->id), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
						?>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
	<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#mytable").dataTable();
		});
	</script>
</body>

</html>