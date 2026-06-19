<?php
// Kalkulasi Statistik Stok
$total_item = 0;
$total_tersedia_kg = 0;
$total_karantina_kg = 0;
$item_kedaluwarsa_dekat = 0;

if(!empty($data['stok'])) {
    $total_item = count($data['stok']);
    foreach($data['stok'] as $item) {
        if($item['status_stok'] == 'tersedia') {
            $total_tersedia_kg += $item['berat_aktif_kg'];
        } elseif($item['status_stok'] == 'karantina') {
            $total_karantina_kg += $item['berat_aktif_kg'];
        }
        
        // Peringatan kedaluwarsa (< 7 hari)
        $daysLeft = (strtotime($item['tgl_kedaluwarsa']) - time()) / (60 * 60 * 24);
        if($daysLeft > 0 && $daysLeft <= 7) {
            $item_kedaluwarsa_dekat++;
        }
    }
}
?>
<div class="container-fluid mt-4 mb-5 px-lg-4 bg-light" style="min-height: calc(100vh - 70px); padding-top: 2rem;">
    
    <div class="w-100 mx-auto" style="max-width: 1200px;">
        
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-dark mb-0 animate-box" style="letter-spacing: -0.5px;">Informasi Stok</h4>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="row g-3 mb-5">
            <!-- Total Item -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 p-3 shadow-sm border-0 h-100 d-flex align-items-center animate-box hover-elevate" style="animation-delay: 0.1s; border-left: 4px solid var(--bs-primary) !important;">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.8px;">Total Item</div>
                        <h4 class="fw-bolder text-dark mb-0" style="letter-spacing: -1px;"><?= $total_item; ?></h4>
                    </div>
                </div>
            </div>
            <!-- Tersedia -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 p-3 shadow-sm border-0 h-100 d-flex align-items-center animate-box hover-elevate" style="animation-delay: 0.15s; border-left: 4px solid var(--bs-success) !important;">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-check-circle fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.8px;">Stok Tersedia</div>
                        <h4 class="fw-bolder text-dark mb-0" style="letter-spacing: -1px;"><?= number_format($total_tersedia_kg, 0, ',', '.'); ?> <span class="fs-6 text-muted fw-normal">Kg</span></h4>
                    </div>
                </div>
            </div>
            <!-- Karantina -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 p-3 shadow-sm border-0 h-100 d-flex align-items-center animate-box hover-elevate" style="animation-delay: 0.2s; border-left: 4px solid var(--bs-danger) !important;">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-shield-exclamation fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.8px;">Stok Karantina</div>
                        <h4 class="fw-bolder text-dark mb-0" style="letter-spacing: -1px;"><?= number_format($total_karantina_kg, 0, ',', '.'); ?> <span class="fs-6 text-muted fw-normal">Kg</span></h4>
                    </div>
                </div>
            </div>
            <!-- Peringatan -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 p-3 shadow-sm border-0 h-100 d-flex align-items-center animate-box hover-elevate" style="animation-delay: 0.25s; border-left: 4px solid var(--bs-warning) !important;">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.8px;">< 7 Hari KDLW</div>
                        <h4 class="fw-bolder text-dark mb-0" style="letter-spacing: -1px;"><?= $item_kedaluwarsa_dekat; ?> <span class="fs-6 text-muted fw-normal">Item</span></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch mb-4 gap-3 animate-box">
            
            <div class="input-group bg-white rounded-4 p-2 shadow-sm border border-white w-100 flex-grow-1 align-items-center">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i class="bi bi-search fs-5"></i></span>
                <input type="text" id="searchInput" class="form-control border-0 bg-transparent fw-medium shadow-none py-2" placeholder="Search commodity or SKU..." autocomplete="off" style="font-size: 0.95rem;">
            </div>

            <!-- Filter / Tabs -->
            <div class="d-flex gap-2 bg-white rounded-4 p-2 shadow-sm border border-white overflow-auto flex-shrink-0 align-items-center" id="statusFilterTabs" style="white-space: nowrap;">
                <button class="btn btn-light bg-white rounded-3 fw-bold text-dark shadow-sm px-4 py-2 filter-btn transition-all" data-filter="all" style="font-size: 0.85rem;">All Items</button>
                <button class="btn text-muted rounded-3 fw-bold px-4 py-2 border-0 bg-transparent filter-btn transition-all" data-filter="tersedia" style="font-size: 0.85rem;">
                    <span class="spinner-grow spinner-grow-sm text-success me-1" style="width: 8px; height: 8px;" role="status"></span> Tersedia
                </button>
                <button class="btn text-muted rounded-3 fw-bold px-4 py-2 border-0 bg-transparent filter-btn transition-all" data-filter="karantina" style="font-size: 0.85rem;">
                    <span class="spinner-grow spinner-grow-sm text-danger me-1" style="width: 8px; height: 8px;" role="status"></span> Karantina
                </button>
            </div>
            
        </div>

        <!-- Stock List / Accordions -->
        <div class="row g-4 pb-5" id="stokContainer">
            <?php if(empty($data['stok'])) : ?>
                <div class="col-12 text-center py-5">
                    <span class="text-muted small">No items found</span>
                </div>
            <?php else : ?>
                <?php foreach($data['stok'] as $item) : ?>
                    <div class="col-md-6 col-xl-4 stok-card-container">
                        <!-- Card dengan efek border gradien tipis dan hover premium -->
                        <div class="stok-card bg-white rounded-4 shadow-sm p-4 h-100 position-relative transition-all hover-elevate" data-status="<?= $item['status_stok']; ?>" style="border: 1px solid rgba(0,0,0,0.04);">
                            
                            <!-- Header Card: Icon + Judul -->
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <?php if($item['status_stok'] == 'tersedia') : ?>
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);">
                                            <i class="bi bi-box-seam text-success fs-4"></i>
                                        </div>
                                    <?php else : ?>
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                                            <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div>
                                        <h6 class="fw-bolder text-dark mb-1 search-komoditas" style="font-size: 1.1rem; letter-spacing: -0.3px;"><?= $item['komoditas']; ?></h6>
                                        <div class="d-flex align-items-center gap-1">
                                            <?php if($item['status_stok'] == 'tersedia') : ?>
                                                <span class="spinner-grow spinner-grow-sm text-success" style="width: 8px; height: 8px;" role="status"></span>
                                                <span class="text-success fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Ready</span>
                                            <?php else : ?>
                                                <span class="spinner-grow spinner-grow-sm text-danger" style="width: 8px; height: 8px;" role="status"></span>
                                                <span class="text-danger fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Quarantine</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-light rounded-circle text-muted border-0 shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #f8fafc;"><i class="bi bi-three-dots-vertical"></i></button>
                            </div>

                            <!-- Indikator Freshness dengan Gradien -->
                            <?php 
                                $daysLeft = (strtotime($item['tgl_kedaluwarsa']) - time()) / (60 * 60 * 24); 
                                $pct = max(0, min(100, ($daysLeft / 60) * 100));
                                // Warna gradien berdasarkan sisa hari
                                if($pct > 50) {
                                    $gradient = "linear-gradient(90deg, #22c55e 0%, #4ade80 100%)";
                                    $textColor = "text-success";
                                } elseif($pct > 20) {
                                    $gradient = "linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%)";
                                    $textColor = "text-warning";
                                } else {
                                    $gradient = "linear-gradient(90deg, #ef4444 0%, #f87171 100%)";
                                    $textColor = "text-danger";
                                }
                            ?>
                            <div class="mb-4 px-1">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.8px;"><i class="bi bi-clock-history me-1"></i> Freshness</span>
                                    <span class="<?= $textColor; ?> fw-bold" style="font-size: 0.75rem;"><?= floor(max(0, $daysLeft)); ?> Days Left</span>
                                </div>
                                <div class="progress rounded-pill shadow-sm" style="height: 6px; background-color: #f1f5f9; overflow: visible;">
                                    <div class="progress-bar rounded-pill position-relative" role="progressbar" style="width: <?= $pct; ?>%; background: <?= $gradient; ?>;">
                                        <!-- Glow Effect on progress -->
                                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-pill" style="box-shadow: 0 0 8px <?= $pct > 50 ? '#4ade80' : ($pct > 20 ? '#fbbf24' : '#f87171'); ?>; opacity: 0.6;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Info Box -->
                            <div class="p-3 bg-gray-50 rounded-4 mt-auto" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                
                                <!-- SKU -->
                                <div class="mb-3">
                                    <div class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">Nomor SKU</div>
                                    <div class="bg-white rounded-3 p-2 text-dark search-sku fw-bold shadow-sm d-flex align-items-center" style="font-size: 0.85rem; font-family: 'Courier New', monospace; word-break: break-all; border: 1px solid #e2e8f0; letter-spacing: 1px;">
                                        <i class="bi bi-upc-scan me-2 text-muted fs-6"></i><?= $item['kode_sku']; ?>
                                    </div>
                                </div>

                                <!-- Flex 2 Columns for Rak & Berat -->
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="bg-white p-2 rounded-3 shadow-sm h-100 d-flex flex-column justify-content-center" style="border: 1px solid #e2e8f0;">
                                            <div class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px;">Lokasi Rak</div>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-geo-alt-fill text-primary" style="font-size: 0.8rem;"></i>
                                                <span class="fw-bold text-dark search-rak" style="font-size: 0.85rem;"><?= $item['lokasi_rak']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-white p-2 rounded-3 shadow-sm h-100 d-flex flex-column justify-content-center" style="border: 1px solid #e2e8f0;">
                                            <div class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px;">Total Berat</div>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-speedometer text-warning" style="font-size: 0.8rem;"></i>
                                                <span class="text-dark fw-bold" style="font-size: 0.85rem;"><?= number_format($item['berat_aktif_kg'], 0, ',', '.'); ?> <small class="text-muted fw-normal">Kg</small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- End stok-card -->
                    </div> <!-- End col wrapper -->
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
</div>

