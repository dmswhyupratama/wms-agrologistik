<div class="container-fluid mt-4 mb-5 px-lg-4 bg-light" style="min-height: calc(100vh - 70px); padding-top: 2rem;">
    
    <div class="w-100 mx-auto" style="max-width: 1200px;">
        
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Informasi Stok</h4>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            
            <div class="input-group bg-white rounded-4 p-2 shadow-sm border border-white w-100" style="max-width: 350px;">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control border-0 bg-transparent fw-medium" placeholder="Search commodity or SKU..." autocomplete="off">
            </div>

            <!-- Filter / Tabs -->
            <div class="d-flex gap-2 bg-white bg-opacity-75 rounded-pill p-1 shadow-sm border border-white overflow-auto" id="statusFilterTabs" style="white-space: nowrap;">
                <button class="btn btn-sm btn-white rounded-pill fw-bold text-dark shadow-sm px-4 filter-btn" data-filter="all" style="font-size: 0.75rem;">All</button>
                <button class="btn btn-sm text-muted rounded-pill fw-bold px-3 border-0 bg-transparent filter-btn" data-filter="tersedia" style="font-size: 0.75rem;">
                    <span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px; vertical-align: middle;"></span> Tersedia
                </button>
                <button class="btn btn-sm text-muted rounded-pill fw-bold px-3 border-0 bg-transparent filter-btn" data-filter="karantina" style="font-size: 0.75rem;">
                    <span class="d-inline-block rounded-circle bg-danger me-1" style="width: 6px; height: 6px; vertical-align: middle;"></span> Karantina
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
                        <div class="stok-card bg-white rounded-4 shadow-sm p-4 border border-white h-100 position-relative transition-all hover-elevate" data-status="<?= $item['status_stok']; ?>">
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                        <i class="bi bi-box-seam text-secondary fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0 search-komoditas" style="font-size: 1rem;"><?= $item['komoditas']; ?></h6>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <?php if($item['status_stok'] == 'tersedia') : ?>
                                                <span class="d-inline-block rounded-circle bg-success" style="width: 6px; height: 6px;"></span>
                                                <span class="text-success fw-bold" style="font-size: 0.7rem;">Tersedia</span>
                                            <?php else : ?>
                                                <span class="d-inline-block rounded-circle bg-danger" style="width: 6px; height: 6px;"></span>
                                                <span class="text-danger fw-bold" style="font-size: 0.7rem;">Karantina</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm text-muted border-0 bg-transparent"><i class="bi bi-chevron-down"></i></button>
                            </div>

                        <!-- Mini indicator: Life / Expiry concept -->
                        <?php 
                            $daysLeft = (strtotime($item['tgl_kedaluwarsa']) - time()) / (60 * 60 * 24); 
                            $pct = max(0, min(100, ($daysLeft / 60) * 100)); // assuming 60 days is 100% health for visuals
                            $color = $pct > 30 ? 'bg-success' : 'bg-danger';
                        ?>
                        <div class="mb-3 px-1">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Freshness Life</span>
                                <span class="text-dark fw-bold" style="font-size: 0.7rem;"><?= floor(max(0, $daysLeft)); ?>d</span>
                            </div>
                            <div class="progress" style="height: 4px; background-color: #f1f5f9;">
                                <div class="progress-bar <?= $color; ?>" role="progressbar" style="width: <?= $pct; ?>%;"></div>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-muted fw-bold text-uppercase pb-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">Rak</th>
                                        <th class="text-muted fw-bold text-uppercase pb-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">SKU</th>
                                        <th class="text-muted fw-bold text-uppercase pb-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">Weight</th>
                                        <th class="text-muted fw-bold text-uppercase text-end pb-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-top: 1px solid #f1f5f9;">
                                        <td class="pt-2">
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="d-inline-block rounded-circle bg-primary" style="width: 5px; height: 5px;"></span>
                                                <span class="fw-bold text-dark search-rak" style="font-size: 0.8rem;"><?= $item['lokasi_rak']; ?></span>
                                            </div>
                                        </td>
                                        <td class="pt-2"><span class="text-muted fw-medium search-sku" style="font-size: 0.8rem;"><?= $item['kode_sku']; ?></span></td>
                                        <td class="pt-2"><span class="text-dark fw-bold" style="font-size: 0.8rem;"><?= number_format($item['berat_aktif_kg'], 0, ',', '.'); ?>Kg</span></td>
                                        <td class="text-end pt-2">
                                            <span class="badge <?= ($item['status_stok'] == 'tersedia') ? 'bg-success' : 'bg-danger'; ?> text-white rounded-pill px-3 py-1" style="font-size: 0.7rem;">Done</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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