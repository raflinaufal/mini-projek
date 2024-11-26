<!DOCTYPE html>
<html>

<head>
	<title>Data Penjualan</title>
</head>

<body>
	<h1>Data Penjualan</h1>
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
</body>

</html>