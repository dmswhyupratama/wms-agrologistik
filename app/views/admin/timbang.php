<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-speedometer2 me-2"></i>Timbang Truk Inbound</h2>
                <p class="text-muted">Masukkan berat aktual hasil timbangan gudang sebelum dioper ke Petugas QC.</p>
            </div>
            <a href="<?= BASEURL; ?>/admin/inbound" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-dark text-white p-3 rounded-top-4">
            <h6 class="mb-0 fw-bold"><i class="bi bi-truck me-2"></i>Detail Informasi Armada</h6>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1 text-muted small">Nama Pemasok</p>
                    <h5 class="fw-bold"><?= $data['asn']['nama_pemasok']; ?></h5>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted small">Jadwal Tiba</p>
                    <h5 class="fw-bold text-primary"><?= date('d F Y - H:i', strtotime($data['asn']['waktu_rencana_tiba'])); ?> WIB</h5>
                </div>
            </div>

            <hr>

            <form action="<?= BASEURL; ?>/admin/simpanTimbang" method="POST">
                <input type="hidden" name="id_asn" value="<?= $data['asn']['id_asn']; ?>">

                <h6 class="fw-bold text-success mb-3 mt-4">Daftar Komoditas (Input Berat Fisik)</h6>
                
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis Buah</th>
                                <th class="text-end">Estimasi Pemasok</th>
                                <th>Berat Aktual (Kg) <span class="text-danger">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($data['detail'] as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="fw-bold"><?= $row['komoditas']; ?></td>
                                <td class="text-end text-muted"><?= number_format($row['estimasi_berat_kg'], 2, ',', '.'); ?> Kg</td>
                                <td>
                                    <input type="hidden" name="id_detail[]" value="<?= $row['id_detail']; ?>">
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" name="berat_aktual_kg[]" placeholder="Contoh: <?= $row['estimasi_berat_kg']; ?>" required>
                                        <span class="input-group-text">Kg</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success fw-bold px-4"><i class="bi bi-save2 me-2"></i>Simpan & Oper ke QC</button>
                </div>
            </form>
        </div>
    </div>
</div>