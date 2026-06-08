<div class="container-fluid mt-4">
    
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-graph-up-arrow me-2"></i>Laporan Penyusutan (Waste)</h2>
                <p class="text-muted">Pantau tingkat efisiensi penyimpanan dan identifikasi lonjakan komoditas busuk.</p>
            </div>
            <a href="<?= BASEURL; ?>/waste/cetakLaporan" target="_blank" class="btn btn-outline-secondary fw-bold shadow-sm">
                <i class="bi bi-printer me-2"></i>Cetak Laporan
            </a>
        </div>
    </div>

    <?php if($data['statistik']['is_alert']) : ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger bg-danger text-white border-0 shadow-sm rounded-4 d-flex align-items-center p-4">
                    <i class="bi bi-exclamation-triangle-fill fs-1 me-4"></i>
                    <div>
                        <h4 class="fw-bold mb-1">PERINGATAN KRITIS: Batas Toleransi Penyusutan Terlampaui!</h4>
                        <p class="mb-0 fs-5">Tingkat pembusukan/limbah harian mencapai <strong><?= number_format($data['statistik']['persentase'], 1, ',', '.'); ?>%</strong> (Batas maksimal 5%). Segera lakukan inspeksi suhu Chiller dan evaluasi kualitas pasokan masuk.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 border-start border-4 <?= $data['statistik']['is_alert'] ? 'border-danger' : 'border-success'; ?> h-100">
                <div class="card-body p-4">
                    <p class="text-muted fw-bold mb-1">Rasio Penyusutan Hari Ini</p>
                    <h2 class="fw-bold <?= $data['statistik']['is_alert'] ? 'text-danger' : 'text-success'; ?> mb-0">
                        <?= number_format($data['statistik']['persentase'], 2, ',', '.'); ?> <span class="fs-5">%</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <p class="text-muted fw-bold mb-1">Total Limbah Dibuang</p>
                    <h2 class="fw-bold text-dark mb-0"><?= number_format($data['statistik']['total_waste'], 2, ',', '.'); ?> <span class="fs-5">Kg</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <p class="text-muted fw-bold mb-1">Total Stok Tersedia</p>
                    <h2 class="fw-bold text-primary mb-0"><?= number_format($data['statistik']['total_stok'], 2, ',', '.'); ?> <span class="fs-5">Kg</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-dark text-white p-3 rounded-top-4">
            <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Riwayat Evaluasi Karantina</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu & Tanggal</th>
                            <th>Komoditas (SKU)</th>
                            <th>Alasan NG</th>
                            <th class="text-end">Dilaporkan</th>
                            <th class="text-end text-success">Diselamatkan</th>
                            <th class="text-end text-danger">Dibuang</th>
                            <th>Aktor Terlibat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['laporan'])) : ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada riwayat pemusnahan barang.</td></tr>
                        <?php else : ?>
                            <?php foreach($data['laporan'] as $log) : ?>
                                <?php $limbah_murni = $log['berat_susut_kg'] - $log['berat_recovery_kg']; ?>
                                <tr>
                                    <td>
                                        <span class="d-block fw-bold text-dark"><?= date('d M Y', strtotime($log['waktu_catat'])); ?></span>
                                        <span class="text-muted small"><?= date('H:i', strtotime($log['waktu_catat'])); ?> WIB</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold"><?= $log['komoditas']; ?></span><br>
                                        <span class="text-muted small"><?= $log['kode_sku']; ?></span>
                                    </td>
                                    <td class="text-danger fw-medium"><?= $log['keterangan_ng']; ?></td>
                                    <td class="text-end fw-bold"><?= number_format($log['berat_susut_kg'], 2, ',', '.'); ?> Kg</td>
                                    <td class="text-end text-success fw-bold"><?= number_format($log['berat_recovery_kg'], 2, ',', '.'); ?> Kg</td>
                                    <td class="text-end text-danger fw-bold fs-6"><?= number_format($limbah_murni, 2, ',', '.'); ?> Kg</td>
                                    <td>
                                        <ul class="list-unstyled small mb-0">
                                            <li><i class="bi bi-person me-1"></i>Kru: <span class="fw-medium"><?= explode(' ', trim($log['pelapor']))[0]; ?></span></li>
                                            <li><i class="bi bi-person-check me-1"></i>QC: <span class="fw-medium"><?= explode(' ', trim($log['pemeriksa']))[0]; ?></span></li>
                                        </ul>
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