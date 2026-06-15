<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> | WMS Agrologistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css">
</head>
<body>

<?php if( !isset($_SESSION['id_user']) ) : ?>
    <nav class="navbar navbar-expand-lg navbar-green">
        <div class="container">
            <a class="navbar-brand" href="<?= BASEURL; ?>"><i class="bi bi-box-seam me-2"></i>WMS Agrologistik</a>
        </div>
    </nav>
    <div class="container mt-4">

<?php elseif( $_SESSION['role'] == 'pemasok' ) : ?>
    <nav class="navbar navbar-expand-lg navbar-green">
        <div class="container">
            <a class="navbar-brand text-truncate" style="max-width: 75%;" href="<?= BASEURL; ?>/home"><i class="bi bi-box-seam me-2"></i>Portal Mitra Agrologistik</a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white <?= ($data['judul'] == 'Dashboard') ? 'active fw-bold' : 'opacity-75'; ?>" href="<?= BASEURL; ?>/home">Beranda</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-white-pill btn-sm px-3" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">

<?php else : ?>
    <nav class="navbar navbar-expand-lg navbar-green sticky-top">
        <div class="container-fluid px-3">
            <button class="navbar-toggler d-md-none me-2 border-0 shadow-none text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" aria-controls="sidebarMobile">
                <i class="bi bi-list fs-2"></i>
            </button>

            <a class="navbar-brand text-truncate" style="max-width: 50%;" href="<?= BASEURL; ?>/home"><i class="bi bi-box-seam me-2"></i>WMS Internal</a>
            
            <div class="d-flex align-items-center">
                <span class="nav-text-light me-3 d-none d-md-block">Halo, <strong><?= $_SESSION['nama_lengkap']; ?></strong>!</span>
                <a class="btn btn-white-pill btn-sm px-3" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-power"></i> <span class="d-none d-sm-inline ms-1">Keluar</span></a>
            </div>
        </div>
    </nav>

    <?php 
    ob_start(); 
    ?>
    <ul class="nav flex-column gap-1 p-2 w-100">
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Dashboard') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/home">
                <i class="bi bi-grid-1x2 me-2"></i> Dashboard
            </a>
        </li>

        <?php if(in_array($_SESSION['role'], ['admin_gudang', 'kru_lapangan', 'manajer'])) : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Operasional</small>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'admin_gudang') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Inbound') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/admin/inbound">
                <i class="bi bi-box-arrow-in-right me-2"></i> Inbound
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['role'], ['admin_gudang', 'kru_lapangan', 'manajer'])) : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Outbound') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/outbound">
                <i class="bi bi-truck-front me-2"></i> Outbound
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'qc') : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Inspeksi</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Quality Control') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/qc">
                <i class="bi bi-patch-check me-2"></i> Quality Control
            </a>
        </li>
        <?php endif; ?>
        
        <?php if($_SESSION['role'] == 'admin_penjualan') : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Penjualan</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Sales Order' || $data['judul'] == 'Buat Pesanan Baru') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/penjualan">
                <i class="bi bi-cart me-2"></i> Sales Order
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['role'], ['admin_gudang', 'kru_lapangan', 'manajer'])) : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Penyimpanan</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Stok & Rak') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/stok">
                <i class="bi bi-layers me-2"></i> Stok & Rak
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'admin_gudang') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Antrean Putaway' || $data['judul'] == 'Alokasi Rak & Cetak Batch' || $data['judul'] == 'Cetak Barcode SKU') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/admin/putaway">
                <i class="bi bi-arrow-down-square me-2"></i> Putaway
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['role'], ['kru_lapangan', 'qc', 'manajer'])) : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Waste') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/waste">
                <i class="bi bi-trash3 me-2"></i> Data Waste
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'manajer') : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Manajemen</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Pegawai') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/pegawai">
                <i class="bi bi-people me-2"></i> Data Pegawai
            </a>
        </li>
        <?php endif; ?>

    </ul>
    <?php $menu_sidebar = ob_get_clean(); ?>


    <div class="container-fluid">
        <div class="row">
            
            <nav class="col-md-3 col-lg-2 d-none d-md-block sidebar-green min-vh-100 p-0">
                <div class="position-sticky top-0 pt-3">
                    <?= $menu_sidebar; ?> 
                </div>
            </nav>

            <div class="offcanvas offcanvas-start d-md-none sidebar-green" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title fw-bold text-green-dark" id="sidebarMobileLabel"><i class="bi bi-box-seam me-2 text-green"></i>Menu Navigasi</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0 pt-3">
                    <?= $menu_sidebar; ?> 
                </div>
            </div>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4 pb-5">
<?php endif; ?>