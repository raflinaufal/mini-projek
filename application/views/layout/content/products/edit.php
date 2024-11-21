<h1>Edit Produk</h1>
<form method="post" enctype="multipart/form-data">
    <label for="name">Nama Produk:</label>
    <input type="text" name="name" value="<?= $product->name; ?>" required><br>

    <label for="price">Harga Produk:</label>
    <input type="text" name="price" value="<?= $product->price; ?>" required><br>

    <label for="description">Deskripsi Produk:</label>
    <textarea name="description"><?= $product->description; ?></textarea><br>

    <label for="image">Gambar Produk Baru:</label>
    <input type="file" name="image"><br>

    <button type="submit">Update Produk</button>
</form>
