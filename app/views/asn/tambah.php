<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-4">
            <a href="<?= BASEURL; ?>/home" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i> Kembali</a>
            <h3 class="fw-bold text-success mb-0">Form Pengajuan Pra-Inbound</h3>
        </div>

        <div class="card shadow-sm border-0 rounded-4 border-top border-success border-4">
            <div class="card-body p-5">
                <form action="<?= BASEURL; ?>/asn/prosesTambah" method="POST">
                    
                    <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2">1. Input Jadwal Tiba</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-medium">Tanggal Rencana Tiba</label>
                            <input type="date" class="form-control form-control-lg bg-light" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="jam" class="form-label fw-medium">Jam Kedatangan</label>
                            <input type="time" class="form-control form-control-lg bg-light" id="jam" name="jam" required>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2 mt-5">2. Detail Komoditas & Muatan</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="komoditas" class="form-label fw-medium">Pilih Komoditas</label>
                            <select class="form-select form-select-lg bg-light" id="komoditas" name="komoditas" required>
                                <option value="" disabled selected>-- Pilih Jenis --</option>
                                <option value="Beras Premium">Beras Premium</option>
                                <option value="Jagung Pakan">Jagung Pakan</option>
                                <option value="Kedelai">Kedelai</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="estimasi_berat_kg" class="form-label fw-medium">Estimasi Berat (Kg)</label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.01" class="form-control bg-light" id="estimasi_berat_kg" name="estimasi_berat_kg" required placeholder="Contoh: 1500.50">
                                <span class="input-group-text">Kg</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-success btn-lg fw-bold py-3 shadow-sm">
                            <i class="bi bi-send-check me-2"></i> Submit Data ASN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>