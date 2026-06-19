<style>
.rak-box { background: #fcfcfc; border-color: #e5e7eb; cursor: pointer; }
.rak-box:hover { border-color: var(--green-400) !important; background: var(--green-50); transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,0,0,.05); }
.rak-box.active { box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2); }
</style>
<div class="container-fluid mt-4 mb-5 px-lg-4">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4 pb-2">
        <a href="<?= BASEURL; ?>/admin/putaway" class="btn btn-light rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center transition-all" style="width: 48px; height: 48px;">
            <i class="bi bi-arrow-left text-secondary fs-5"></i>
        </a>
        <div>
            <h2 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Alokasi Rak (Putaway)</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Tentukan rak penyimpanan & buat identitas batch untuk komoditas.</p>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- Left Column: Info Card -->
        <div class="col-12 col-xl-4">
            <div class="bg-white rounded-4 shadow-sm p-4 border-0 position-relative overflow-hidden h-100">
                <div class="position-absolute top-0 start-0 w-100 bg-success" style="height: 4px;"></div>
                
                <h6 class="text-success text-uppercase mb-2 fw-bold mt-2" style="font-size: 0.75rem; letter-spacing: 1px;"><i class="bi bi-check-circle-fill me-1"></i> Lolos Inspeksi QC</h6>
                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.3px;"><?= $data['item']['komoditas']; ?></h3>
                <p class="text-secondary mb-4 pb-3 border-bottom small fw-medium"><i class="bi bi-building me-1"></i>Pemasok: <?= $data['item']['nama_pemasok']; ?></p>
                
                <div class="mb-4">
                    <span class="text-muted d-block small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Berat Aktual</span>
                    <span class="text-dark fw-bold fs-3"><?= number_format($data['item']['berat_aktual_kg'], 2, ',', '.'); ?> <span class="text-muted fs-6 fw-normal">Kg</span></span>
                </div>
                
                <div class="mb-2">
                    <span class="text-muted d-block small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Tgl Kedaluwarsa</span>
                    <span class="text-danger fw-bold fs-5"><i class="bi bi-calendar-x me-2 small"></i><?= date('d F Y', strtotime($data['item']['tanggal_kedaluwarsa'])); ?></span>
                </div>
            </div>
        </div>

        <!-- Right Column: Form -->
        <div class="col-12 col-xl-8">
            <div class="bg-white rounded-4 shadow-sm border-0 p-4 p-lg-5 position-relative overflow-hidden h-100">
                <form action="<?= BASEURL; ?>/admin/simpanPutaway" method="POST" id="formPutaway" class="h-100 d-flex flex-column">
                    <input type="hidden" name="id_detail" value="<?= $data['item']['id_detail']; ?>">
                    <input type="hidden" name="berat_aktual_asli" id="berat_aktual_asli" value="<?= $data['item']['berat_aktual_kg']; ?>">

                    <h5 class="fw-bold text-dark mb-4 pb-3 border-bottom"><i class="bi bi-geo-alt-fill text-success me-2"></i>Pengaturan Penempatan Rak</h5>

                    <div class="row g-4 mb-4 flex-grow-1">
                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-bold text-muted small text-uppercase ms-1" style="letter-spacing: 0.5px;">Pilih Lokasi Rak <span class="text-danger">*</span></label>
                            
                            <input type="hidden" name="lokasi_rak" id="lokasi_rak" required>
                            
                            <div class="row g-2 mt-1" id="grid_rak">
                                <?php if(isset($data['rak']) && count($data['rak']) > 0) : ?>
                                    <?php foreach($data['rak'] as $rak) : ?>
                                        <?php 
                                            // Calculate free space percentage for opacity effect (REVERSED)
                                            // Racks with LOTS of free space = High opacity & Green
                                            // Racks with NO free space = Low opacity & White
                                            $fill_pct = ($rak['terisi'] / $rak['kapasitas_maksimal_kg']);
                                            $free_pct = 1.0 - $fill_pct;
                                            
                                            $box_opacity = max(0.4, $free_pct); 
                                            $bg_color = $free_pct > 0.4 ? 'rgba(25, 135, 84, 0.1)' : '#fcfcfc'; 
                                            $border_color = $free_pct > 0.4 ? 'var(--green-400)' : '#e5e7eb';
                                        ?>
                                        <div class="col-4 col-sm-3">
                                            <div class="rak-box border rounded-3 p-1 text-center transition-all d-flex flex-column justify-content-center" 
                                                 style="opacity: <?= $box_opacity; ?>; background: <?= $bg_color; ?>; border-color: <?= $border_color; ?>; min-height: 60px;"
                                                 data-val="<?= $rak['kode_lokasi']; ?>" 
                                                 data-sisa="<?= $rak['sisa_kapasitas']; ?>"
                                                 data-op="<?= $box_opacity; ?>">
                                                <span class="d-block fw-bold text-dark mb-0" style="font-size: 0.7rem; letter-spacing: 0.5px;"><?= $rak['kode_lokasi']; ?></span>
                                                <span class="d-block text-muted fw-bold" style="font-size: 0.55rem;"><?= number_format($rak['sisa_kapasitas'], 0, ',', '.'); ?> Kg</span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="col-12 text-center py-4 border rounded-3 bg-light">
                                        <span class="text-danger fw-bold"><i class="bi bi-x-circle me-1"></i> TIDAK ADA RAK TERSEDIA UNTUK KOMODITAS INI</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-bold text-muted small text-uppercase ms-1" style="letter-spacing: 0.5px;">Berat Dialokasikan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-4 ps-4 py-3"><i class="bi bi-box-seam text-secondary fs-5"></i></span>
                                <input type="number" step="0.01" class="form-control bg-light border-0 py-3 fw-bold text-success fs-5" name="berat_alokasi" id="berat_alokasi" value="<?= $data['item']['berat_aktual_kg']; ?>" max="<?= $data['item']['berat_aktual_kg']; ?>" required style="box-shadow: none;">
                                <span class="input-group-text bg-light border-0 rounded-end-4 pe-4 py-3 text-muted fw-bold">Kg</span>
                            </div>
                            <div class="form-text mt-2 ms-3 text-success small"><i class="bi bi-info-circle-fill me-1"></i>Otomatis dipecah (split) jika sisa rak kurang.</div>
                        </div>
                    </div>

                    <div class="mt-auto pt-4">
                        <button type="submit" class="btn btn-blue rounded-pill fw-bold py-3 px-5 shadow-sm fs-6">
                            <i class="bi bi-printer-fill me-2"></i> Simpan & Terbitkan Barcode
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Modal Confirm Putaway -->
<div class="modal fade" id="modalPutaway" tabindex="-1" aria-labelledby="modalPutawayLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
      <div class="modal-body p-4 text-center">
        <!-- Animated / Premium Icon -->
        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 mt-2 shadow-sm" style="width: 80px; height: 80px;">
            <i class="bi bi-check-lg" style="font-size: 3.5rem; -webkit-text-stroke: 2px;"></i>
        </div>
        
        <h4 class="fw-bold text-dark mb-2">Cetak Barcode?</h4>
        <p class="text-muted mb-4 small px-2">Sistem akan segera mengalokasikan barang ini ke rak pilihan Anda dan membuat Barcode Batch unik.</p>
        
        <div class="d-flex flex-column gap-2">
            <button type="button" class="btn btn-blue rounded-pill py-2 fw-bold shadow-sm w-100" onclick="processPutaway()">
                <i class="bi bi-check-circle me-1"></i> Ya, Alokasikan
            </button>
            <button type="button" class="btn btn-light rounded-pill py-2 fw-medium w-100 text-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Logic cerdas untuk visual grid rak
        const rakBoxes = document.querySelectorAll('.rak-box');
        const inputRak = document.getElementById('lokasi_rak');

        rakBoxes.forEach(box => {
            box.addEventListener('click', function() {
                // Reset semua box
                rakBoxes.forEach(b => {
                    b.classList.remove('active', 'border-success', 'shadow-sm');
                    b.style.boxShadow = 'none';
                    if(b.hasAttribute('data-op')) {
                        b.style.opacity = b.getAttribute('data-op');
                    }
                });
                
                // Aktifkan box yang diklik
                this.classList.add('active', 'border-success', 'shadow-sm');
                this.style.opacity = '1'; // Paksa jelas saat dipilih
                
                // Set value ke hidden input
                inputRak.value = this.getAttribute('data-val');
                
                // Logic perhitungan kapasitas
                let sisaKapasitas = parseFloat(this.getAttribute('data-sisa'));
                let beratAktualAsli = parseFloat(document.getElementById('berat_aktual_asli').value);
                let inputAlokasi = document.getElementById('berat_alokasi');

                let maxAllowable = Math.min(sisaKapasitas, beratAktualAsli);
                let currentVal = parseFloat(inputAlokasi.value) || 0;
                
                // Kunci nilai maksimal
                inputAlokasi.max = maxAllowable; 

                if (currentVal > maxAllowable || currentVal === beratAktualAsli) {
                    inputAlokasi.value = maxAllowable;
                }
            });
        });

        // Pindahkan modal ke luar dari semua container agar z-index backdrop tidak nyangkut
        const modalEl = document.getElementById('modalPutaway');
        if (modalEl) {
            document.body.appendChild(modalEl);
            
            // Inisialisasi modal hanya sekali
            const putawayModal = new bootstrap.Modal(modalEl);

            // Intercept form submission to show Modal FIRST (Ensures HTML5 validation passes)
            document.getElementById('formPutaway').addEventListener('submit', function(e) {
                // Jika form belum di-submit dari dalam modal
                if (!this.dataset.confirmed) {
                    e.preventDefault(); // Hentikan submit langsung
                    putawayModal.show(); // Tampilkan modal
                }
            });

            // Menyambungkan tombol 'Ya, Alokasikan' dengan eksekusi
            window.processPutaway = function() {
                let form = document.getElementById('formPutaway');
                form.dataset.confirmed = 'true'; // Tandai bahwa sudah dikonfirmasi
                
                // Sembunyikan modal sebelum submit agar UI tidak freeze
                putawayModal.hide();
                
                // Beri sedikit jeda agar backdrop hilang sebelum pindah halaman
                setTimeout(() => {
                    form.submit(); 
                }, 150);
            };
        }
    });
</script>