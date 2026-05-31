<div class="row mb-4">
    <div class="col-12">
        <!-- Pindahkan Flasher ke sini agar pesan sukses muncul di Beranda -->
        <?php Flasher::flash(); ?>
        
        <h2 class="fw-bold text-success">Selamat Datang, <?= $_SESSION['nama_lengkap']; ?>! 👋</h2>
        <p class="text-muted">Akses Login: <span class="badge bg-secondary"><?= strtoupper(str_replace('_', ' ', $_SESSION['role'])); ?></span></p>
        <hr>
    </div>
</div>

<?php if( $_SESSION['role'] == 'pemasok' ) : ?>
    <!-- ============================================== -->
    <!-- DASHBOARD PEMASOK (WIDGET + TABEL) -->
    <!-- ============================================== -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <div class="card bg-success text-white shadow-sm h-100 rounded-4 border-0">
                <div class="card-body p-4">
                    <h4 class="card-title fw-bold">Kirim Komoditas?</h4>
                    <p class="card-text">Daftarkan jadwal dan rincian muatan Anda agar tim gudang dapat menyiapkan area penerimaan sebelum armada Anda tiba.</p>
                    <!-- LINK DIPERBAIKI: Mengarah ke form tambah -->
                    <a href="<?= BASEURL; ?>/asn/tambah" class="btn btn-light fw-bold text-success mt-2 px-4 shadow-sm">+ Ajukan Jadwal ASN</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-white shadow-sm h-100 rounded-4 border-0 border-top border-success border-4">
                <div class="card-body p-4">
                    <h5 class="card-title text-success fw-bold"><i class="bi bi-clock-history me-2"></i>Status Jadwal Terakhir</h5>
                    
                    <!-- WIDGET STATUS DINAMIS -->
                    <?php if(empty($data['asn'])) : ?>
                        <p class="text-muted mt-3">Belum ada pengajuan jadwal kedatangan barang ke gudang.</p>
                    <?php else : ?>
                        <h4 class="fw-bold text-dark mt-3 mb-1"><?= date('d M Y', strtotime($data['asn'][0]['waktu_rencana_tiba'])); ?></h4>
                        <p class="text-muted mb-2">Komoditas: <?= $data['asn'][0]['komoditas']; ?></p>
                        <?php 
                            $status_terakhir = $data['asn'][0]['status_jadwal'];
                            if($status_terakhir == 'menunggu') echo '<span class="badge bg-warning text-dark fs-6"><i class="bi bi-hourglass-split me-1"></i> Sedang Menunggu Validasi</span>';
                            elseif($status_terakhir == 'disetujui') echo '<span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i> Telah Disetujui</span>';
                            else echo '<span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i> Ditolak</span>';
                        ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- TABEL RIWAYAT ASN -->
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold text-secondary mb-3"><i class="bi bi-table me-2"></i>Riwayat Pengajuan Anda</h4>
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">No</th>
                                    <th>Waktu Rencana Tiba</th>
                                    <th>Komoditas</th>
                                    <th>Estimasi Berat</th>
                                    <th>Status Validasi Gudang</th>
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
                                        <td class="px-4 fw-bold text-secondary"><?= $i++; ?></td>
                                        <td><?= date('d M Y - H:i', strtotime($asn['waktu_rencana_tiba'])); ?> WIB</td>
                                        <td class="fw-medium text-dark"><?= $asn['komoditas']; ?></td>
                                        <td><?= number_format($asn['estimasi_berat_kg'], 2, ',', '.'); ?> Kg</td>
                                        <td>
                                            <?php 
                                                if($asn['status_jadwal'] == 'menunggu') {
                                                    echo '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Menunggu</span>';
                                                    $instruksi = "Tunggu konfirmasi admin";
                                                } elseif($asn['status_jadwal'] == 'disetujui') {
                                                    echo '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Disetujui</span>';
                                                    $instruksi = "<span class='text-success fw-bold'>Kirim armada ke gudang</span>";
                                                } else {
                                                    echo '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>';
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
    <!-- ============================================== -->
    <!-- WIDGET KHUSUS PEGAWAI INTERNAL GUDANG -->
    <!-- ============================================== -->
    <div class="row">
        <!-- Kartu Info 1 -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 border-start border-success border-5">
                <div class="card-body py-4">
                    <h6 class="text-muted fw-bold mb-1">Truk Menunggu Inbound</h6>
                    <h2 class="fw-bold text-dark mb-0">0 <span class="fs-6 fw-normal text-muted">Antrean</span></h2>
                </div>
            </div>
        </div>
        <!-- Kartu Info 2 -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 border-start border-warning border-5">
                <div class="card-body py-4">
                    <h6 class="text-muted fw-bold mb-1">Menunggu QC Inspeksi</h6>
                    <h2 class="fw-bold text-dark mb-0">0 <span class="fs-6 fw-normal text-muted">Komoditas</span></h2>
                </div>
            </div>
        </div>
        <!-- Kartu Info 3 -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 border-start border-info border-5">
                <div class="card-body py-4">
                    <h6 class="text-muted fw-bold mb-1">Pesanan (Picking List)</h6>
                    <h2 class="fw-bold text-dark mb-0">0 <span class="fs-6 fw-normal text-muted">Dokumen</span></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm bg-info bg-opacity-10 text-info-emphasis">
                <i class="bi bi-info-circle-fill me-2"></i> Silakan navigasikan kursor Anda ke <strong>Sidebar Kiri</strong> untuk memulai operasional teknis gudang hari ini.
            </div>
        </div>
    </div>
<?php endif; ?>