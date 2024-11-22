<div class="">
    <h1 class="h3 mb-4 text-gray-800">Daftar Produk</h1>

    <!-- Tombol Create Produk -->
    <a href="<?= site_url('products/add') ?>" class="btn btn-primary mb-3">Tambah Produk</a>

    <div class="mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="productTable" class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination (optional) -->
    <div class="pagination">
        <?= $pagination ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#productTable').DataTable({
            "paging": true,  // Aktifkan pagination
            "searching": true,  // Aktifkan pencarian
            "ordering": true,  // Aktifkan pengurutan
            "info": true,  // Tampilkan informasi jumlah data
            "lengthMenu": [5, 10, 25, 50] // Pilihan jumlah per halaman
        });
    });
</script>
