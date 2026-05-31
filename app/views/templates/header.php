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
            <a class="navbar-brand fw-bold" href="<?= BASEURL; ?>/home">🌱 Portal Mitra Agrologistik</a>
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
            <a class="navbar-brand fw-bold" href="<?= BASEURL; ?>/home">🌱 WMS Internal</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-block">Halo, <?= $_SESSION['nama_lengkap']; ?>!</span>
                <a class="btn btn-danger btn-sm fw-bold" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar shadow-sm min-vh-100">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column gap-2 p-2">
                        
                        <li class="nav-item">
                            <a class="nav-link <?= ($data['judul'] == 'Dashboard') ? 'bg-success text-white rounded shadow-sm' : 'text-dark fw-medium'; ?>" href="<?= BASEURL; ?>/home">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>

                        <?php if($_SESSION['role'] == 'admin_gudang') : ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="<?= BASEURL; ?>/asn">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Inbound (ASN)
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if($_SESSION['role'] == 'qc') : ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="<?= BASEURL; ?>/qc">
                                <i class="bi bi-clipboard-check me-2"></i> Quality Control
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if($_SESSION['role'] == 'kru_lapangan' || $_SESSION['role'] == 'manajer') : ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="<?= BASEURL; ?>/stok">
                                <i class="bi bi-boxes me-2"></i> Stok & Rak
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if(in_array($_SESSION['role'], ['admin_penjualan', 'kru_lapangan', 'admin_gudang'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="<?= BASEURL; ?>/outbound">
                                <i class="bi bi-truck me-2"></i> Outbound
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if($_SESSION['role'] == 'manajer') : ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="<?= BASEURL; ?>/laporan">
                                <i class="bi bi-graph-up-arrow me-2"></i> Laporan (Waste)
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </nav>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4 pb-5">
<?php endif; ?>