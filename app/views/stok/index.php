<div class="container-fluid mt-4 mb-5">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-boxes me-2"></i>Informasi Stok & Rak</h2>
                <p class="text-muted">Pantau ketersediaan komoditas dan lokasinya secara real-time.</p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                <span class="input-group-text bg-white border-0 text-muted ps-4"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control border-0 fw-medium bg-white" placeholder="Cari berdasarkan komoditas, SKU, atau kode rak...">
            </div>
        </div>
    </div>

    <div class="row" id="stokContainer">
        <?php if(empty($data['stok'])) : ?>
            <div class="col-12 text-center text-muted mt-5">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2 fw-bold">Gudang Kosong.</p>
                <p>Tidak ada data stok di dalam rak saat ini.</p>
            </div>
        <?php else : ?>
            <?php foreach($data['stok'] as $item) : ?>
                <div class="col-md-6 col-lg-4 mb-4 stok-card">
                    <div class="card shadow-sm border-0 rounded-4 h-100 <?= ($item['status_stok'] == 'karantina') ? 'border-start border-4 border-warning' : 'border-start border-4 border-success'; ?>">
                        <div class="card-body p-4">
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-dark fs-6 search-rak">
                                    <i class="bi bi-geo-alt-fill me-1"></i><?= $item['lokasi_rak']; ?>
                                </span>
                                <?php if($item['status_stok'] == 'tersedia') : ?>
                                    <span class="badge bg-success-subtle text-success border border-success"><i class="bi bi-check-circle me-1"></i>Tersedia</span>
                                <?php else : ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning"><i class="bi bi-exclamation-triangle me-1"></i>Karantina</span>
                                <?php endif; ?>
                            </div>

                            <h5 class="fw-bold text-dark mb-1 search-komoditas"><?= $item['komoditas']; ?></h5>
                            <p class="text-muted small mb-3"><i class="bi bi-upc-scan me-1"></i>SKU: <span class="search-sku"><?= $item['kode_sku']; ?></span></p>
                            
                            <div class="d-flex justify-content-between align-items-center bg-light rounded-3 p-3">
                                <div>
                                    <span class="d-block text-muted small fw-bold mb-1">Berat Tersisa:</span>
                                    <span class="fs-4 fw-bold text-primary"><?= number_format($item['berat_aktif_kg'], 2, ',', '.'); ?> Kg</span>
                                </div>
                                <div class="text-end">
                                    <span class="d-block text-muted small fw-bold mb-1">Kedaluwarsa:</span>
                                    <span class="fs-6 fw-bold <?= (strtotime($item['tgl_kedaluwarsa']) < strtotime('+7 days')) ? 'text-danger' : 'text-dark'; ?>">
                                        <?= date('d M Y', strtotime($item['tgl_kedaluwarsa'])); ?>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll('.stok-card');

        cards.forEach(card => {
            let komoditas = card.querySelector('.search-komoditas').innerText.toLowerCase();
            let sku = card.querySelector('.search-sku').innerText.toLowerCase();
            let rak = card.querySelector('.search-rak').innerText.toLowerCase();
            
            // Tampilkan kartu jika ada kecocokan teks
            if (komoditas.includes(filter) || sku.includes(filter) || rak.includes(filter)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
</script>