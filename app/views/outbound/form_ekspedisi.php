<div class="container-fluid mt-4 mb-5 px-lg-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="animate-box">
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;"><i class="bi bi-truck me-2 text-green"></i>Proses Ekspedisi</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Catat data armada pengiriman untuk menerbitkan surat jalan dan menyelesaikan pesanan.</p>
        </div>
        <a href="<?= BASEURL; ?>/outbound" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium hover-elevate text-secondary shadow-sm animate-box">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 border-0 mb-4 animate-box">
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

    <div class="bg-white rounded-4 shadow-sm p-4 border-0 animate-box">
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
                <button type="submit" class="btn btn-green rounded-pill fw-medium px-4 py-2 shadow-sm text-white hover-elevate">
                    <i class="bi bi-send-check me-2"></i>Terbitkan Surat Jalan & Selesai
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Confirm Ekspedisi -->
<div class="modal fade" id="modalEkspedisi" tabindex="-1" aria-labelledby="modalEkspedisiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
      <div class="modal-body p-4 text-center">
        <!-- Premium Icon -->
        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 mt-2 shadow-sm" style="width: 80px; height: 80px;">
            <i class="bi bi-check-lg" style="font-size: 3.5rem; -webkit-text-stroke: 2px;"></i>
        </div>
        
        <h4 class="fw-bold text-dark mb-2">Terbitkan Surat?</h4>
        <p class="text-muted mb-4 small px-2">Data armada sudah benar? Surat jalan akan diterbitkan dan pesanan ini akan ditandai selesai sepenuhnya.</p>
        
        <div class="d-flex flex-column gap-2">
            <button type="button" class="btn btn-green rounded-pill py-2 fw-bold shadow-sm w-100" onclick="processEkspedisi()">
                <i class="bi bi-check-circle me-1"></i> Ya, Terbitkan
            </button>
            <button type="button" class="btn btn-light rounded-pill py-2 fw-medium w-100 text-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('modalEkspedisi');
    if (modalEl) {
        // Pindahkan modal ke body agar tidak freeze karena z-index
        document.body.appendChild(modalEl);
        
        // Inisialisasi modal secara programatik
        const ekspedisiModal = new bootstrap.Modal(modalEl);

        // Intercept form submission agar HTML5 Validation berjalan dulu
        document.getElementById('formEkspedisi').addEventListener('submit', function(e) {
            if (!this.dataset.confirmed) {
                e.preventDefault(); // Hentikan submit langsung
                ekspedisiModal.show(); // Tampilkan konfirmasi
            }
        });

        // Eksekusi ketika konfirmasi disetujui di dalam modal
        window.processEkspedisi = function() {
            let form = document.getElementById('formEkspedisi');
            form.dataset.confirmed = 'true';
            
            // Sembunyikan modal agar UI tidak stuck
            ekspedisiModal.hide();
            
            // Beri jeda animasi modal hilang sebelum pindah halaman
            setTimeout(() => {
                form.submit(); 
            }, 150);
        };
    }
});
</script>