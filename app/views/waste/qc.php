<style>
    .wqc-item-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: box-shadow 0.2s;
    }
    .wqc-item-card:hover { box-shadow: var(--shadow-md); }

    .wqc-info-panel {
        padding: 1.75rem;
        background: #fff;
    }

    .wqc-action-panel {
        padding: 1.75rem;
        background: var(--gray-50);
        border-left: 1px solid var(--gray-200);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .wqc-detail-row {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        padding: 0.75rem;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 10px;
    }

    .wqc-detail-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--gray-400);
    }

    .wqc-detail-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-800);
        line-height: 1.3;
    }

    .wqc-ng-box {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .wqc-recovery-input:focus {
        border-color: var(--green-500);
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.12);
    }

    @media (max-width: 767px) {
        .wqc-action-panel {
            border-left: none;
            border-top: 1px solid var(--gray-200);
        }
    }
</style>

<div class="container-fluid py-4 pb-5 px-3 px-lg-4">

    <?php Flasher::flash(); ?>

    <!-- ============================================================ -->
    <!-- PAGE HEADER                                                  -->
    <!-- ============================================================ -->
    <div class="mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-3">
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing:-0.5px;">
                    <i class="bi bi-clipboard-check-fill me-2" style="color:var(--green-600);"></i>Verifikasi Karantina
                </h4>
                <p class="mb-0" style="font-size:0.875rem;">
                    Periksa setiap item bermasalah dan tentukan berat yang dapat diselamatkan (recovery).
                </p>
            </div>
            <?php if (!empty($data['antrean'])): ?>
            <div class="flex-shrink-0">
                <div class="d-flex align-items-center gap-2 rounded-3 px-3 py-2"
                     style="background:#FEF3C7; border:1px solid #FDE68A;">
                    <i class="bi bi-hourglass-split" style="color:#D97706; font-size:1rem;"></i>
                    <div>
                        <div style="font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#92400E;">Menunggu Verifikasi</div>
                        <div style="font-size:1rem; font-weight:800; color:#92400E; line-height:1;"><?= count($data['antrean']) ?> Item</div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- EMPTY STATE                                                  -->
    <!-- ============================================================ -->
    <?php if (empty($data['antrean'])): ?>
    <div class="card-clean animate-box text-center p-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
             style="width:64px; height:64px; background:var(--green-50);">
            <i class="bi bi-check2-circle" style="font-size:1.75rem; color:var(--green-600);"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">Area Karantina Bersih</h6>
        <p class="mb-0" style="font-size:0.875rem;">Tidak ada laporan barang bermasalah dari Kru Lapangan saat ini.</p>
    </div>

    <?php else: ?>

    <!-- ============================================================ -->
    <!-- ITEM LIST                                                    -->
    <!-- ============================================================ -->
    <div class="d-flex flex-column gap-3">
        <?php foreach ($data['antrean'] as $i => $item): ?>

        <div class="wqc-item-card animate-box" style="animation-delay:<?= $i * 0.06 ?>s;">
            <div class="row g-0">

                <!-- ================================================ -->
                <!-- LEFT: Info Panel                                  -->
                <!-- ================================================ -->
                <div class="col-md-8">
                    <div class="wqc-info-panel">

                        <!-- Top Row: Index + Komoditas + Berat -->
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-2 fw-black flex-shrink-0"
                                 style="width:36px; height:36px; background:#FEF2F2; color:#DC2626; font-size:0.9rem; font-weight:900;">
                                <?= $i + 1 ?>
                            </div>
                            <div class="flex-grow-1">
                                <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--gray-400);">Komoditas Karantina</div>
                                <h5 class="fw-bold text-dark mb-0" style="letter-spacing:-0.3px;"><?= htmlspecialchars($item['komoditas']) ?></h5>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <div style="font-size:1.5rem; font-weight:800; color:#DC2626; letter-spacing:-1px; line-height:1;"><?= number_format($item['berat_susut_kg'], 2, ',', '.') ?></div>
                                <div style="font-size:0.72rem; font-weight:600; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.5px;">Kg Bermasalah</div>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="row g-2 mb-3">
                            <div class="col-sm-4">
                                <div class="wqc-detail-row">
                                    <span class="wqc-detail-label"><i class="bi bi-upc-scan me-1"></i>SKU</span>
                                    <span class="wqc-detail-value" style="font-family:'Courier New',monospace; font-size:0.8rem; letter-spacing:0.5px;"><?= htmlspecialchars($item['kode_sku']) ?></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="wqc-detail-row">
                                    <span class="wqc-detail-label"><i class="bi bi-geo-alt me-1"></i>Lokasi Rak</span>
                                    <span class="wqc-detail-value"><?= htmlspecialchars($item['lokasi_rak']) ?></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="wqc-detail-row">
                                    <span class="wqc-detail-label"><i class="bi bi-person me-1"></i>Pelapor</span>
                                    <span class="wqc-detail-value">
                                        <?= htmlspecialchars(explode(' ', trim($item['pelapor']))[0]) ?>
                                        <span class="fw-normal" style="color:var(--gray-400); font-size:0.78rem;">(<?= date('H:i', strtotime($item['waktu_catat'])) ?> WIB)</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Alasan NG -->
                        <div class="wqc-ng-box">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-exclamation-triangle-fill" style="color:#DC2626; font-size:0.8rem;"></i>
                                <span style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#991B1B;">Alasan Penolakan (NG)</span>
                            </div>
                            <p class="mb-0 fw-semibold" style="font-size:0.875rem; color:#991B1B;"><?= htmlspecialchars($item['keterangan_ng']) ?></p>
                        </div>

                    </div>
                </div>

                <!-- ================================================ -->
                <!-- RIGHT: Action Panel                               -->
                <!-- ================================================ -->
                <div class="col-md-4">
                    <div class="wqc-action-panel h-100">

                        <form action="<?= BASEURL ?>/waste/evaluasiQC" method="POST">
                            <input type="hidden" name="id_waste"   value="<?= $item['id_waste'] ?>">
                            <input type="hidden" name="id_stok"    value="<?= $item['id_stok'] ?>">
                            <input type="hidden" name="berat_total" value="<?= $item['berat_susut_kg'] ?>">

                            <!-- Title -->
                            <div class="mb-3">
                                <h6 class="fw-bold text-dark mb-0" style="font-size:0.9rem;">
                                    <i class="bi bi-arrow-counterclockwise me-1" style="color:var(--green-600);"></i>
                                    Putuskan Recovery
                                </h6>
                                <p class="mb-0 mt-1" style="font-size:0.78rem; color:var(--gray-500);">Masukkan berat yang dapat diselamatkan.</p>
                            </div>

                            <!-- Recovery Input -->
                            <label class="fw-semibold mb-1" style="font-size:0.8rem; color:var(--gray-600);">
                                Berat Recovery
                                <span class="fw-normal" style="color:var(--gray-400);">/ maks. <?= number_format($item['berat_susut_kg'], 2, ',', '.') ?> Kg</span>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group mb-2">
                                <input type="number" step="0.01"
                                       max="<?= $item['berat_susut_kg'] ?>"
                                       class="form-control fw-bold wqc-recovery-input"
                                       name="berat_recovery"
                                       value="0" required
                                       style="border-color:var(--gray-300); border-radius:10px 0 0 10px; font-size:1rem;">
                                <span class="input-group-text fw-bold"
                                      style="background:var(--green-100); color:var(--green-700); border-color:var(--gray-300); border-radius:0 10px 10px 0;">Kg</span>
                            </div>
                            <p class="mb-4" style="font-size:0.75rem; color:var(--gray-400); line-height:1.4;">
                                <i class="bi bi-info-circle me-1"></i>
                                Sisa berat dianggap limbah. Isi <strong>0</strong> jika semua dibuang.
                            </p>

                            <!-- Submit -->
                            <button type="submit"
                                    class="btn-green w-100 d-flex align-items-center justify-content-center gap-2"
                                    style="border-radius:10px; padding:0.7rem 1rem; font-size:0.875rem; border:none; cursor:pointer;"
                                    onclick="return confirm('Kunci keputusan ini? Barang yang selamat akan dikembalikan ke stok rak.');">
                                <i class="bi bi-lock-fill" style="font-size:0.85rem;"></i>
                                Kunci &amp; Selesaikan
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>

        <?php endforeach; ?>
    </div>

    <?php endif; ?>

</div>
