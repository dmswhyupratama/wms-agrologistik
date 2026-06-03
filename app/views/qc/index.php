<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <?php Flasher::flash(); ?>
            <h2 class="fw-bold text-success"><i class="bi bi-clipboard-check me-2"></i>Dashboard Quality Control</h2>
            <p class="text-muted">Daftar armada truk yang sedang menunggu inspeksi fisik di Loading Dock.</p>
            <hr>
        </div>
    </div>

    <div class="row">
        <?php if( empty($data['asn']) ) : ?>
            <div class="col-12">
                <div class="alert alert-light text-center py-5 border rounded-4 text-muted">
                    <i class="bi bi-emoji-smile fs-1 d-block mb-3"></i>
                    Belum ada antrean truk untuk diinspeksi saat ini.
                </div>
            </div>
        <?php else : ?>
            <?php foreach( $data['asn'] as $asn ) : ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 rounded-4 h-100 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-info text-dark"><i class="bi bi-truck me-1"></i> Truk Tiba</span>
                            <small class="text-muted fw-bold"><?= date('H:i', strtotime($asn['waktu_rencana_tiba'])); ?> WIB</small>
                        </div>
                        <h5 class="fw-bold text-dark mb-1"><?= $asn['nama_pemasok']; ?></h5>
                        <p class="text-secondary small mb-3"><i class="bi bi-box-seam me-2"></i><?= $asn['daftar_komoditas']; ?></p>
                        
                        <a href="<?= BASEURL; ?>/qc/inspeksi/<?= $asn['id_asn']; ?>" class="btn btn-success w-100 fw-bold rounded-3">
                            <i class="bi bi-search me-2"></i>Mulai Inspeksi
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-12">
            <h5 class="fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>Riwayat Inspeksi QC</h5>
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Jadwal Asli</th>
                                    <th>Pemasok</th>
                                    <th>Komoditas</th>
                                    <th>Putusan Mesin (Status)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($data['riwayat'])) : ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat inspeksi.</td>
                                </tr>
                                <?php else : ?>
                                    <?php foreach($data['riwayat'] as $riwayat) : ?>
                                    <tr>
                                        <td class="px-4"><small class="text-muted"><?= date('d M Y - H:i', strtotime($riwayat['waktu_rencana_tiba'])); ?></small></td>
                                        <td class="fw-bold text-primary"><?= $riwayat['nama_pemasok']; ?></td>
                                        <td><?= $riwayat['daftar_komoditas']; ?></td>
                                        <td>
                                            <?php if($riwayat['status_jadwal'] == 'siap_putaway') : ?>
                                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Lolos QC (Siap Masuk Rak)</span>
                                            <?php elseif($riwayat['status_jadwal'] == 'ada_retur') : ?>
                                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak (Retur)</span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary"><i class="bi bi-archive"></i> In-Storage (Di dalam Gudang)</span>
                                            <?php endif; ?>
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

</div>