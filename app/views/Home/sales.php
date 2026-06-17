<style>
    /* === SALES DASHBOARD LOCAL STYLES === */
    .sales-hero-greeting {
        background: linear-gradient(135deg, var(--green-900) 0%, var(--green-700) 60%, var(--green-500) 100%);
        border-radius: var(--radius-xl);
        padding: 2rem 2.25rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-green);
    }

    .sales-hero-greeting::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .sales-hero-greeting::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: 120px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.95);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px;
        padding: 0.3rem 0.85rem;
        backdrop-filter: blur(4px);
        margin-bottom: 0.75rem;
    }

    .hero-date {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.8);
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 50px;
        padding: 0.3rem 0.85rem;
    }

    .hero-icon-wrap {
        width: 72px;
        height: 72px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
        backdrop-filter: blur(4px);
    }

    /* Stat Cards */
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.4rem 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: box-shadow 0.25s ease, transform 0.25s ease;
        height: 100%;
        cursor: default;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-radius: 4px 0 0 4px;
        background: var(--stat-accent, var(--green-400));
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-4px);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card-today::before { --stat-accent: var(--green-500); }
    .stat-card-pending::before { --stat-accent: #F59E0B; }
    .stat-card-done::before { --stat-accent: #10B981; }

    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.04em;
        color: var(--text-primary);
    }

    .stat-label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-secondary);
    }

    .stat-sub {
        font-size: 0.7rem;
        color: var(--gray-400);
        margin-top: 0.15rem;
    }

    /* CTA Card */
    .cta-card {
        background: linear-gradient(145deg, var(--green-800) 0%, var(--green-600) 50%, var(--green-500) 100%);
        border-radius: var(--radius-xl);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-green);
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: box-shadow 0.25s ease, transform 0.25s ease;
    }

    .cta-card:hover {
        box-shadow: 0 12px 30px rgba(22, 163, 74, .35);
        transform: translateY(-3px);
    }

    .cta-card::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 65%);
        border-radius: 50%;
    }

    .cta-card::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -20px;
        width: 130px;
        height: 130px;
        background: radial-gradient(circle, rgba(0,0,0,0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .cta-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 1.25rem;
    }

    .btn-cta {
        background: rgba(255,255,255,0.95);
        color: var(--green-800);
        font-weight: 700;
        border: none;
        border-radius: 50px;
        padding: 0.7rem 1.75rem;
        font-size: 0.9rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        margin-top: 1.25rem;
    }

    .btn-cta:hover {
        background: white;
        color: var(--green-900);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        transform: translateY(-2px);
    }

    /* Table Card */
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .table-card-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--gray-50);
    }

    .table-card-header h6 {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        color: var(--text-primary);
        margin: 0;
    }

    .stok-rank-num {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 800;
        flex-shrink: 0;
        background: var(--green-100);
        color: var(--green-700);
    }

    .stok-rank-num.rank-1 { background: #FEF9C3; color: #854D0E; }
    .stok-rank-num.rank-2 { background: var(--gray-100); color: var(--gray-600); }
    .stok-rank-num.rank-3 { background: #FFEDD5; color: #9A3412; }

    .stok-bar-wrap {
        width: 100%;
        height: 4px;
        background: var(--gray-100);
        border-radius: 50px;
        margin-top: 0.35rem;
        overflow: hidden;
    }

    .stok-bar {
        height: 100%;
        border-radius: 50px;
        background: linear-gradient(90deg, var(--green-500), var(--green-400));
        transition: width 0.8s ease;
    }

    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--gray-400);
    }

    .empty-state i {
        font-size: 3rem;
        opacity: 0.4;
        display: block;
        margin-bottom: 0.75rem;
    }
</style>

