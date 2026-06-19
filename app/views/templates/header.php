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
<body class="bg-light">

<?php if( !isset($_SESSION['id_user']) ) : ?>
    <nav class="navbar navbar-expand-lg navbar-green shadow-sm py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="<?= BASEURL; ?>">
                <div class="bg-white text-green rounded-2 p-1 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="bi bi-box-seam fs-5"></i>
                </div>
                <span style="letter-spacing: -0.5px;">WMS Agrologistik</span>
            </a>
        </div>
    </nav>
    <div class="container mt-4">

<?php elseif( $_SESSION['role'] == 'pemasok' ) : ?>
    <nav class="navbar navbar-expand-lg navbar-green shadow-sm py-2 sticky-top" style="z-index: 1050;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="<?= BASEURL; ?>/home">
                <div class="bg-white text-green rounded-2 p-1 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="bi bi-box-seam fs-5"></i>
                </div>
                <span class="d-none d-sm-inline" style="letter-spacing: -0.5px;">Portal Mitra Agrologistik</span>
                <span class="d-inline d-sm-none" style="letter-spacing: -0.5px;">Portal Mitra</span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="btn btn-white-pill rounded-pill btn-sm px-3 fw-bold d-inline-flex align-items-center" href="<?= BASEURL; ?>/home">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-white-pill rounded-pill btn-sm px-3 fw-bold d-inline-flex align-items-center" href="<?= BASEURL; ?>/auth/logout">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">

<?php else : ?>
    <nav class="navbar navbar-expand-lg navbar-green shadow-sm sticky-top py-2" style="z-index: 1050;">
        <div class="container-fluid px-3">
            <button class="navbar-toggler d-md-none me-2 border-0 shadow-none text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" aria-controls="sidebarMobile">
                <i class="bi bi-list fs-2"></i>
            </button>
            
            <button class="btn btn-link text-white d-none d-md-inline-block p-0 me-3 shadow-none border-0" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="bi bi-list fs-3"></i>
            </button>

            <a class="navbar-brand fw-bold text-white fs-4" href="<?= BASEURL; ?>/home" style="letter-spacing: -0.5px;">
                <span class="d-none d-sm-inline">WMS Internal</span>
                <span class="d-inline d-sm-none">WMS</span>
            </a>
            
            <div class="d-flex align-items-center ms-auto">
                <div class="d-none d-md-flex align-items-center me-3 border border-white border-opacity-25 rounded-pill pe-3 ps-2 py-1" style="background: rgba(255,255,255,0.1);">
                    <i class="bi bi-person-circle fs-5 text-white opacity-75 me-2"></i>
                    <span class="nav-text-light fw-medium" style="font-size: 0.85rem;">Halo, <strong class="text-white"><?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?></strong></span>
                </div>
                
                <a class="btn btn-sm btn-white-pill rounded-pill px-3 fw-bold d-flex align-items-center" href="<?= BASEURL; ?>/auth/logout">
                    <i class="bi bi-box-arrow-right me-1"></i> <span class="d-none d-sm-inline">Keluar</span>
                </a>
            </div>
        </div>
    </nav>

    <?php 
    ob_start(); 
    ?>
    <ul class="nav flex-column gap-1 p-2 w-100">
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Dashboard') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/home">
                <i class="bi bi-grid-1x2 me-2"></i> <span>Dashboard</span>
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
                <i class="bi bi-box-arrow-in-right me-2"></i> <span>Inbound</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['role'], ['admin_gudang', 'kru_lapangan', 'manajer'])) : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Outbound') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/outbound">
                <i class="bi bi-truck-front me-2"></i> <span>Outbound</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'qc') : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Inspeksi</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Quality Control') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/qc">
                <i class="bi bi-patch-check me-2"></i> <span>Quality Control</span>
            </a>
        </li>
        <?php endif; ?>
        
        <?php if($_SESSION['role'] == 'admin_penjualan') : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Penjualan</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Sales Order' || $data['judul'] == 'Buat Pesanan Baru') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/penjualan">
                <i class="bi bi-cart me-2"></i> <span>Sales Order</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['role'], ['admin_gudang', 'kru_lapangan', 'manajer'])) : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Penyimpanan</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Stok & Rak') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/stok">
                <i class="bi bi-layers me-2"></i> <span>Stok & Rak</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'admin_gudang') : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Antrean Putaway' || $data['judul'] == 'Alokasi Rak & Cetak Batch' || $data['judul'] == 'Cetak Barcode SKU') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/admin/putaway">
                <i class="bi bi-arrow-down-square me-2"></i> <span>Putaway</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['role'], ['kru_lapangan', 'qc', 'manajer'])) : ?>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Waste') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/waste">
                <i class="bi bi-trash3 me-2"></i> <span>Data Waste</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'manajer') : ?>
        <li class="nav-item mt-3">
            <small class="sidebar-label">Manajemen</small>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['judul'] == 'Manajemen Pegawai') ? 'active-menu' : ''; ?>" href="<?= BASEURL; ?>/pegawai">
                <i class="bi bi-people me-2"></i> <span>Data Pegawai</span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
    <?php $menu_sidebar = ob_get_clean(); ?>


    <div class="container-fluid p-0">
        <div class="d-flex flex-nowrap">
            
            <nav id="sidebarDesktop" class="sidebar-green d-none d-md-block p-0 flex-shrink-0" style="width: 250px; height: calc(100vh - 65px); position: sticky; top: 65px; overflow-y: auto; z-index: 1040;">
                <div class="pt-3">
                    <?= $menu_sidebar; ?> 
                </div>
            </nav>

            <div class="offcanvas offcanvas-start d-md-none sidebar-green" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel" style="width: 280px;">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title fw-bold text-green-dark" id="sidebarMobileLabel"><i class="bi bi-box-seam me-2 text-green"></i>Menu Navigasi</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0 pt-3">
                    <?= $menu_sidebar; ?> 
                </div>
            </div>
            
            <main class="flex-grow-1 px-md-4 pt-4 pb-5 fade-in-up" style="min-width: 0;">
<?php endif; ?>