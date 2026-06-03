<div class="container-fluid mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-success"><i class="bi bi-check-circle-fill me-2"></i>Putaway Berhasil!</h3>
                <p class="text-muted">Komoditas telah dialokasikan ke rak. Silakan cetak barcode di bawah ini dan tempelkan pada kemasan/palet.</p>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    
                    <h5 class="fw-bold text-dark mb-1"><?= $data['stok']['komoditas']; ?></h5>
                    <p class="text-muted small mb-4">
                        Lokasi: <span class="badge bg-primary fs-6"><?= $data['stok']['lokasi_rak']; ?></span> | 
                        Berat: <strong><?= number_format($data['stok']['berat_aktif_kg'], 2, ',', '.'); ?> Kg</strong>
                    </p>

                    <div class="p-3 border rounded-3 bg-light d-inline-block mb-4">
                        <svg id="barcodeSKU"></svg>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button onclick="window.print()" class="btn btn-dark btn-lg fw-bold d-print-none">
                            <i class="bi bi-printer me-2"></i>Cetak Barcode Sekarang
                        </button>
                        <a href="<?= BASEURL; ?>/admin/putaway" class="btn btn-outline-secondary d-print-none">
                            Kembali ke Antrean Putaway
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
    // Memanggil library JsBarcode untuk menggambar barcode di dalam <svg id="barcodeSKU">
    JsBarcode("#barcodeSKU", "<?= $data['stok']['kode_sku']; ?>", {
        format: "CODE128",       // Format standar industri logistik
        lineColor: "#000",       // Warna garis hitam pekat
        width: 2.5,              // Ketebalan garis
        height: 100,             // Tinggi barcode
        displayValue: true,      // Menampilkan teks SKU di bawah garis
        fontSize: 18,
        margin: 10
    });
</script>

<style>
    @media print {
        body * { visibility: hidden; }
        .card-body, .card-body * { visibility: visible; }
        .card-body { position: absolute; left: 0; top: 0; width: 100%; border: none; padding: 0 !important; }
        .d-print-none { display: none !important; }
        .navbar, .sidebar { display: none !important; }
    }
</style>