<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user/dashboard');  ?>">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item active">
		<a class="nav-link" href="<?= base_url('user/dashboard');  ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>




	<!-- Divider -->
	<hr class="sidebar-divider">






	<!-- Nav Item - Users -->
	<li class="nav-item">
		<a class="nav-link" href="#" id="navUsers">
			<i class="fas fa-fw fa-users"></i>
			<span>Users</span>
		</a>
	</li>


	<?php $role = $this->session->userdata('role');  ?>
	<!-- Nav Item - Users -->
	<?php if ($role == 'Admin'):  ?>
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('products') ?>">
				<i class="fas fa-fw fa-users"></i>
				<span>Produk</span>
				<span>Role : <?php echo $role;  ?></span>
			</a>
		</li>
	<?php endif;  ?>







</ul>


<script>
	// Periksa role user
	const userRole = '<?= $this->session->userdata('role') ?>'; // Ambil role dari session

	document.getElementById('navUsers').addEventListener('click', function(event) {
		if (userRole !== 'Admin') {
			event.preventDefault(); // Cegah redirect
			Swal.fire({
				icon: 'error',
				title: 'Akses Ditolak',
				text: 'Anda tidak bisa akses halaman ini, Anda bukan admin.',
			});
		} else {
			// Redirect jika user adalah admin
			window.location.href = '<?= base_url('user/user-list') ?>';
		}
	});
</script>