<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Produk Baru</h1>
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
    <form method="post" enctype="multipart/form-data" action="<?= base_url('products/add'); ?>">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Produk</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Masukkan nama produk">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="number" class="form-control" id="price" name="price" required placeholder="Masukkan harga produk">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Masukkan deskripsi produk"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Gambar Produk</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Produk</button>
                    <a href="<?= site_url('products') ?>" class="btn btn-secondary btn-block">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>
