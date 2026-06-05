<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> | WMS Agrologistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<?php if( !isset($_SESSION['id_user']) ) : ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= BASEURL; ?>">🌱 WMS Agrologistik Nusantara</a>
        </div>
    </nav>
    <div class="container">

<?php elseif( $_SESSION['role'] == 'pemasok' ) : ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-truncate" style="max-width: 75%;" href="<?= BASEURL; ?>/home">🌱 Portal Mitra Agrologistik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($data['judul'] == 'Dashboard') ? 'active fw-bold' : ''; ?>" href="<?= BASEURL; ?>/home">Beranda</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-danger btn-sm mt-1" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">

<?php else : ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm sticky-top">
        <div class="container-fluid">
            <button class="navbar-toggler d-md-none me-2 border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" aria-controls="sidebarMobile">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand fw-bold text-truncate" style="max-width: 50%;" href="<?= BASEURL; ?>/home">🌱 WMS Internal</a>
            
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-block">Halo, <?= $_SESSION['nama_lengkap']; ?>!</span>
                <a class="btn btn-danger btn-sm fw-bold" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Logout</span></a>
            </div>
        </div>
    </nav>

    <?php 
    // =========================================================================
    // TRIK PHP: Menyimpan struktur menu ke dalam variabel ($menu_sidebar)
    // agar tidak perlu menulis kode (copy-paste) dua kali untuk Desktop & Mobile
    // =========================================================================
    ob_start(); 
    ?>
    <ul class="nav flex-column gap-2 p-2 w-100">
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Dashboard') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/home">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <?php if($_SESSION['role'] == 'admin_gudang') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Inbound') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/admin/inbound">
                <i class="bi bi-box-seam me-2"></i> Manajemen Inbound
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Antrean Putaway' || $data['judul'] == 'Alokasi Rak & Cetak Batch' || $data['judul'] == 'Cetak Barcode SKU') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/admin/putaway">
                <i class="bi bi-layers me-2"></i> Antrean Putaway
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'qc') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Quality Control') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/qc">
                <i class="bi bi-clipboard-check me-2"></i> Quality Control
            </a>
        </li>
        <?php endif; ?>
        
        <?php if($_SESSION['role'] == 'admin_penjualan') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Sales Order' || $data['judul'] == 'Buat Pesanan Baru') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/penjualan">
                <i class="bi bi-cart-check me-2"></i> Sales Order
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'kru_lapangan' || $_SESSION['role'] == 'manajer') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Stok & Rak') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/stok">
                <i class="bi bi-boxes me-2"></i> Stok & Rak
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['role'], ['admin_penjualan', 'kru_lapangan', 'admin_gudang'])) : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Outbound') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/outbound">
                <i class="bi bi-truck me-2"></i> Outbound
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'manajer') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Laporan') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/laporan">
                <i class="bi bi-graph-up-arrow me-2"></i> Laporan (Waste)
            </a>
        </li>
        <?php endif; ?>
    </ul>
    <?php $menu_sidebar = ob_get_clean(); // Selesai merekam menu ?>


    <div class="container-fluid">
        <div class="row">
            
            <nav class="col-md-3 col-lg-2 d-none d-md-block bg-white sidebar shadow-sm min-vh-100 p-0">
                <div class="position-sticky top-0 pt-3">
                    <?= $menu_sidebar; ?> 
                </div>
            </nav>

            <div class="offcanvas offcanvas-start d-md-none bg-white shadow-sm" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel">
                <div class="offcanvas-header border-bottom bg-light">
                    <h5 class="offcanvas-title fw-bold text-success" id="sidebarMobileLabel">🌱 Menu Navigasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0 pt-3">
                    <?= $menu_sidebar; ?> 
                </div>
            </div>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4 pb-5">
<?php endif; ?>