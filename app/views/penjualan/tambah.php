<style>
    .input-weight-wrapper {
        position: relative;
        transition: all 0.3s ease;
    }

    .input-weight {
        font-size: 1.25rem !important;
        height: 3.5rem;
        padding-left: 3rem !important;
        transition: all 0.3s ease;
        background-color: var(--gray-100) !important;
        border-color: var(--gray-200);
        color: var(--gray-500) !important;
    }

    .input-weight:focus {
        box-shadow: 0 0 0 0.25rem rgba(22, 163, 74, 0.25);
        border-color: var(--green-400);
    }

    .input-weight-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.25rem;
        color: var(--gray-400);
        z-index: 5;
        transition: all 0.3s ease;
    }

    /* State when unlocked (enabled) */
    .input-weight-unlocked .input-weight {
        background-color: var(--white) !important;
        border-color: var(--green-400);
        color: var(--green-700) !important;
    }

    .input-weight-unlocked .input-weight-icon {
        color: var(--green-600);
    }

    .input-group-text-custom {
        background-color: var(--gray-100);
        border-color: var(--gray-200);
        color: var(--gray-500);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .input-weight-unlocked .input-group-text-custom {
        background-color: var(--green-50);
        border-color: var(--green-400);
        color: var(--green-700);
    }

    .btn-save-custom {
        transition: all 0.3s ease;
    }

    .btn-save-custom:disabled {
        background: var(--gray-300);
        border-color: var(--gray-300);
        color: var(--gray-500);
        opacity: 0.7;
        cursor: not-allowed;
        box-shadow: none;
    }
</style>

<div class="container-fluid mt-4 mb-5">
    
    <!-- HEADER -->
    <div class="row mb-4 align-items-center">
        <!-- Tombol Kembali (Kiri) -->
        <div class="col-md-3 text-start mb-3 mb-md-0">
            <a href="<?= BASEURL; ?>/penjualan" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-medium transition-all">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
        
        <!-- Teks Judul (Tengah) -->
        <div class="col-md-6 text-center">
            <h2 class="fw-bold text-green-dark mb-1 d-flex align-items-center justify-content-center">
                <div class="bg-green-light text-green rounded-3 p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-cart-plus fs-5"></i>
                </div>
                Buat Pesanan Baru
            </h2>
            <p class="text-muted mb-0 mx-auto" style="font-size: 0.92rem;">Input permintaan klien. Sistem akan otomatis memvalidasi ketersediaan stok riil.</p>
        </div>
        
        <!-- Spasi penyeimbang (Kanan) -->
        <div class="col-md-3 d-none d-md-block"></div>
    </div>

    <!-- FORM CARD -->
    <div class="row">
        <div class="col-12">
            <div class="card-clean border-0">
                <div class="card-body p-4 p-md-5">
                    
                    <form action="<?= BASEURL; ?>/penjualan/simpanPesanan" method="POST" id="formSO">
                        
                        <!-- Input Nama Klien -->
                        <div class="mb-4 pb-2 border-bottom">
                            <label class="form-label fw-bold text-dark mb-2">Nama Klien / Instansi Pemesan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control form-control-lg border-start-0 ps-0 bg-light focus-ring-green" name="nama_klien" placeholder="Contoh: Supermarket Segar Abadi" required autocomplete="off" style="font-size: 1rem;">
                            </div>
                        </div>

                        <!-- Pilihan Komoditas -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark mb-2">Pilih Komoditas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-box-seam"></i></span>
                                <select class="form-select form-select-lg border-start-0 ps-0 bg-light fw-medium" name="komoditas_dipesan" id="komoditas_dipesan" required style="font-size: 1rem;">
                                    <option value="" selected disabled>-- Pilih Komoditas Tersedia --</option>
                                    <?php foreach($data['komoditas'] as $item) : ?>
                                        <option value="<?= $item['komoditas']; ?>" data-stok="<?= $item['total_stok']; ?>">
                                            <?= $item['komoditas']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Input Berat -->
                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark mb-2">Total Berat yang Diminta (Kg) <span class="text-danger">*</span></label>
                            
                            <div class="input-group input-weight-wrapper" id="weightWrapper">
                                <i class="bi bi-lock-fill input-weight-icon" id="weightIcon"></i>
                                <input type="number" step="0.01" class="form-control fw-bold input-weight" name="total_diminta_kg" id="total_diminta_kg" placeholder="0.00" required disabled>
                                <span class="input-group-text input-group-text-custom">Kg</span>
                            </div>
                            
                            <div class="form-text mt-3 fw-medium d-flex align-items-center p-3 rounded-3" style="background-color: var(--gray-50); border: 1px dashed var(--gray-300);" id="info_stok_container">
                                <i class="bi bi-info-circle text-muted fs-5 me-3" id="info_icon"></i>
                                <span id="info_stok" class="text-secondary">Pilih komoditas terlebih dahulu untuk melihat sisa stok yang tersedia di gudang.</span>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="text-end mt-2 pt-4 border-top">
                            <button type="submit" class="btn btn-green btn-lg fw-bold px-5 rounded-pill shadow-sm btn-save-custom" id="btnSimpan" disabled>
                                <i class="bi bi-save me-2"></i>Simpan Sales Order
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('komoditas_dipesan').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let maxStok = parseFloat(selectedOption.getAttribute('data-stok'));
        
        let inputBerat = document.getElementById('total_diminta_kg');
        let weightWrapper = document.getElementById('weightWrapper');
        let weightIcon = document.getElementById('weightIcon');
        
        let infoStokContainer = document.getElementById('info_stok_container');
        let infoStok = document.getElementById('info_stok');
        let infoIcon = document.getElementById('info_icon');
        
        let btnSimpan = document.getElementById('btnSimpan');

        // Buka gembok input box dan tombol simpan
        inputBerat.disabled = false;
        btnSimpan.disabled = false;
        
        // Transisi Animasi UI
        weightWrapper.classList.add('input-weight-unlocked');
        weightIcon.classList.remove('bi-lock-fill');
        weightIcon.classList.add('bi-unlock-fill');
        
        // Kunci batas maksimal sesuai stok di database
        inputBerat.max = maxStok;
        inputBerat.value = ""; // Reset value biar admin ngetik ulang
        
        // Update pesan UI agar Admin Penjualan tahu batasnya
        infoStokContainer.style.backgroundColor = 'var(--green-50)';
        infoStokContainer.style.borderColor = 'var(--green-200)';
        infoIcon.className = 'bi bi-check-circle-fill text-green fs-5 me-3';
        
        infoStok.innerHTML = `<span class="text-green-dark">Stok maksimal yang bisa dijual saat ini: <strong class="fs-6">${maxStok.toLocaleString('id-ID')} Kg</strong></span>`;
        
        // Fokuskan ke input
        setTimeout(() => { inputBerat.focus(); }, 100);
    });
</script>