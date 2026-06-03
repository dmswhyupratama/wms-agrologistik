<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <?php Flasher::flash(); ?>
            <h2 class="fw-bold text-primary"><i class="bi bi-layers me-2"></i>Antrean Alokasi Rak (Putaway)</h2>
            <p class="text-muted">Daftar komoditas yang telah lolos inspeksi QC dan siap dialokasikan ke dalam rak penyimpanan.</p>
            <hr>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Komoditas</th>
                                    <th>Pemasok</th>
                                    <th>Berat Aktual</th>
                                    <th>Tgl. Kedaluwarsa</th>
                                    <th class="text-center">Aksi / Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($data['putaway'])) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada barang yang lolos QC dan siap dialokasikan ke rak.</td>
                                </tr>
                                <?php else : ?>
                                    <?php foreach($data['putaway'] as $item) : ?>
                                    <tr>
                                        <td class="px-4 fw-bold text-success">
                                            <i class="bi bi-box-seam me-2"></i><?= $item['komoditas']; ?>
                                        </td>
                                        <td class="fw-medium text-dark"><?= $item['nama_pemasok']; ?></td>
                                        <td><strong><?= number_format($item['berat_aktual_kg'], 2, ',', '.'); ?> Kg</strong></td>
                                        <td class="text-danger fw-bold"><?= date('d M Y', strtotime($item['tanggal_kedaluwarsa'])); ?></td>
                                        <td class="text-center">
                                            <a href="<?= BASEURL; ?>/admin/formPutaway/<?= $item['id_detail']; ?>" class="btn btn-sm btn-primary fw-bold shadow-sm px-3">
                                                <i class="bi bi-geo-alt me-1"></i> Tentukan Rak
                                            </a>
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