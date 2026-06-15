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

<div class="container-fluid mt-4 mb-5 px-lg-4">
    
    <!-- HEADER & AKSI CEPAT -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">Overview</h2>
                <span class="badge bg-green-light text-green-dark border px-2 py-1 fs-7 rounded-pill fw-medium">Admin Gudang</span>
            </div>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Selamat datang kembali, <strong class="text-dark"><?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?></strong>. Pantau aktivitas gudang hari ini.</p>
        </div>
        
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="<?= BASEURL; ?>/admin/inbound" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium hover-elevate text-secondary shadow-sm">
                <i class="bi bi-box-arrow-in-down me-1"></i> Inbound
            </a>
            <a href="<?= BASEURL; ?>/admin/putaway" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium hover-elevate text-secondary shadow-sm">
                <i class="bi bi-layers me-1"></i> Putaway
            </a>
            <a href="<?= BASEURL; ?>/outbound" class="btn btn-sm btn-green rounded-pill px-3 fw-medium shadow-sm">
                <i class="bi bi-truck me-1"></i> Outbound (DO)
            </a>
        </div>
    </div>

    <!-- STATISTIK (4 KARTU) -->
    <div class="row g-4 mb-5">
        
        <!-- Inbound -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white hover-elevate">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.85rem;">Antrean Inbound</p>
                            <h2 class="fw-bold text-dark mb-0"><?= $stat['inbound']; ?></h2>
                        </div>
                        <div class="stat-icon stat-icon-green rounded-circle" style="width: 45px; height: 45px;"><i class="bi bi-box-arrow-in-down"></i></div>
                    </div>
                    <a href="<?= BASEURL; ?>/admin/inbound" class="text-decoration-none fw-semibold text-green mt-2" style="font-size: 0.85rem;">
                        Proses Kedatangan <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Putaway -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white hover-elevate">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.85rem;">Antrean Putaway</p>
                            <h2 class="fw-bold text-dark mb-0"><?= $stat['putaway']; ?></h2>
                        </div>
                        <div class="stat-icon stat-icon-amber rounded-circle" style="width: 45px; height: 45px;"><i class="bi bi-layers-fill"></i></div>
                    </div>
                    <a href="<?= BASEURL; ?>/admin/putaway" class="text-decoration-none fw-semibold text-green mt-2" style="font-size: 0.85rem;">
                        Alokasi Rak <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Ekspedisi -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white hover-elevate">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.85rem;">Antrean Ekspedisi</p>
                            <h2 class="fw-bold text-dark mb-0"><?= $stat['ekspedisi']; ?></h2>
                        </div>
                        <div class="stat-icon stat-icon-blue rounded-circle" style="width: 45px; height: 45px;"><i class="bi bi-truck"></i></div>
                    </div>
                    <a href="<?= BASEURL; ?>/outbound" class="text-decoration-none fw-semibold text-green mt-2" style="font-size: 0.85rem;">
                        Panggil Truk <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kapasitas -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white hover-elevate">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="text-muted mb-0 fw-medium" style="font-size: 0.85rem;">Kapasitas Gudang</p>
                        <span class="badge <?= $badge_class; ?> rounded-pill px-2"><?= $label_kapasitas; ?></span>
                    </div>
                    <div class="d-flex align-items-baseline mb-2">
                        <h3 class="fw-bold text-dark mb-0 me-2"><?= $persen; ?>%</h3>
                        <small class="text-muted"><?= $stat['rak_terisi']; ?> / <?= $stat['total_rak']; ?> rak</small>
                    </div>
                    <div class="progress-clean mb-2" style="height: 6px;">
                        <div class="progress-bar <?= $bar_color; ?>" role="progressbar" style="width: <?= $persen; ?>%;" aria-valuenow="<?= $persen; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted d-block text-end" style="font-size: 0.75rem;">
                        <?= number_format($stat['berat_terpakai'], 0, ',', '.'); ?> / <?= number_format($stat['kapasitas_total'], 0, ',', '.'); ?> Kg
                    </small>
                </div>
            </div>
        </div>

    </div>

    <!-- TABEL AKTIVITAS TERBARU -->
    <div class="row g-4">
        
        <!-- Inbound Terbaru -->
        <div class="col-lg-6">
            <div class="d-flex justify-content-between align-items-end mb-3 px-1">
                <h6 class="fw-bold text-dark mb-0">Inbound Terbaru</h6>
                <a href="<?= BASEURL; ?>/admin/inbound" class="text-muted text-decoration-none fw-medium hover-elevate px-2 py-1 rounded" style="font-size: 0.8rem; background: var(--gray-100);">Lihat Semua</a>
            </div>
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle mb-0" style="font-size: 0.9rem;">
                        <thead class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <th class="fw-semibold pb-3 ps-2">No. ASN</th>
                                <th class="fw-semibold pb-3">Pemasok</th>
                                <th class="fw-semibold pb-3 text-end pe-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($data['recent_inbound'])) : ?>
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted">Belum ada data inbound.</div>
                                </td>
                            </tr>
                            <?php else : ?>
                                <?php foreach(array_slice($data['recent_inbound'], 0, 5) as $asn) : ?>
                                <tr style="border-bottom: 1px solid #f9fafb;">
                                    <td class="ps-2 py-3">
                                        <div class="fw-semibold text-dark">ASN-<?= str_pad($asn['id_asn'], 3, '0', STR_PAD_LEFT); ?></div>
                                        <div class="text-muted" style="font-size: 0.8rem;"><?= date('d M Y', strtotime($asn['waktu_rencana_tiba'])); ?></div>
                                    </td>
                                    <td class="py-3">
                                        <div class="text-dark fw-medium"><?= $asn['nama_pemasok']; ?></div>
                                        <div class="text-muted" style="font-size: 0.8rem;"><?= $asn['jumlah_item']; ?> item</div>
                                    </td>
                                    <td class="text-end pe-2 py-3">
                                        <?php
                                            $s = $asn['status_jadwal'];
                                            if($s == 'menunggu') echo '<span class="badge badge-soft-warning rounded-pill px-3">Menunggu</span>';
                                            elseif($s == 'disetujui') echo '<span class="badge badge-soft-primary rounded-pill px-3">Disetujui</span>';
                                            elseif($s == 'menunggu_qc') echo '<span class="badge badge-soft-info rounded-pill px-3">QC</span>';
                                            elseif(in_array($s, ['siap_putaway','in_storage','selesai'])) echo '<span class="badge badge-soft-success rounded-pill px-3">Selesai</span>';
                                            elseif($s == 'ditolak') echo '<span class="badge badge-soft-danger rounded-pill px-3">Ditolak</span>';
                                            elseif($s == 'ada_retur') echo '<span class="badge badge-soft-danger rounded-pill px-3">Retur</span>';
                                            else echo '<span class="badge badge-soft-secondary rounded-pill px-3">'.$s.'</span>';
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Outbound Terbaru -->
        <div class="col-lg-6">
            <div class="d-flex justify-content-between align-items-end mb-3 px-1">
                <h6 class="fw-bold text-dark mb-0">Outbound Terbaru</h6>
                <a href="<?= BASEURL; ?>/outbound" class="text-muted text-decoration-none fw-medium hover-elevate px-2 py-1 rounded" style="font-size: 0.8rem; background: var(--gray-100);">Lihat Semua</a>
            </div>
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle mb-0" style="font-size: 0.9rem;">
                        <thead class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <th class="fw-semibold pb-3 ps-2">No. SO</th>
                                <th class="fw-semibold pb-3">Klien</th>
                                <th class="fw-semibold pb-3 text-end pe-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($data['recent_outbound'])) : ?>
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted">Belum ada sales order.</div>
                                </td>
                            </tr>
                            <?php else : ?>
                                <?php foreach(array_slice($data['recent_outbound'], 0, 5) as $so) : ?>
                                <tr style="border-bottom: 1px solid #f9fafb;">
                                    <td class="ps-2 py-3">
                                        <div class="fw-semibold text-dark">SO-<?= str_pad($so['id_so'], 3, '0', STR_PAD_LEFT); ?></div>
                                        <div class="text-muted" style="font-size: 0.8rem;"><?= date('d M Y', strtotime($so['created_at'])); ?></div>
                                    </td>
                                    <td class="py-3">
                                        <div class="text-dark fw-medium"><?= $so['nama_klien']; ?></div>
                                        <div class="fw-medium text-green" style="font-size: 0.8rem;"><?= number_format($so['total_diminta_kg'], 0, ',', '.'); ?> Kg</div>
                                    </td>
                                    <td class="text-end pe-2 py-3">
                                        <?php
                                            $st = $so['status_pesanan'];
                                            if($st == 'pending') echo '<span class="badge badge-soft-warning rounded-pill px-3">Pending</span>';
                                            elseif($st == 'proses_picking') echo '<span class="badge badge-soft-info rounded-pill px-3">Picking</span>';
                                            elseif($st == 'siap_kirim') echo '<span class="badge badge-soft-primary rounded-pill px-3">Siap Kirim</span>';
                                            elseif($st == 'selesai') echo '<span class="badge badge-soft-success rounded-pill px-3">Selesai</span>';
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>