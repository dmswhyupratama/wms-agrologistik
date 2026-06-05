<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-cart-plus me-2"></i>Buat Pesanan Baru</h2>
                <p class="text-muted">Input permintaan klien. Sistem akan otomatis memvalidasi ketersediaan stok riil di gudang.</p>
            </div>
            <a href="<?= BASEURL; ?>/penjualan" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    
                    <form action="<?= BASEURL; ?>/penjualan/simpanPesanan" method="POST">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Klien / Instansi Pemesan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="nama_klien" placeholder="Contoh: Supermarket Segar Abadi" required autocomplete="off">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Pilih Komoditas <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg fw-medium" name="komoditas_dipesan" id="komoditas_dipesan" required>
                                <option value="" selected disabled>-- Pilih Komoditas Tersedia --</option>
                                <?php foreach($data['komoditas'] as $item) : ?>
                                    <option value="<?= $item['komoditas']; ?>" data-stok="<?= $item['total_stok']; ?>">
                                        <?= $item['komoditas']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark">Total Berat yang Diminta (Kg) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.01" class="form-control fw-bold text-primary" name="total_diminta_kg" id="total_diminta_kg" placeholder="0" required disabled>
                                <span class="input-group-text bg-light text-muted">Kg</span>
                            </div>
                            <div class="form-text mt-2 fw-bold text-success" id="info_stok">
                                <i class="bi bi-info-circle me-1"></i>Pilih komoditas terlebih dahulu untuk melihat sisa stok.
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold px-5 rounded-3 shadow-sm" id="btnSimpan" disabled>
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
        let infoStok = document.getElementById('info_stok');
        let btnSimpan = document.getElementById('btnSimpan');

        // Buka gembok input box dan tombol simpan
        inputBerat.disabled = false;
        btnSimpan.disabled = false;
        
        // Kunci batas maksimal sesuai stok di database
        inputBerat.max = maxStok;
        inputBerat.value = ""; // Reset value biar admin ngetik ulang
        
        // Update pesan UI agar Admin Penjualan tahu batasnya
        infoStok.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i>Stok maksimal yang bisa dijual saat ini: <strong>${maxStok.toLocaleString('id-ID')} Kg</strong>`;
    });
</script>