<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }
        @media (max-width: 576px) {
            .form-inline input {
                width: 100%;
                margin-bottom: 10px;
            }
            .form-inline button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php $this->load->view('layout/home/navbar'); ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Daftar Produk</h1>
    
    <!-- Form Pencarian -->
<form class="mb-4" method="get" action="">
    <div class="row">
        <div class="col-12 col-md-10 mb-2 mb-md-0">
            <input type="text" class="form-control" name="search" placeholder="Cari produk..." 
                   value="<?php echo $this->input->get('search'); ?>">
        </div>
        <div class="col-12 col-md-2">
            <button type="submit" class="btn btn-primary btn-block">Cari</button>
        </div>
    </div>
</form>


    <!-- Daftar Produk -->
    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 col-sm-6 col-12 mb-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('uploads/' . $product->image); ?>" 
                             class="card-img-top" 
                             alt="<?php echo $product->name; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product->name; ?></h5>
                            <p class="card-text">Harga: <?php echo number_format($product->price, 2); ?></p>
                            <p class="card-text"><?php echo $product->description; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Produk tidak ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        <?php echo $pagination; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
