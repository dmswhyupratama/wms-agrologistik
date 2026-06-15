<div class="row mb-4">
    <div class="col-12">
        <?php Flasher::flash(); ?>
        
        <h2 class="fw-bold mb-1">Selamat Datang, <span class="text-green"><?= $_SESSION['nama_lengkap']; ?></span>! 👋</h2>
        <p class="text-muted mt-2">Akses Sistem: <span class="badge badge-soft badge-soft-success px-3 py-2"><?= strtoupper(str_replace('_', ' ', $_SESSION['role'])); ?></span></p>
        <hr class="my-4">
    </div>
</div>

<?php if( $_SESSION['role'] == 'pemasok' ) : ?>
    <div class="row mb-4">
        <div class="col-md-7 mb-3">
            <div class="card card-green h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-center position-relative z-1">
                    <h4 class="card-title fw-bold text-white"><i class="bi bi-box-seam me-2 opacity-75"></i>Kirim Komoditas?</h4>
                    <p class="card-text mt-2 mb-4" style="color: rgba(255,255,255,.7);">Daftarkan jadwal dan rincian muatan Anda agar tim gudang dapat menyiapkan area penerimaan sebelum armada tiba.</p>
                    <div>
                        <a href="<?= BASEURL; ?>/asn/tambah" class="btn btn-white-pill px-4 py-2"><i class="bi bi-plus-circle-fill me-1 text-green"></i> Ajukan Jadwal ASN</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="card card-clean h-100">
                <div class="card-body p-4">
                    <h6 class="text-green-dark fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;"><i class="bi bi-clock-history me-2"></i>Status Jadwal Terakhir</h6>
                    
                    <?php if(empty($data['asn'])) : ?>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted d-block fs-1 opacity-25 mb-2"></i>
                            <p class="text-muted mb-0">Belum ada pengajuan.</p>
                        </div>
                    <?php else : ?>
                        <h3 class="fw-bold text-dark mt-3 mb-1"><?= date('d M Y', strtotime($data['asn'][0]['waktu_rencana_tiba'])); ?></h3>
                        <p class="text-muted mb-3" style="font-size: 0.9rem;">
                            <?= $data['asn'][0]['daftar_komoditas']; ?> 
                            <span class="badge badge-soft badge-soft-info ms-1"><?= $data['asn'][0]['jumlah_jenis']; ?> Jenis</span>
                        </p>
                        <?php 
                            $status_terakhir = $data['asn'][0]['status_jadwal'];
                            if($status_terakhir == 'menunggu') {
                                echo '<span class="badge badge-soft badge-soft-warning fs-6"><i class="bi bi-hourglass-split me-1"></i> Menunggu Validasi</span>';
                            } elseif($status_terakhir == 'disetujui') {
                                echo '<span class="badge badge-soft badge-soft-primary fs-6"><i class="bi bi-truck me-1"></i> Disetujui</span>';
                            } elseif($status_terakhir == 'menunggu_qc') {
                                echo '<span class="badge badge-soft badge-soft-info fs-6"><i class="bi bi-search me-1"></i> Inspeksi QC</span>';
                            } elseif(in_array($status_terakhir, ['siap_putaway', 'in_storage', 'selesai'])) {
                                echo '<span class="badge badge-soft badge-soft-success fs-6"><i class="bi bi-check-circle me-1"></i> Diterima (Lolos QC)</span>';
                            } else {
                                echo '<span class="badge badge-soft badge-soft-danger fs-6"><i class="bi bi-x-circle me-1"></i> Ditolak / Retur</span>';
                            }
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 pb-5">
        <div class="col-12">
            <h4 class="fw-bold mb-3"><i class="bi bi-table me-2 opacity-50"></i>Riwayat Pengajuan Anda</h4>
            <div class="card card-clean">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-clean mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Waktu Rencana Tiba</th>
                                    <th>Detail Komoditas</th>
                                    <th>Total Berat</th>
                                    <th>Status</th>
                                    <th>Instruksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( empty($data['asn']) ) : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat pengajuan jadwal.</td>
                                </tr>
                                <?php else : ?>
                                    <?php $i = 1; foreach( $data['asn'] as $asn ) : ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary"><?= $i++; ?></td>
                                        <td><?= date('d M Y - H:i', strtotime($asn['waktu_rencana_tiba'])); ?> WIB</td>
                                        
                                        <td class="fw-medium text-dark">
                                            <?= $asn['daftar_komoditas']; ?>
                                            <?php if($asn['jumlah_jenis'] > 1): ?>
                                                <span class="badge badge-soft badge-soft-secondary ms-1"><?= $asn['jumlah_jenis']; ?> Item</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td><strong class="text-green"><?= number_format($asn['total_berat'], 2, ',', '.'); ?> Kg</strong></td>
                                        
                                        <td>
                                            <?php 
                                                if($asn['status_jadwal'] == 'menunggu') {
                                                    echo '<span class="badge badge-soft badge-soft-warning"><i class="bi bi-hourglass-split me-1"></i> Menunggu</span>';
                                                    $instruksi = "Tunggu konfirmasi admin";
                                                } elseif($asn['status_jadwal'] == 'disetujui') {
                                                    echo '<span class="badge badge-soft badge-soft-primary"><i class="bi bi-truck me-1"></i> Disetujui</span>';
                                                    $instruksi = "<span class='fw-bold text-green-dark'>Kirim armada ke gudang</span>";
                                                } elseif($asn['status_jadwal'] == 'menunggu_qc') {
                                                    echo '<span class="badge badge-soft badge-soft-info"><i class="bi bi-search me-1"></i> Inspeksi QC</span>';
                                                    $instruksi = "Tunggu hasil QC";
                                                } elseif(in_array($asn['status_jadwal'], ['siap_putaway', 'in_storage', 'selesai'])) {
                                                    echo '<span class="badge badge-soft badge-soft-success"><i class="bi bi-check-circle me-1"></i> Diterima</span>';
                                                    $instruksi = "<span class='fw-bold text-green'>Barang masuk gudang</span>";
                                                } else {
                                                    echo '<span class="badge badge-soft badge-soft-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>';
                                                    $instruksi = "<span class='text-danger'>Ajukan jadwal ulang</span>";
                                                }
                                            ?>
                                        </td>
                                        <td><?= $instruksi; ?></td>
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

<?php else : ?>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card card-clean">
                <div class="card-body py-4 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold mb-1 text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Truk Menunggu Inbound</h6>
                        <h2 class="fw-bold text-dark mb-0">0 <span class="fs-6 fw-normal text-muted">Antrean</span></h2>
                    </div>
                    <div class="stat-icon stat-icon-green">
                        <i class="bi bi-truck"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-clean">
                <div class="card-body py-4 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold mb-1 text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Menunggu QC Inspeksi</h6>
                        <h2 class="fw-bold text-dark mb-0">0 <span class="fs-6 fw-normal text-muted">Komoditas</span></h2>
                    </div>
                    <div class="stat-icon stat-icon-amber">
                        <i class="bi bi-search"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-clean">
                <div class="card-body py-4 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold mb-1 text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pesanan (Picking List)</h6>
                        <h2 class="fw-bold text-dark mb-0">0 <span class="fs-6 fw-normal text-muted">Dokumen</span></h2>
                    </div>
                    <div class="stat-icon stat-icon-blue">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3 mb-5 pb-5">
        <div class="col-12">
            <div class="alert alert-green-light d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                <div>Silakan navigasikan kursor Anda ke <strong>Sidebar Kiri</strong> untuk memulai operasional teknis gudang hari ini.</div>
            </div>
        </div>
    </div>
<?php endif; ?>