<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <h3 class="fw-bold text-success"><i class="bi bi-ui-checks-grid me-2"></i>Form Inspeksi Fisik</h3>
            <p class="text-muted small">Input parameter fisik, sistem akan otomatis menentukan kelayakan dan masa kedaluwarsa buah.</p>
        </div>
    </div>

    <form action="<?= BASEURL; ?>/qc/prosesDecision" method="POST">
        <input type="hidden" name="id_asn" value="<?= $data['asn']['id_asn']; ?>">

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-dark text-white p-3 rounded-top-4">
                <h6 class="mb-0 fw-bold"><i class="bi bi-thermometer-half me-2"></i>Parameter Armada</h6>
            </div>
            <div class="card-body p-3">
                <label class="form-label fw-medium text-secondary">Suhu Box Truk Saat Pintu Dibuka (°C) <span class="text-danger">*</span></label>
                <div class="input-group input-group-lg">
                    <input type="number" step="0.1" class="form-control fw-bold" name="suhu_truk" placeholder="Contoh: 12.5" required>
                    <span class="input-group-text bg-light text-muted">°C</span>
                </div>
                <div class="form-text text-danger small"><i class="bi bi-info-circle me-1"></i>Suhu di atas 15°C akan otomatis menyebabkan barang retur.</div>
            </div>
        </div>

        <h5 class="fw-bold mb-3"><i class="bi bi-boxes me-2"></i>Rincian Komoditas</h5>

        <?php foreach($data['detail'] as $row) : ?>
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-success bg-opacity-10 text-success p-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i><?= $row['komoditas']; ?> <span class="badge bg-success ms-2"><?= $row['berat_aktual_kg']; ?> Kg</span></h6>
            </div>
            <div class="card-body p-3">
                <input type="hidden" name="id_detail[]" value="<?= $row['id_detail']; ?>">

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">1. Tingkat Kematangan (Warna)</label>
                    <select class="form-select" name="kematangan[]" required>
                        <option value="" selected disabled>-- Pilih Kondisi --</option>
                        <option value="Hijau">Hijau (Belum Matang / Awet)</option>
                        <option value="Kekuningan">Kekuningan (Standar)</option>
                        <option value="Kuning Matang">Kuning Matang (Siap Jual)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">2. Tingkat Kekerasan (Firmness)</label>
                    <select class="form-select" name="kekerasan[]" required>
                        <option value="" selected disabled>-- Pilih Kondisi --</option>
                        <option value="Keras">Keras / Solid</option>
                        <option value="Normal">Normal</option>
                        <option value="Lembek">Lembek / Berair</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label text-muted small fw-bold">3. Cacat Fisik / Memar (%)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="cacat[]" min="0" max="100" placeholder="0 - 100" required>
                        <span class="input-group-text bg-light text-muted">%</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="d-grid gap-2 mb-5">
            <button type="submit" class="btn btn-success btn-lg fw-bold rounded-3 shadow-sm py-3" onclick="return confirm('Proses putusan inspeksi menggunakan mesin cerdas? Data tidak dapat diubah lagi.');">
                <i class="bi bi-cpu me-2"></i>Proses Putusan Otomatis
            </button>
            <a href="<?= BASEURL; ?>/qc" class="btn btn-outline-secondary fw-bold rounded-3 py-2">Batal</a>
        </div>
    </form>
</div>