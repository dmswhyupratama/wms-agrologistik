<div class="container-fluid mt-4 mb-5 px-lg-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;"><i class="bi bi-truck me-2 text-green"></i>Proses Ekspedisi</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Catat data armada pengiriman untuk menerbitkan surat jalan dan menyelesaikan pesanan.</p>
        </div>
        <a href="<?= BASEURL; ?>/outbound" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium hover-elevate text-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 border-0 mb-4">
        <h6 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Muatan (Siap Kirim)</h6>
        
        <div class="row g-4 mb-2">
            <div class="col-md-6">
                <p class="mb-1 text-muted fw-medium" style="font-size: 0.85rem;">ID Pesanan & Klien</p>
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-receipt fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">SO-<?= str_pad($data['so']['id_so'], 4, '0', STR_PAD_LEFT); ?></h5>
                        <div class="text-muted small"><?= $data['so']['nama_klien']; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1 text-muted fw-medium" style="font-size: 0.85rem;">Muatan Komoditas</p>
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0"><?= $data['so']['komoditas_dipesan']; ?></h5>
                        <div class="text-muted small"><?= number_format($data['so']['total_diminta_kg'], 2, ',', '.'); ?> Kg</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 border-0">
        <form action="<?= BASEURL; ?>/outbound/simpanEkspedisi" method="POST" id="formEkspedisi">
            <input type="hidden" name="id_so" value="<?= $data['so']['id_so']; ?>">

            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-truck me-2 text-warning"></i>Data Armada Ekspedisi</h6>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold text-dark">Nama Supir Armada <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-person-vcard"></i></span>
                        <input type="text" class="form-control bg-light border-0 px-3 py-2 fw-medium" name="nama_supir" placeholder="Contoh: Budi Santoso" required autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark">Plat Nomor Kendaraan (Nopol) <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-123"></i></span>
                        <input type="text" class="form-control bg-light border-0 px-3 py-2 text-uppercase fw-medium" name="plat_nomor" placeholder="Contoh: B 1234 XYZ" required autocomplete="off">
                    </div>
                    <div class="form-text mt-1" style="font-size: 0.8rem;"><i class="bi bi-info-circle me-1"></i>Otomatis dikapitalisasi.</div>
                </div>
            </div>

            <div class="text-end mt-4 pt-3">
                <button type="button" class="btn btn-warning rounded-pill fw-medium px-4 py-2 shadow-sm text-dark hover-elevate" data-bs-toggle="modal" data-bs-target="#modalEkspedisi">
                    <i class="bi bi-send-check me-2"></i>Terbitkan Surat Jalan & Selesai
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Confirm Ekspedisi -->
<div class="modal fade" id="modalEkspedisi" tabindex="-1" aria-labelledby="modalEkspedisiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalEkspedisiLabel">Konfirmasi Surat Jalan</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                <i class="bi bi-truck fs-3"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Data Armada Sudah Benar?</h6>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Surat Jalan akan diterbitkan dan pesanan ini akan ditandai selesai sepenuhnya.</p>
            </div>
        </div>
      </div>
      <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-light rounded-pill px-4 py-2 fw-medium" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow-sm" onclick="document.getElementById('formEkspedisi').submit();">Ya, Selesai</button>
      </div>
    </div>
  </div>
</div>