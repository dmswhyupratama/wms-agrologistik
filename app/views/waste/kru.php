<div class="container-fluid mt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Lapor Barang Rusak</h2>
            <p class="text-muted">Pindai barcode SKU dan pisahkan stok bermasalah ke Area Karantina.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 border-top border-danger border-4">
                <div class="card-body p-4">
                    
                    <form action="<?= BASEURL; ?>/waste/laporKarantina" method="POST">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Scan Barcode SKU (Target) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 fw-bold" name="kode_sku" placeholder="Contoh: SKU-260603-014" required autocomplete="off">
                            </div>
                            <div class="form-text mt-1"><i class="bi bi-info-circle me-1"></i>Pastikan menembak barcode yang tepat pada kardus.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Estimasi Berat Rusak/Busuk <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.01" class="form-control text-center fw-bold text-danger" name="berat_karantina" placeholder="0.0" required>
                                <span class="input-group-text bg-light text-muted fw-bold">Kg</span>
                            </div>
                            <div class="form-text mt-1 text-primary fw-medium">Sistem otomatis memotong angka ini dari stok gudang aktual.</div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold small text-dark">Indikasi Penyebab <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg fw-medium" name="keterangan_ng" required>
                                <option value="" selected disabled>-- Pilih Hasil Identifikasi Visual --</option>
                                <option value="Pembusukan Alami (Overripe)">Pembusukan Alami (Overripe)</option>
                                <option value="Cacat Fisik / Memar Benturan">Cacat Fisik / Memar Benturan</option>
                                <option value="Serangan Hama / Jamur">Serangan Hama / Jamur</option>
                                <option value="Kemasan Basah / Terkontaminasi">Kemasan Basah / Terkontaminasi</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger btn-lg fw-bold rounded-pill shadow-sm" onclick="return confirm('Pindahkan barang secara fisik ke Area Karantina setelah menekan OK.');">
                                <i class="bi bi-box-arrow-right me-2"></i>Karantina & Lapor QC
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>