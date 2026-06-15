<?php
    // Variabel kapasitas dari backend
    $stat = $data['statistik'];
    $persen = $stat['persen_kapasitas'];
    
    // Tentukan warna progress bar berdasarkan persentase
    if($persen >= 85) {
        $bar_color = 'bg-danger';
        $label_kapasitas = 'Hampir Penuh';
        $badge_class = 'badge-soft-danger';
    } elseif($persen >= 60) {
        $bar_color = 'bg-warning';
        $label_kapasitas = 'Sedang';
        $badge_class = 'badge-soft-warning';
    } else {
        $bar_color = 'bg-success';
        $label_kapasitas = 'Aman';
        $badge_class = 'badge-soft-success';
    }
?>

<div class="container-fluid mt-3 mb-5">
    
    <!-- HEADER -->
    <div class="row mb-4">
        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="fw-bold mb-1">Selamat Datang, <span class="text-green"><?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?></span>! 🚦</h2>
                <p class="text-muted mb-0">Pantau arus lalu lintas bongkar muat dan alokasi rak gudang hari ini.</p>
            </div>
            <span class="badge bg-dark px-3 py-2 fs-6"><i class="bi bi-person-badge me-2"></i>ADMIN GUDANG</span>
        </div>
    </div>

    <hr class="mb-4 opacity-25">

    <!-- BARIS 1: 4 KARTU STATISTIK -->
    <div class="row g-3 mb-4">
        
        <!-- Kartu Inbound -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-clean h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted fw-bold mb-0" style="font-size: 0.8rem;">Antrean Inbound</h6>
                        <div class="stat-icon stat-icon-green"><i class="bi bi-box-arrow-in-down"></i></div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $stat['inbound']; ?></h2>
                    <small class="text-muted">Truk / ASN menunggu</small>
                    <div class="mt-3">
                        <a href="<?= BASEURL; ?>/admin/inbound" class="small text-decoration-none fw-bold text-green">
                            Proses Kedatangan <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Putaway -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-clean h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted fw-bold mb-0" style="font-size: 0.8rem;">Antrean Putaway</h6>
                        <div class="stat-icon stat-icon-amber"><i class="bi bi-layers-fill"></i></div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $stat['putaway']; ?></h2>
                    <small class="text-muted">Batch perlu alokasi rak</small>
                    <div class="mt-3">
                        <a href="<?= BASEURL; ?>/admin/putaway" class="small text-decoration-none fw-bold text-green">
                            Cetak Barcode & Alokasi <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Ekspedisi -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-clean h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted fw-bold mb-0" style="font-size: 0.8rem;">Antrean Ekspedisi</h6>
                        <div class="stat-icon stat-icon-blue"><i class="bi bi-truck"></i></div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $stat['ekspedisi']; ?></h2>
                    <small class="text-muted">Surat Jalan siap kirim</small>
                    <div class="mt-3">
                        <a href="<?= BASEURL; ?>/outbound" class="small text-decoration-none fw-bold text-green">
                            Panggil Truk Keluar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Kapasitas Gudang (REAL DATA) -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-clean h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted fw-bold mb-0" style="font-size: 0.8rem;">Kapasitas Gudang</h6>
                        <span class="badge <?= $badge_class; ?>"><?= $label_kapasitas; ?></span>
                    </div>
                    <h2 class="fw-bold text-dark mb-0"><?= $persen; ?>%</h2>
                    <small class="text-muted"><?= $stat['rak_terisi']; ?> / <?= $stat['total_rak']; ?> rak terisi</small>
                    <div class="progress-clean mt-3">
                        <div class="progress-bar <?= $bar_color; ?>" role="progressbar" style="width: <?= $persen; ?>%;" aria-valuenow="<?= $persen; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted d-block mt-2"><?= number_format($stat['berat_terpakai'], 0, ',', '.'); ?> / <?= number_format($stat['kapasitas_total'], 0, ',', '.'); ?> Kg</small>
                </div>
            </div>
        </div>

    </div>

    <!-- BARIS 2: AKSI CEPAT (HORIZONTAL) -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card card-clean">
                <div class="card-body py-3 px-4">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span class="fw-bold text-muted me-2"><i class="bi bi-lightning-charge-fill me-1"></i> Aksi Cepat:</span>
                        <a href="<?= BASEURL; ?>/admin/inbound" class="btn btn-sm btn-outline-success rounded-pill px-3 quick-action-btn">
                            <i class="bi bi-upc-scan me-1"></i> Scan Kedatangan
                        </a>
                        <a href="<?= BASEURL; ?>/admin/putaway" class="btn btn-sm btn-outline-warning rounded-pill px-3 quick-action-btn">
                            <i class="bi bi-printer me-1"></i> Cetak Barcode
                        </a>
                        <a href="<?= BASEURL; ?>/outbound" class="btn btn-sm btn-green rounded-pill px-3">
                            <i class="bi bi-file-earmark-text me-1"></i> Buat Surat Jalan (DO)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 3: 2 TABEL DATA REAL (50:50) -->
    <div class="row g-4 mb-5 pb-4">
        
        <!-- TABEL INBOUND TERBARU -->
        <div class="col-lg-6">
            <h5 class="fw-bold mb-3"><i class="bi bi-box-arrow-in-down me-2 text-green"></i>Inbound Terbaru</h5>
            <div class="card card-clean">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-clean mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Pemasok</th>
                                    <th>Komoditas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($data['recent_inbound'])) : ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-inbox d-block fs-1 text-muted opacity-25 mb-2"></i>
                                        <span class="text-muted">Belum ada data inbound.</span>
                                    </td>
                                </tr>
                                <?php else : ?>
                                    <?php foreach($data['recent_inbound'] as $asn) : ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold text-dark">ASN-<?= str_pad($asn['id_asn'], 3, '0', STR_PAD_LEFT); ?></span><br>
                                            <small class="text-muted"><?= date('d M Y', strtotime($asn['waktu_rencana_tiba'])); ?></small>
                                        </td>
                                        <td>
                                            <span class="fw-medium text-dark"><?= $asn['nama_pemasok']; ?></span><br>
                                            <small class="text-muted"><?= $asn['jumlah_item']; ?> item</small>
                                        </td>
                                        <td><span class="text-muted" style="font-size: 0.85rem;"><?= $asn['daftar_komoditas'] ?: '-'; ?></span></td>
                                        <td>
                                            <?php
                                                $s = $asn['status_jadwal'];
                                                if($s == 'menunggu') echo '<span class="badge badge-soft badge-soft-warning"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>';
                                                elseif($s == 'disetujui') echo '<span class="badge badge-soft badge-soft-primary"><i class="bi bi-check-lg me-1"></i>Disetujui</span>';
                                                elseif($s == 'menunggu_qc') echo '<span class="badge badge-soft badge-soft-info"><i class="bi bi-search me-1"></i>QC</span>';
                                                elseif(in_array($s, ['siap_putaway','in_storage','selesai'])) echo '<span class="badge badge-soft badge-soft-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>';
                                                elseif($s == 'ditolak') echo '<span class="badge badge-soft badge-soft-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>';
                                                elseif($s == 'ada_retur') echo '<span class="badge badge-soft badge-soft-danger"><i class="bi bi-arrow-return-left me-1"></i>Retur</span>';
                                                else echo '<span class="badge badge-soft badge-soft-secondary">'.$s.'</span>';
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(!empty($data['recent_inbound'])) : ?>
                <div class="card-footer bg-transparent text-center border-top py-2">
                    <a href="<?= BASEURL; ?>/admin/inbound" class="small text-decoration-none fw-bold text-green">Lihat semua inbound <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- TABEL OUTBOUND TERBARU -->
        <div class="col-lg-6">
            <h5 class="fw-bold mb-3"><i class="bi bi-truck me-2 text-green"></i>Outbound Terbaru</h5>
            <div class="card card-clean">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-clean mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Klien</th>
                                    <th>Berat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($data['recent_outbound'])) : ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-inbox d-block fs-1 text-muted opacity-25 mb-2"></i>
                                        <span class="text-muted">Belum ada sales order.</span>
                                    </td>
                                </tr>
                                <?php else : ?>
                                    <?php foreach($data['recent_outbound'] as $so) : ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold text-dark">SO-<?= str_pad($so['id_so'], 3, '0', STR_PAD_LEFT); ?></span><br>
                                            <small class="text-muted"><?= date('d M Y', strtotime($so['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <span class="fw-medium text-dark"><?= $so['nama_klien']; ?></span><br>
                                            <small class="text-muted"><?= $so['komoditas_dipesan']; ?></small>
                                        </td>
                                        <td><strong class="text-green"><?= number_format($so['total_diminta_kg'], 0, ',', '.'); ?> Kg</strong></td>
                                        <td>
                                            <?php
                                                $st = $so['status_pesanan'];
                                                if($st == 'pending') echo '<span class="badge badge-soft badge-soft-warning"><i class="bi bi-hourglass-split me-1"></i>Pending</span>';
                                                elseif($st == 'proses_picking') echo '<span class="badge badge-soft badge-soft-info"><i class="bi bi-arrows-move me-1"></i>Picking</span>';
                                                elseif($st == 'siap_kirim') echo '<span class="badge badge-soft badge-soft-primary"><i class="bi bi-truck me-1"></i>Siap Kirim</span>';
                                                elseif($st == 'selesai') echo '<span class="badge badge-soft badge-soft-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>';
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(!empty($data['recent_outbound'])) : ?>
                <div class="card-footer bg-transparent text-center border-top py-2">
                    <a href="<?= BASEURL; ?>/outbound" class="small text-decoration-none fw-bold text-green">Lihat semua outbound <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>