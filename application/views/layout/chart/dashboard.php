<!DOCTYPE html>
<html>

<head>
	<title>Dashboard Penjualan</title>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
	<h1>Dashboard Penjualan</h1>
	<form method="get">
		<label>Start Date:</label>
		<input type="date" name="start_date" value="<?= $start_date ?>">
		<label>End Date:</label>
		<input type="date" name="end_date" value="<?= $end_date ?>">
		<button type="submit">Filter</button>
	</form>

	<h2>Data Penjualan</h2>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Product Name</th>
			<th>Amount</th>
			<th>Sale Date</th>
		</tr>
		<?php foreach ($sales as $sale): ?>
			<tr>
				<td><?= $sale['id'] ?></td>
				<td><?= $sale['product_name'] ?></td>
				<td><?= $sale['amount'] ?></td>
				<td><?= $sale['sale_date'] ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

	<h2>Grafik Penjualan</h2>
	<canvas id="salesChart"></canvas>

	<script>
		var ctx = document.getElementById('salesChart').getContext('2d');
		var chart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?= json_encode(array_column($sales, 'product_name')) ?>,
				datasets: [{
					label: 'Penjualan',
					data: <?= json_encode(array_column($sales, 'amount')) ?>,
					backgroundColor: 'rgba(54, 162, 235, 0.2)',
					borderColor: 'rgba(54, 162, 235, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>

	<h2>Export Data</h2>
	<a href="<?= base_url('dashboard/export_excel') ?>">Export ke Excel</a>
	<a href="<?= base_url('dashboard/export_pdf') ?>">Export ke PDF</a>
</body>

</html>