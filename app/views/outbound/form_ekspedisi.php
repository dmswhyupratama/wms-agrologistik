<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-truck me-2"></i>Proses Ekspedisi</h2>
                <p class="text-muted">Catat data armada pengiriman untuk menyelesaikan pesanan ini.</p>
            </div>
            <a href="<?= BASEURL; ?>/outbound" class="btn btn-outline-secondary shadow-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-white p-3 rounded-top-4">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>Informasi Muatan (Siap Kirim)</h6>
                </div>
                <div class="card-body p-4">
                    
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted small fw-bold">ID Pesanan</div>
                        <div class="col-sm-8 fw-bold fs-5 text-dark">SO-<?= str_pad($data['so']['id_so'], 4, '0', STR_PAD_LEFT); ?></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted small fw-bold">Klien Tujuan</div>
                        <div class="col-sm-8 fw-medium"><?= $data['so']['nama_klien']; ?></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted small fw-bold">Muatan Komoditas</div>
                        <div class="col-sm-8 fw-bold text-primary"><?= $data['so']['komoditas_dipesan']; ?> &nbsp;—&nbsp; <?= number_format($data['so']['total_diminta_kg'], 2, ',', '.'); ?> Kg</div>
                    </div>

                    <hr class="mb-4">

                    <form action="<?= BASEURL; ?>/outbound/simpanEkspedisi" method="POST">
                        <input type="hidden" name="id_so" value="<?= $data['so']['id_so']; ?>">

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Supir Armada <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-vcard text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" name="nama_supir" placeholder="Contoh: Budi Santoso" required autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark">Plat Nomor Kendaraan (Nopol) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-123 text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 text-uppercase fw-bold" name="plat_nomor" placeholder="Contoh: B 1234 XYZ" required autocomplete="off">
                            </div>
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Sistem otomatis mengubah format huruf menjadi kapital.</div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold px-5 rounded-3 shadow-sm text-dark" onclick="return confirm('Pastikan data supir dan truk sudah benar. Pesanan ini akan ditandai sebagai Selesai.');">
                                <i class="bi bi-send-check me-2"></i>Terbitkan Surat Jalan & Selesai
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>