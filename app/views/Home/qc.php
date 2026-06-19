<?php
// Deteksi greeting berdasarkan jam
$hour = (int) date('G');
if ($hour >= 5 && $hour < 12) {
    $greeting = 'Selamat Pagi';
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = 'Selamat Siang';
} elseif ($hour >= 17 && $hour < 20) {
    $greeting = 'Selamat Sore';
} else {
    $greeting = 'Selamat Malam';
}

$nama_depan    = explode(' ', trim($_SESSION['nama_lengkap']))[0];
$inbound_count = (int) $data['statistik']['inbound_qc'];
$waste_count   = (int) $data['statistik']['waste_qc'];

// Tanggal dalam bahasa Indonesia
$hari_id  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan_id = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tgl_display = $hari_id[date('w')] . ', ' . date('j') . ' ' . $bulan_id[(int)date('n')] . ' ' . date('Y');
?>

<div class="container-fluid py-4 pb-5 px-3 px-lg-4">

    <!-- ============================================================ -->
    <!-- HEADER SECTION                                               -->
    <!-- ============================================================ -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-green animate-box p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <div>
                        <p class="mb-1 text-white" style="font-size:0.8rem; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; opacity:0.8;">
                            <i class="bi bi-shield-check me-1"></i> Quality Control Panel
                        </p>
                        <h1 class="fw-bold text-white mb-1" style="font-size:1.6rem; letter-spacing:-0.5px;">
                            <?= $greeting ?>, <?= htmlspecialchars($nama_depan) ?>!
                        </h1>
                        <p class="mb-0 text-white" style="opacity:0.75; font-size:0.9rem;">
                            Pantau antrean inspeksi dan kelola verifikasi retur secara real-time.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-white bg-opacity-10 rounded-3 px-3 py-2 text-white d-inline-flex align-items-center gap-2"
                             style="border:1px solid rgba(255,255,255,0.2); font-size:0.9rem; font-weight:600; white-space:nowrap;">
                            <i class="bi bi-calendar3" style="opacity:0.8;"></i>
                            <?= $tgl_display ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- KPI CARDS                                                    -->
    <!-- ============================================================ -->
    <div class="row g-3 mb-4">

        <!-- Card 1: Inbound Inspection Queue -->
        <div class="col-md-6">
            <div class="card-clean animate-box hover-elevate h-100 p-4" style="animation-delay:0.05s;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 text-muted" style="font-size:0.72rem; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            Antrean Inbound
                        </p>
                        <h5 class="fw-bold text-dark mb-0">Inspeksi Mutu</h5>
                    </div>
                    <div class="stat-icon stat-icon-green">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                </div>

                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <span class="fw-bold text-dark" style="font-size:2.25rem; letter-spacing:-1px; line-height:1;"><?= $inbound_count ?></span>
                    <span class="text-muted fw-semibold" style="font-size:0.9rem;">Batch Menunggu</span>
                </div>

                <?php if ($inbound_count > 0): ?>
                    <p class="mb-4" style="font-size:0.82rem; color:var(--green-700);">
                        <i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i>
                        Ada <?= $inbound_count ?> batch siap diinspeksi
                    </p>
                <?php else: ?>
                    <p class="mb-4" style="font-size:0.82rem; color:var(--gray-400);">
                        <i class="bi bi-check-circle me-1"></i>
                        Tidak ada antrean saat ini
                    </p>
                <?php endif; ?>

                <a href="<?= BASEURL ?>/qc"
                   class="btn-green d-flex align-items-center justify-content-center gap-2 text-decoration-none"
                   style="border-radius:var(--radius-md); padding:0.65rem 1rem; font-size:0.9rem;">
                    <i class="bi bi-play-circle"></i>
                    Mulai Inspeksi
                </a>
            </div>
        </div>

        <!-- Card 2: Waste Verification -->
        <div class="col-md-6">
            <?php $waste_alert = $waste_count > 0; ?>
            <div class="card-clean animate-box hover-elevate h-100 p-4"
                 style="animation-delay:0.1s; <?= $waste_alert ? 'border-color:#FCD34D;' : '' ?>">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-1 text-muted" style="font-size:0.72rem; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            Verifikasi Retur
                        </p>
                        <h5 class="fw-bold text-dark mb-0">Laporan Waste</h5>
                    </div>
                    <div class="stat-icon"
                         style="<?= $waste_alert ? 'background:#FEF3C7; color:#D97706;' : 'background:var(--gray-100); color:var(--gray-500);' ?>">
                        <i class="bi bi-<?= $waste_alert ? 'exclamation-triangle' : 'archive' ?>"></i>
                    </div>
                </div>

                <div class="d-flex align-items-baseline gap-2 mb-1">
                    <span class="fw-bold <?= $waste_alert ? '' : 'text-dark' ?>"
                          style="font-size:2.25rem; letter-spacing:-1px; line-height:1; <?= $waste_alert ? 'color:#D97706;' : '' ?>">
                        <?= $waste_count ?>
                    </span>
                    <span class="text-muted fw-semibold" style="font-size:0.9rem;">Dokumen Laporan</span>
                </div>

                <?php if ($waste_alert): ?>
                    <p class="mb-4" style="font-size:0.82rem; color:#D97706;">
                        <i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i>
                        <?= $waste_count ?> laporan menunggu verifikasi
                    </p>
                <?php else: ?>
                    <p class="mb-4" style="font-size:0.82rem; color:var(--gray-400);">
                        <i class="bi bi-check-circle me-1"></i>
                        Tidak ada laporan menunggu
                    </p>
                <?php endif; ?>

                <a href="<?= BASEURL ?>/waste"
                   class="d-flex align-items-center justify-content-center gap-2 text-decoration-none fw-semibold"
                   style="border-radius:var(--radius-md); padding:0.65rem 1rem; font-size:0.9rem;
                          <?= $waste_alert
                              ? 'background:#F59E0B; color:white; box-shadow:0 2px 6px rgba(245,158,11,.3);'
                              : 'background:var(--gray-100); color:var(--gray-600); border:1px solid var(--gray-200);'
                          ?>">
                    <?php if ($waste_alert): ?>
                        <i class="bi bi-check2-square"></i> Verifikasi Sekarang
                    <?php else: ?>
                        <i class="bi bi-clock-history"></i> Lihat Riwayat
                    <?php endif; ?>
                </a>
            </div>
        </div>

    </div>

    <!-- ============================================================ -->
    <!-- SOP PANEL — 4 STEP HORIZONTAL CARDS                         -->
    <!-- ============================================================ -->
    <div class="row">
        <div class="col-12">
            <div class="card-clean animate-box p-4" style="animation-delay:0.15s;">

                <!-- Panel Header -->
                <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--gray-200);">
                    <div class="stat-icon" style="background:#DBEAFE; color:#2563EB; flex-shrink:0;">
                        <i class="bi bi-list-ol"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Standard Operating Procedure</h5>
                        <p class="mb-0" style="font-size:0.85rem;">4 tahapan wajib inspeksi mutu komoditas inbound.</p>
                    </div>
                </div>

                <!-- Step Cards -->
                <div class="row g-3">

                    <!-- Step 1 -->
                    <div class="col-6 col-md-3">
                        <div class="rounded-3 h-100 p-3" style="background:var(--gray-50); border:1px solid var(--gray-200);">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-3"
                                 style="width:32px; height:32px; background:#DBEAFE; color:#2563EB; font-size:0.85rem; font-weight:800;">
                                1
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:0.9rem;">Ambil Sampel</h6>
                            <p class="mb-0" style="font-size:0.8rem; color:var(--gray-500); line-height:1.5;">
                                Ambil sampel acak dari beberapa karung/krat di truk inbound.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="col-6 col-md-3">
                        <div class="rounded-3 h-100 p-3" style="background:var(--gray-50); border:1px solid var(--gray-200);">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-3"
                                 style="width:32px; height:32px; background:#FEF3C7; color:#D97706; font-size:0.85rem; font-weight:800;">
                                2
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:0.9rem;">Uji Kualitas</h6>
                            <p class="mb-0" style="font-size:0.8rem; color:var(--gray-500); line-height:1.5;">
                                Cek kadar air, cacat fisik, jamur, dan pembusukan. Pisahkan yang tidak layak.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="col-6 col-md-3">
                        <div class="rounded-3 h-100 p-3" style="background:var(--gray-50); border:1px solid var(--gray-200);">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-3"
                                 style="width:32px; height:32px; background:var(--green-100); color:var(--green-700); font-size:0.85rem; font-weight:800;">
                                3
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:0.9rem;">Input Sistem</h6>
                            <p class="mb-0" style="font-size:0.8rem; color:var(--gray-500); line-height:1.5;">
                                Masukkan total Kg yang Lolos Mutu dan laporkan Reject ke sistem.
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="col-6 col-md-3">
                        <div class="rounded-3 h-100 p-3" style="background:var(--gray-50); border:1px solid var(--gray-200);">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-3"
                                 style="width:32px; height:32px; background:#D1FAE5; color:#059669; font-size:0.85rem; font-weight:800;">
                                4
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:0.9rem;">Finalisasi</h6>
                            <p class="mb-0" style="font-size:0.8rem; color:var(--gray-500); line-height:1.5;">
                                Barang lolos masuk ke antrean Putaway, Reject masuk ke Retur Pemasok.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
