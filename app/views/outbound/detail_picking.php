<div class="container-fluid mt-4 mb-5 px-lg-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;"><i class="bi bi-list-check me-2 text-primary"></i>Tugas Pengambilan (Picking)</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Ambil barang sesuai instruksi dan scan barcode untuk validasi.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fs-6 fw-bold shadow-sm">SO-<?= str_pad($data['id_so'], 4, '0', STR_PAD_LEFT); ?></span>
            <a href="<?= BASEURL; ?>/outbound" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium hover-elevate text-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="row g-4">
        <?php if(empty($data['picking'])) : ?>
            <div class="col-12">
                <div class="bg-white rounded-4 shadow-sm p-5 text-center border-0 mt-2">
                    <i class="bi bi-inbox fs-1 text-muted opacity-25 d-block mb-3"></i>
                    <h5 class="text-dark fw-bold">Tidak Ada Data Instruksi</h5>
                    <p class="text-muted mb-0">Belum ada tugas pengambilan untuk pesanan ini.</p>
                </div>
            </div>
        <?php else : ?>
            <div class="col-12">
                <div class="bg-primary bg-opacity-10 rounded-4 p-3 d-inline-flex align-items-center border border-primary border-opacity-25">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="text-primary fw-bold small text-uppercase" style="letter-spacing: 0.5px;">Klien Pemesan</span>
                        <h5 class="text-dark fw-bold mb-0"><?= $data['picking'][0]['nama_klien']; ?></h5>
                    </div>
                </div>
            </div>

            <?php foreach($data['picking'] as $index => $item) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="bg-white shadow-sm border-0 rounded-4 h-100 position-relative overflow-hidden <?= ($item['status_picking'] == 'selesai') ? 'opacity-75' : ''; ?>">
                        
                        <!-- Accent Line -->
                        <div class="position-absolute top-0 start-0 w-100 <?= ($item['status_picking'] == 'selesai') ? 'bg-success' : 'bg-primary'; ?>" style="height: 4px;"></div>
                        
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <?php if($item['status_picking'] == 'selesai') : ?>
                                    <span class="badge badge-soft-success rounded-pill px-3 py-2 fw-bold">
                                        <i class="bi bi-geo-alt-fill me-1"></i><?= $item['lokasi_rak']; ?>
                                    </span>
                                <?php else : ?>
                                    <span class="badge badge-soft-danger rounded-pill px-3 py-2 fw-bold">
                                        <i class="bi bi-geo-alt-fill me-1"></i><?= $item['lokasi_rak']; ?>
                                    </span>
                                <?php endif; ?>
                                <span class="bg-light text-muted fw-bold rounded-circle d-flex justify-content-center align-items-center" style="width: 30px; height: 30px; font-size: 0.85rem;">#<?= $index + 1; ?></span>
                            </div>

                            <h5 class="fw-bold text-dark mb-1"><?= $item['komoditas']; ?></h5>
                            <div class="d-flex align-items-center text-muted small mb-4">
                                <i class="bi bi-upc-scan me-2 text-primary"></i>
                                <span>SKU Target:</span>
                                <strong class="text-dark ms-1 bg-light px-2 py-1 rounded"><?= $item['kode_sku']; ?></strong>
                            </div>
                            
                            <div class="bg-light rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between border border-secondary border-opacity-10">
                                <div>
                                    <span class="d-block text-muted fw-medium" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Ambil Sebanyak</span>
                                    <span class="fs-3 fw-bold <?= ($item['status_picking'] == 'selesai') ? 'text-success' : 'text-primary'; ?> lh-1"><?= number_format($item['berat_diambil_kg'], 2, ',', '.'); ?></span> <span class="text-muted fw-bold">Kg</span>
                                </div>
                                <div class="<?= ($item['status_picking'] == 'selesai') ? 'bg-success' : 'bg-primary'; ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-box-seam fs-4 <?= ($item['status_picking'] == 'selesai') ? 'text-success' : 'text-primary'; ?>"></i>
                                </div>
                            </div>

                            <?php if($item['status_picking'] == 'belum') : ?>
                                
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-dark">Scan Barcode Validasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-upc-scan"></i></span>
                                        <input type="text" class="form-control bg-light border-0 text-center fw-bold input-barcode py-2" 
                                               data-target="<?= $item['kode_sku']; ?>" 
                                               data-btn="btn-ambil-<?= $item['id_picking']; ?>" 
                                               placeholder="Arahkan scanner..." autocomplete="off">
                                    </div>
                                    <div class="form-text text-danger small mt-2 d-none fw-medium" id="error-<?= $item['id_picking']; ?>">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>Kode SKU Tidak Sesuai!
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="button" 
                                       class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm disabled action-btn hover-elevate" 
                                       id="btn-ambil-<?= $item['id_picking']; ?>" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#modalKonfirmasiAmbil" 
                                       data-url="<?= BASEURL; ?>/outbound/konfirmasiAmbil/<?= $item['id_picking']; ?>/<?= $data['id_so']; ?>">
                                        <i class="bi bi-lock-fill me-2" id="icon-<?= $item['id_picking']; ?>"></i>Selesai Ambil
                                    </button>
                                </div>

                            <?php else : ?>
                                <div class="d-grid mt-auto">
                                    <button class="btn btn-success bg-opacity-10 text-success border-0 rounded-pill py-2 fw-bold" disabled>
                                        <i class="bi bi-check-circle-fill me-2"></i>Telah Diambil
                                    </button>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Confirm Ambil -->
