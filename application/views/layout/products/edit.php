<div class="container-fluid mt-4">
    <div class="card">
      <h1 class="h3 mb-4 text-gray-800">Edit Produk</h1>
        <div class="card-body">
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
            <form method="post" enctype="multipart/form-data">
                <!-- Nama Produk -->
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nama Produk:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $product->name; ?>" required>
                </div>

                <!-- Harga Produk -->
                <div class="form-group mb-3">
                    <label for="price" class="form-label">Harga Produk:</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?= $product->price; ?>" required>
                </div>

                <!-- Deskripsi Produk -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Deskripsi Produk:</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= $product->description; ?></textarea>
                </div>

                <!-- Gambar Produk -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Gambar Produk Baru:</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                </div>

                <!-- Tombol Submit -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Produk</button>
                    <a href="<?= base_url('products'); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
