<div class="container-fluid py-4 pb-5 px-3 px-lg-4">

    <?php Flasher::flash(); ?>

    <!-- ============================================================ -->
    <!-- PAGE HEADER                                                  -->
    <!-- ============================================================ -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1" style="letter-spacing:-0.5px;">
                <i class="bi bi-clipboard-check me-2" style="color:var(--green-600);"></i>Antrean Inspeksi QC
            </h4>
            <p class="mb-0" style="font-size:0.875rem;">Daftar armada truk yang menunggu pemeriksaan fisik di Loading Dock.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <span class="badge-soft badge-soft-<?= empty($data['asn']) ? 'secondary' : 'success' ?> px-3 py-2" style="font-size:0.8rem; border-radius:8px;">
                <i class="bi bi-truck me-1"></i>
                <?= count($data['asn'] ?? []) ?> Truk Menunggu
            </span>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ANTREAN TRUK                                                 -->
    <!-- ============================================================ -->
    <div class="row g-3 mb-5">
        <?php if (empty($data['asn'])): ?>
            <div class="col-12">
                <div class="card-clean p-5 text-center animate-box">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width:64px; height:64px; background:var(--green-50);">
                        <i class="bi bi-check2-circle" style="font-size:1.75rem; color:var(--green-600);"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Antrean Bersih</h6>
                    <p class="mb-0" style="font-size:0.875rem;">Tidak ada truk yang menunggu inspeksi saat ini.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($data['asn'] as $asn): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card-clean animate-box hover-elevate h-100 p-4" style="border-left:4px solid var(--green-500);">

                    <!-- Card Top -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge-soft badge-soft-info mb-2 d-inline-block" style="font-size:0.75rem; border-radius:6px; padding:0.3em 0.75em;">
                                <i class="bi bi-truck me-1"></i> Truk Tiba
                            </span>
                            <h6 class="fw-bold text-dark mb-0" style="font-size:1rem;"><?= htmlspecialchars($asn['nama_pemasok']) ?></h6>
                        </div>
                        <div class="text-end flex-shrink-0 ms-2">
                            <div class="fw-bold text-dark" style="font-size:1rem; letter-spacing:-0.5px;">
                                <?= date('H:i', strtotime($asn['waktu_rencana_tiba'])) ?>
                            </div>
                            <div class="text-muted" style="font-size:0.72rem; font-weight:600;">WIB</div>
                        </div>
                    </div>

                    <!-- Komoditas -->
                    <div class="d-flex align-items-start gap-2 mb-4 p-2 rounded-3" style="background:var(--gray-50); border:1px solid var(--gray-200);">
                        <i class="bi bi-box-seam mt-1 flex-shrink-0" style="color:var(--gray-400); font-size:0.85rem;"></i>
                        <span style="font-size:0.85rem; color:var(--gray-600); line-height:1.4;"><?= htmlspecialchars($asn['daftar_komoditas']) ?></span>
                    </div>

                    <!-- CTA -->
                    <a href="<?= BASEURL ?>/qc/inspeksi/<?= $asn['id_asn'] ?>"
                       class="btn-green d-flex align-items-center justify-content-center gap-2 text-decoration-none mt-auto"
                       style="border-radius:var(--radius-md); padding:0.65rem 1rem; font-size:0.9rem;">
                        <i class="bi bi-search"></i>
                        Mulai Inspeksi
                    </a>

                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ============================================================ -->
    <!-- RIWAYAT INSPEKSI                                             -->
    <!-- ============================================================ -->
    <div class="card-clean animate-box p-4" style="animation-delay:0.1s;">

        <!-- Section Header -->
        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--gray-200);">
            <div class="stat-icon" style="background:var(--gray-100); color:var(--gray-600); flex-shrink:0;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-0">Riwayat Inspeksi</h5>
                <p class="mb-0" style="font-size:0.85rem;">Log semua hasil pemeriksaan mutu yang telah selesai diproses.</p>
            </div>
        </div>

        <?php if (empty($data['riwayat'])): ?>
            <!-- EMPTY STATE -->
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox d-block mb-2" style="font-size:1.75rem;"></i>
                <span style="font-size:0.875rem;">Belum ada riwayat inspeksi.</span>
            </div>

        <?php else: ?>

            <!-- ================================================ -->
            <!-- DESKTOP: Tabel (md ke atas)                      -->
            <!-- ================================================ -->
            <div class="d-none d-md-block table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Jadwal / Waktu</th>
                            <th>Pemasok</th>
                            <th>Komoditas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['riwayat'] as $r): ?>
                        <tr>
                            <td>
                                <span style="font-size:0.82rem;"><?= date('d M Y', strtotime($r['waktu_rencana_tiba'])) ?></span><br>
                                <small class="text-muted"><?= date('H:i', strtotime($r['waktu_rencana_tiba'])) ?> WIB</small>
                            </td>
                            <td class="fw-semibold text-dark"><?= htmlspecialchars($r['nama_pemasok']) ?></td>
                            <td style="font-size:0.875rem;"><?= htmlspecialchars($r['daftar_komoditas']) ?></td>
                            <td>
                                <?php if ($r['status_jadwal'] == 'siap_putaway'): ?>
                                    <span class="badge-soft badge-soft-success" style="font-size:0.78rem; border-radius:6px; padding:0.3em 0.75em;">
                                        <i class="bi bi-check-circle me-1"></i> Lolos QC
                                    </span>
                                <?php elseif ($r['status_jadwal'] == 'ada_retur'): ?>
                                    <span class="badge-soft badge-soft-danger" style="font-size:0.78rem; border-radius:6px; padding:0.3em 0.75em;">
                                        <i class="bi bi-x-circle me-1"></i> Ada Retur
                                    </span>
                                <?php else: ?>
                                    <span class="badge-soft badge-soft-secondary" style="font-size:0.78rem; border-radius:6px; padding:0.3em 0.75em;">
                                        <i class="bi bi-archive me-1"></i> In-Storage
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ================================================ -->
            <!-- MOBILE: Card List (di bawah md)                  -->
            <!-- ================================================ -->
            <div class="d-flex d-md-none flex-column gap-2">
                <?php foreach ($data['riwayat'] as $r): ?>
                <div class="rounded-3 p-3" style="background:var(--gray-50); border:1px solid var(--gray-200);">

                    <!-- Row 1: Pemasok + Status -->
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <span class="fw-bold text-dark" style="font-size:0.9rem; line-height:1.3;">
                            <?= htmlspecialchars($r['nama_pemasok']) ?>
                        </span>
                        <?php if ($r['status_jadwal'] == 'siap_putaway'): ?>
                            <span class="badge-soft badge-soft-success flex-shrink-0" style="font-size:0.72rem; border-radius:6px; padding:0.25em 0.65em;">
                                <i class="bi bi-check-circle me-1"></i>Lolos QC
                            </span>
                        <?php elseif ($r['status_jadwal'] == 'ada_retur'): ?>
                            <span class="badge-soft badge-soft-danger flex-shrink-0" style="font-size:0.72rem; border-radius:6px; padding:0.25em 0.65em;">
                                <i class="bi bi-x-circle me-1"></i>Ada Retur
                            </span>
                        <?php else: ?>
                            <span class="badge-soft badge-soft-secondary flex-shrink-0" style="font-size:0.72rem; border-radius:6px; padding:0.25em 0.65em;">
                                <i class="bi bi-archive me-1"></i>In-Storage
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Row 2: Komoditas -->
                    <div class="d-flex align-items-start gap-1 mb-2">
                        <i class="bi bi-box-seam flex-shrink-0 mt-1" style="font-size:0.72rem; color:var(--gray-400);"></i>
                        <span style="font-size:0.8rem; color:var(--gray-600); line-height:1.4;">
                            <?= htmlspecialchars($r['daftar_komoditas']) ?>
                        </span>
                    </div>

                    <!-- Row 3: Tanggal -->
                    <div class="d-flex align-items-center gap-1" style="color:var(--gray-400);">
                        <i class="bi bi-calendar3" style="font-size:0.72rem;"></i>
                        <span style="font-size:0.75rem;">
                            <?= date('d M Y', strtotime($r['waktu_rencana_tiba'])) ?>
                            &bull;
                            <?= date('H:i', strtotime($r['waktu_rencana_tiba'])) ?> WIB
                        </span>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>

</div>