<div class="modal fade" id="modalKonfirmasiAmbil" tabindex="-1" aria-labelledby="modalKonfirmasiAmbilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalKonfirmasiAmbilLabel">Konfirmasi Pengambilan</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                <i class="bi bi-check2-circle fs-3"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Barang Telah Diambil?</h6>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Konfirmasi bahwa barang fisik telah Anda ambil dari rak dan siap dipacking.</p>
            </div>
        </div>
      </div>
      <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-light rounded-pill px-4 fw-medium" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmKonfirmasiAmbil" class="btn btn-success rounded-pill px-4 fw-bold">Ya, Selesai Ambil</a>
      </div>
    </div>
  </div>
</div>

<script>
    document.querySelectorAll('.input-barcode').forEach(input => {
        input.addEventListener('keyup', function() {
            let inputVal = this.value.trim().toUpperCase(); 
            let targetSKU = this.getAttribute('data-target').toUpperCase(); 
            let btnId = this.getAttribute('data-btn');
            
            let btnAction = document.getElementById(btnId);
            let iconBtn = document.getElementById('icon-' + btnId.replace('btn-ambil-', ''));
            let errorMsg = document.getElementById('error-' + btnId.replace('btn-ambil-', ''));

            if(inputVal === '') {
                btnAction.classList.add('disabled');
                errorMsg.classList.add('d-none');
                iconBtn.className = 'bi bi-lock-fill me-2';
                return;
            }

            if(inputVal === targetSKU) {
                // Barcode Valid! Buka gembok tombol
                btnAction.classList.remove('disabled');
                btnAction.classList.replace('btn-primary', 'btn-success'); 
                errorMsg.classList.add('d-none');
                
                iconBtn.className = 'bi bi-unlock-fill me-2';
                
                this.classList.add('text-success');
                this.classList.remove('text-danger');
            } else {
                // Barcode Salah! Kunci kembali tombol
                btnAction.classList.add('disabled');
                btnAction.classList.replace('btn-success', 'btn-primary');
                errorMsg.classList.remove('d-none');
                
                iconBtn.className = 'bi bi-lock-fill me-2';
                
                this.classList.add('text-danger');
                this.classList.remove('text-success');
            }
        });
    });

    // Handle Modal Url
    document.addEventListener('DOMContentLoaded', function() {
        const modalKonfirmasi = document.getElementById('modalKonfirmasiAmbil');
        if (modalKonfirmasi) {
            modalKonfirmasi.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const url = button.getAttribute('data-url');
                document.getElementById('btnConfirmKonfirmasiAmbil').setAttribute('href', url);
            });
        }
    });
</script>