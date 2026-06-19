<div class="container-fluid mt-4 mb-5 px-lg-4">
    
    <!-- Flash Messages (Properly positioned above the header) -->
    <div class="row mb-2">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3 fade-in-up">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">
                <i class="bi bi-box-arrow-in-down me-2 text-green"></i>Antrean Putaway
            </h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Barang lolos QC yang menunggu dialokasikan ke dalam rak penyimpanan.</p>
        </div>
    </div>

    <!-- Clean Table Card -->
    <div class="row fade-in-up" style="animation-delay: 0.1s;">
        <div class="col-12">
            <div class="card-clean bg-white border-0 rounded-4 shadow-sm overflow-hidden p-4">
                <div class="table-responsive">
                    <table class="table table-clean table-borderless table-hover align-middle mb-0" style="min-width: 800px;">
                        <thead>
                            <tr>
                                <th class="ps-4">Komoditas & Pemasok</th>
                                <th>Berat Aktual</th>
                                <th>Tgl. Kedaluwarsa</th>
                                <th class="text-center pe-4">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($data['putaway'])) : ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 border-0">
                                        <div class="bg-green-light text-green rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                            <i class="bi bi-inbox fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Antrean Kosong</h6>
                                        <p class="text-muted mb-0 small">Belum ada barang lolos QC saat ini.</p>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach($data['putaway'] as $index => $item) : ?>
                                    <tr class="fade-in-up" style="animation-delay: <?= 0.15 + ($index * 0.05); ?>s;">
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-green-light text-green rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 48px; height: 48px;">
                                                    <i class="bi bi-box-seam fs-4"></i>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-bold text-dark" style="font-size: 1.05rem;"><?= $item['komoditas']; ?></span>
                                                    <span class="d-block text-secondary small mt-1"><i class="bi bi-building me-1"></i>Pemasok: <?= $item['nama_pemasok']; ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border border-secondary border-opacity-25 px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.85rem;">
                                                <i class="bi bi-speedometer2 text-muted me-1"></i> <?= number_format($item['berat_aktual_kg'], 2, ',', '.'); ?> <span class="text-muted fw-normal">Kg</span>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-inline-flex align-items-center bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill">
                                                <i class="bi bi-calendar-x me-2 small"></i>
                                                <span class="fw-bold text-danger" style="font-size: 0.85rem;"><?= date('d M Y', strtotime($item['tanggal_kedaluwarsa'])); ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center pe-4">
                                            <a href="<?= BASEURL; ?>/admin/formPutaway/<?= $item['id_detail']; ?>" class="btn btn-outline-success rounded-pill fw-bold px-4 py-2 d-inline-flex align-items-center">
                                                <i class="bi bi-geo-alt-fill me-2"></i> Pilih Rak
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>