<div class="mt-4">
    <h1 class="h3 mb-4 text-gray-800">Daftar Produk</h1>
    <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
    <!-- Tombol Tambah Produk -->
    <a href="<?= site_url('products/add') ?>" class="btn btn-primary mb-3">Tambah Produk</a>

    <!-- Tabel Produk -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="productTable" class="table table-bordered table-striped" style="font-size: 18px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>
                                <a href="?order_by=name&sort=<?= $sort === 'asc' ? 'desc' : 'asc' ?>" class="text-decoration-none text-dark">
                                    Nama Produk
                                    <?php if ($order_by === 'name'): ?>
                                        <i class="fa <?= $sort === 'asc' ? '' : 'fa-sort-down' ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>Deskripsi</th>
                            <th>
                                <a href="?order_by=price&sort=<?= $sort === 'asc' ? 'desc' : 'asc' ?>" class="text-decoration-none text-dark">
                                    Harga
                                    <?php if ($order_by === 'price'): ?>
                                        <i class="fa <?= $sort === 'asc' ? 'fa-sort-down ' : 'fa-sort-up' ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>Gambar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $product->id ?></td>
                                    <td><?= $product->name ?></td>
                                    <td><?= $product->description ?></td>
                                    <td><?= 'Rp ' . number_format($product->price, 0, ',', '.') ?></td>
                                    <td><img src="<?= base_url('uploads/' . $product->image) ?>" alt="Product Image" width="50"></td>
                                    <td>
                                        <a href="<?= site_url('products/edit/' . $product->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= site_url('products/delete/' . $product->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada produk ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        <?= $pagination ?>
    </div>
</div>

<!-- Tambahkan Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<!-- DataTables CSS dan JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [5, 10, 25, 50],
            "language": {
                "paginate": {
                    "previous": "&laquo;",
                    "next": "&raquo;"
                },
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ produk",
                "search": "Cari Produk:"
            }
        });
    });
</script>

