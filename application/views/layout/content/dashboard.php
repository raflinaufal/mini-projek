<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Dashboard Penjualan</h1>
	<div class="dropdown">
		<button class="btn btn-sm btn-primary shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-download fa-sm text-white-50"></i> Generate Report
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="<?= base_url('dashboard/export_pdf') ?>">
				<i class="fas fa-file-pdf text-danger"></i> Export to PDF
			</a>
			<a class="dropdown-item" href="<?= base_url('dashboard/export_excel') ?>">
				<i class="fas fa-file-excel text-success"></i> Export to Excel
			</a>
		</div>
	</div>
</div>


<!-- Content Row -->
<!-- <div class="row">
	<div class="col-12">
		<h1 class="h3 mb-4 text-gray-800">Dashboard Penjualan</h1>
	</div>
</div> -->

<div class="row">
	<!-- Filter Form -->
	<div class="col-md-12">
		<form method="get" class="form-inline mb-4">
			<label for="start_date" class="mr-2">Start Date:</label>
			<input type="date" id="start_date" name="start_date" class="form-control mr-3" value="<?= $start_date ?>">

			<label for="end_date" class="mr-2">End Date:</label>
			<input type="date" id="end_date" name="end_date" class="form-control mr-3" value="<?= $end_date ?>">

			<button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
		</form>
	</div>
</div>

<div class="row">
	<!-- Table -->
	<div class="col-md-12">
		<h2 class="h5 mb-4 text-gray-800">Data Penjualan</h2>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead class="thead-light">
					<tr>
						<th>ID</th>
						<th>Product Name</th>
						<th>Amount</th>
						<th>Sale Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($sales)) : ?>
						<?php foreach ($sales as $sale): ?>
							<tr>
								<td><?= $sale['id'] ?></td>
								<td><?= $sale['product_name'] ?></td>
								<td><?= number_format($sale['amount'], 2) ?></td>
								<td><?= $sale['sale_date'] ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="4" class="text-center">No data available</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<!-- Content Row -->

<div class="row">
	<!-- Area Chart -->
	<div class="col-xl-12 col-lg-7">
		<div class="card shadow mb-4">
			<!-- Card Header -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Traffic Penjualan</h6>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<div class="chart-area">
					<canvas id="salesChart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	// Data untuk chart
	var ctx = document.getElementById("salesChart").getContext("2d");
	var salesChart = new Chart(ctx, {
		type: 'bar', // Tipe chart
		data: {
			labels: <?= json_encode(array_column($sales, 'product_name')) ?>, // Label produk
			datasets: [{
				label: "Penjualan",
				data: <?= json_encode(array_column($sales, 'amount')) ?>, // Data penjualan
				backgroundColor: 'rgba(78, 115, 223, 0.5)', // Warna latar
				borderColor: 'rgba(78, 115, 223, 1)', // Warna garis
				borderWidth: 1
			}]
		},
		options: {
			maintainAspectRatio: false,
			layout: {
				padding: {
					left: 10,
					right: 25,
					top: 25,
					bottom: 0
				}
			},
			scales: {
				x: {
					grid: {
						display: false, // Sembunyikan grid vertikal
						drawBorder: false
					}
				},
				y: {
					ticks: {
						beginAtZero: true, // Mulai dari nol
						padding: 10,
						callback: function(value, index, values) {
							return value.toLocaleString(); // Format angka
						}
					},
					grid: {
						color: "rgb(234, 236, 244)",
						zeroLineColor: "rgb(234, 236, 244)",
						drawBorder: false,
						borderDash: [2],
						zeroLineBorderDash: [2]
					}
				}
			},
			plugins: {
				legend: {
					display: true // Tampilkan label legenda
				},
				tooltip: {
					backgroundColor: "rgb(255,255,255)",
					bodyColor: "#858796",
					titleColor: '#6e707e',
					borderColor: '#dddfeb',
					borderWidth: 1,
					xPadding: 15,
					yPadding: 15,
					displayColors: false,
					caretPadding: 10
				}
			}
		}
	});
</script>


<script>
	<?php if ($this->session->flashdata('error')): ?>
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: '<?= $this->session->flashdata('error') ?>',
		});
	<?php endif; ?>

	<?php if ($this->session->flashdata('success')): ?>
		Swal.fire({
			icon: 'success',
			title: 'Berhasil!',
			text: '<?= $this->session->flashdata('success') ?>',
		});
	<?php endif; ?>
</script>