<div class="container-fluid py-4 pb-5">

    <!-- ====== HERO GREETING BANNER ====== -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="sales-hero-greeting">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 position-relative" style="z-index: 1;">
                    <div>
                        <div class="hero-badge">
                            <i class="bi bi-person-badge-fill"></i> Admin Penjualan
                        </div>
                        <h2 class="fw-bold mb-1" style="font-size:1.65rem; color:white; letter-spacing:-0.04em;">
                            Halo, <?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?>! 👋
                        </h2>
                        <p class="mb-0" style="color:rgba(255,255,255,0.75); font-size:0.9rem;">
                            Pantau performa pesanan dan ketersediaan stok untuk klien hari ini.
                        </p>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-2">
                        <div class="hero-date">
                            <i class="bi bi-calendar3"></i>
                            <?= date('l, d F Y'); ?>
                        </div>
                        <div class="hero-icon-wrap">
                            <i class="bi bi-graph-up-arrow" style="color: rgba(255,255,255,0.9);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== STAT CARDS ====== -->
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-lg-4">
            <div class="stat-card stat-card-today">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-label">Pesanan Masuk<br><span class="stat-sub">Hari ini</span></div>
                    <div class="stat-icon-wrap" style="background:var(--green-100); color:var(--green-700);">
                        <i class="bi bi-cart-plus-fill"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="stat-number"><?= $data['statistik']['so_hari_ini']; ?></span>
                    <span style="font-size:0.8rem; color:var(--gray-400); font-weight:500;">Dokumen SO</span>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="stat-card stat-card-pending">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-label">Menunggu Diproses<br><span class="stat-sub">Perlu tindak lanjut</span></div>
                    <div class="stat-icon-wrap" style="background:#FEF3C7; color:#D97706;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="stat-number"><?= $data['statistik']['so_gantung']; ?></span>
                    <span style="font-size:0.8rem; color:var(--gray-400); font-weight:500;">Dokumen SO</span>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="stat-card stat-card-done">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-label">Sukses Terkirim<br><span class="stat-sub">Hari ini</span></div>
                    <div class="stat-icon-wrap" style="background:#D1FAE5; color:#059669;">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="stat-number"><?= $data['statistik']['so_selesai']; ?></span>
                    <span style="font-size:0.8rem; color:var(--gray-400); font-weight:500;">Dokumen SO</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ====== CTA + TABEL ====== -->
    <div class="row g-3">

        <!-- CTA Card -->
        <div class="col-md-5 col-lg-4">
            <div class="cta-card">
                <div class="cta-icon">
                    <i class="bi bi-cart-check-fill" style="color:rgba(255,255,255,0.95);"></i>
                </div>
                <h5 class="fw-bold mb-1" style="color:white; letter-spacing:-0.02em;">Input Pesanan Klien Baru</h5>
                <p style="color:rgba(255,255,255,0.75); font-size:0.85rem; margin-bottom:0; line-height:1.6;">
                    Buat Sales Order (SO) baru dan teruskan langsung ke antrean Kru Gudang untuk segera diproses.
                </p>
                <a href="<?= BASEURL; ?>/penjualan" class="btn-cta">
                    <i class="bi bi-plus-circle-fill"></i>
                    Buat Pesanan Sekarang
                </a>
            </div>
        </div>

        <!-- Tabel Top Stok -->
        <div class="col-md-7 col-lg-8">
            <div class="table-card">
                <div class="table-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="stat-icon-wrap" style="width:36px;height:36px;background:var(--green-100);color:var(--green-700);font-size:1rem;">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <div>
                            <h6>Top 5 Komoditas Tersedia</h6>
                            <p class="mb-0" style="font-size:0.7rem;color:var(--gray-400);font-weight:500;">Berdasarkan total stok layak jual saat ini</p>
                        </div>
                    </div>
                    <a href="<?= BASEURL; ?>/penjualan" class="btn btn-sm btn-green rounded-pill px-3" style="font-size:0.78rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i>Buat SO
                    </a>
                </div>

                <div class="flex-grow-1" style="overflow:auto;">
                    <?php if(empty($data['top_stok'])) : ?>
                        <div class="empty-state">
                            <i class="bi bi-archive"></i>
                            <p class="fw-semibold mb-1" style="color:var(--gray-500);">Belum Ada Stok</p>
                            <p style="font-size:0.82rem;">Tidak ada barang layak jual di gudang saat ini.</p>
                        </div>
                    <?php else : ?>
                        <?php
                            // Hitung nilai max untuk progress bar relatif
                            $max_berat = max(array_column($data['top_stok'], 'total_berat'));
                        ?>
                        <div class="p-3 d-flex flex-column gap-2">
                            <?php foreach($data['top_stok'] as $index => $stok) : ?>
                                <?php
                                    $rank = $index + 1;
                                    $pct  = ($max_berat > 0) ? round(($stok['total_berat'] / $max_berat) * 100) : 0;
                                ?>
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:var(--gray-50); transition:background 0.15s;" onmouseover="this.style.background='var(--green-50)'" onmouseout="this.style.background='var(--gray-50)'">
                                    <div class="stok-rank-num rank-<?= $rank ?>">
                                        <?= $rank ?>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex justify-content-between align-items-baseline mb-1">
                                            <span class="fw-bold text-truncate" style="font-size:0.875rem; color:var(--text-primary);">
                                                <?= htmlspecialchars($stok['komoditas']); ?>
                                            </span>
                                            <span class="fw-bold ms-3 flex-shrink-0" style="font-size:0.95rem; color:var(--green-700);">
                                                <?= number_format($stok['total_berat'], 2, ',', '.'); ?>
                                                <span style="font-size:0.7rem; font-weight:500; color:var(--gray-400);">Kg</span>
                                            </span>
                                        </div>
                                        <div class="stok-bar-wrap">
                                            <div class="stok-bar" style="width:<?= $pct ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>