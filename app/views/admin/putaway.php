<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-box-arrow-in-right me-2"></i>Alokasi Rak (Putaway)</h2>
                <p class="text-muted">Tentukan lokasi rak penyimpanan dan buat identitas Batch Number untuk komoditas ini.</p>
            </div>
            <a href="<?= BASEURL; ?>/admin/putaway" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-white p-3 rounded-top-4">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>Detail Komoditas (Lolos QC)</h6>
                </div>
                <div class="card-body p-4">
                    
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted small fw-bold">Komoditas</div>
                        <div class="col-sm-8 fw-bold text-success fs-5"><?= $data['item']['komoditas']; ?></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted small fw-bold">Pemasok</div>
                        <div class="col-sm-8 fw-medium"><?= $data['item']['nama_pemasok']; ?></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted small fw-bold">Berat Aktual</div>
                        <div class="col-sm-8 fw-bold"><?= number_format($data['item']['berat_aktual_kg'], 2, ',', '.'); ?> Kg</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted small fw-bold text-danger">Tgl. Kedaluwarsa</div>
                        <div class="col-sm-8 fw-bold text-danger"><?= date('d F Y', strtotime($data['item']['tanggal_kedaluwarsa'])); ?></div>
                    </div>

                    <hr class="mb-4">

                    <form action="<?= BASEURL; ?>/admin/simpanPutaway" method="POST">
                        <input type="hidden" name="id_detail" value="<?= $data['item']['id_detail']; ?>">
                        <input type="hidden" name="berat_aktual_asli" id="berat_aktual_asli" value="<?= $data['item']['berat_aktual_kg']; ?>">

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Pilih Lokasi Rak Penempatan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light"><i class="bi bi-layers"></i></span>
                                <select class="form-select fw-bold" name="lokasi_rak" id="lokasi_rak" required>
                                    <option value="" selected disabled>-- Pilih Rak Tersedia --</option>
                                    <?php if(isset($data['rak'])) : ?>
                                        <?php foreach($data['rak'] as $rak) : ?>
                                            <option value="<?= $rak['kode_lokasi']; ?>" data-sisa="<?= $rak['sisa_kapasitas']; ?>">
                                                <?= $rak['kode_lokasi']; ?> &nbsp; (Sisa Kapasitas: <?= number_format($rak['sisa_kapasitas'], 2, ',', '.'); ?> Kg)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Berat yang Dialokasikan (Kg) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.01" class="form-control fw-bold text-primary" name="berat_alokasi" id="berat_alokasi" value="<?= $data['item']['berat_aktual_kg']; ?>" max="<?= $data['item']['berat_aktual_kg']; ?>" required>
                                <span class="input-group-text bg-light text-muted">Kg</span>
                            </div>
                            <div class="form-text mt-2 text-primary" id="hint_split">
                                <i class="bi bi-info-circle me-1"></i>Sistem akan memecah (split) antrean secara otomatis jika kapasitas rak yang dipilih lebih kecil dari berat aktual barang.
                            </div>
                        </div>

                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold px-5 rounded-3 shadow-sm">
                                <i class="bi bi-printer me-2"></i>Simpan & Terbitkan Barcode
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('lokasi_rak').addEventListener('change', function() {
        // Ambil data kapasitas rak yang barusan diklik
        let selectedOption = this.options[this.selectedIndex];
        let sisaKapasitas = parseFloat(selectedOption.getAttribute('data-sisa'));
        
        // Ambil data total berat apel yang mau dimasukkan
        let beratAktualAsli = parseFloat(document.getElementById('berat_aktual_asli').value);
        let inputAlokasi = document.getElementById('berat_alokasi');

        // Logika cerdas: Pilih angka terkecil antara (Sisa Rak) VS (Berat Barang)
        let maxAllowable = Math.min(sisaKapasitas, beratAktualAsli);
        
        // Update input textbox secara otomatis dan kunci nilai maksimalnya
        inputAlokasi.value = maxAllowable;
        inputAlokasi.max = maxAllowable; 
    });
</script>