<script>
    let currentStatusFilter = 'all';

    // Event listener for search input
    document.getElementById('searchInput').addEventListener('keyup', function() {
        applyFilters();
    });

    // Event listeners for filter tabs
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Reset active style on all buttons
            filterBtns.forEach(b => {
                b.classList.remove('btn-white', 'text-dark', 'shadow-sm');
                b.classList.add('text-muted', 'bg-transparent');
            });
            // Set active style on clicked button
            this.classList.remove('text-muted', 'bg-transparent');
            this.classList.add('btn-white', 'text-dark', 'shadow-sm');

            currentStatusFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    function applyFilters() {
        let textFilter = document.getElementById('searchInput').value.toLowerCase();
        let cards = document.querySelectorAll('.stok-card');

        cards.forEach(card => {
            let komoditas = card.querySelector('.search-komoditas').innerText.toLowerCase();
            let sku = card.querySelector('.search-sku').innerText.toLowerCase();
            let rak = card.querySelector('.search-rak').innerText.toLowerCase();
            let status = card.getAttribute('data-status');
            
            let matchesText = komoditas.includes(textFilter) || sku.includes(textFilter) || rak.includes(textFilter);
            let matchesStatus = (currentStatusFilter === 'all') || (status === currentStatusFilter);

            if (matchesText && matchesStatus) {
                card.closest('.stok-card-container').style.display = "";
            } else {
                card.closest('.stok-card-container').style.display = "none";
            }
        });
    }
</script>