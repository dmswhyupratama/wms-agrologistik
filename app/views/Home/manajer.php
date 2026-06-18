<?php
    $first_name = explode(' ', trim($_SESSION['nama_lengkap']))[0];
    $hour = (int)date('H');
    if ($hour >= 5 && $hour < 12)       $salam = 'Selamat Pagi';
    elseif ($hour >= 12 && $hour < 15)  $salam = 'Selamat Siang';
    elseif ($hour >= 15 && $hour < 18)  $salam = 'Selamat Sore';
    else                                $salam = 'Selamat Malam';

    $stat = $data['statistik'];
?>

<style>
/* ===== MANAJER COMMAND CENTER STYLES ===== */

/* --- Hero Banner --- */
.mgr-hero {
    background: #ffffff;
    border-radius: 20px;
    padding: 2rem 2.25rem;
    position: relative;
    overflow: hidden;
    border: 1px solid var(--gray-200);
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.mgr-hero::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 300px; height: 100%;
    background: linear-gradient(135deg, transparent 0%, var(--green-50) 50%, rgba(22,163,74,0.08) 100%);
    pointer-events: none;
}
.mgr-hero::after {
    content: '';
    position: absolute;
    top: -60px; right: -40px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(22,163,74,0.06) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.mgr-hero .badge-role {
    background: linear-gradient(135deg, var(--green-100), #d1fae5);
    color: var(--green-800);
    border: 1px solid var(--green-200);
    font-size: 0.75rem;
    padding: 0.3rem 0.85rem;
    border-radius: 50px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    letter-spacing: 0.3px;
}
.mgr-hero .hero-greeting {
    font-size: 1.6rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
}
.mgr-hero .hero-sub {
    color: var(--gray-500);
    font-size: 0.9rem;
    margin: 0;
}
.mgr-hero .hero-date-clock {
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: 12px;
    padding: 0.6rem 1rem;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.82rem;
    color: var(--gray-600);
    font-weight: 500;
}
.mgr-hero .hero-date-clock .clock-live {
    font-weight: 700;
    color: var(--green-700);
    font-variant-numeric: tabular-nums;
}

/* --- KPI Stat Cards --- */
.kpi-card {
    background: white;
    border-radius: 18px;
    border: 1px solid var(--gray-200);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
    height: 100%;
}
.kpi-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 65%, rgba(0,0,0,0.015) 100%);
    pointer-events: none;
}
.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.08);
    border-color: var(--green-200);
}
.kpi-card .kpi-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.kpi-card .kpi-icon.icon-blue { background: #EFF6FF; color: #2563EB; }
.kpi-card .kpi-icon.icon-amber { background: #FFFBEB; color: #D97706; }
.kpi-card .kpi-icon.icon-green { background: var(--green-100); color: var(--green-700); }
.kpi-card .kpi-icon.icon-red { background: #FEF2F2; color: #DC2626; }
.kpi-card .kpi-icon.icon-emerald { background: #ECFDF5; color: #059669; }
.kpi-card .kpi-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--gray-500);
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.kpi-card .kpi-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--gray-900);
    line-height: 1;
    margin-bottom: 4px;
}
.kpi-card .kpi-value .kpi-unit {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gray-400);
    margin-left: 3px;
}
.kpi-card .kpi-sub {
    font-size: 0.76rem;
    font-weight: 500;
}
.kpi-card .kpi-sub.sub-ok { color: var(--green-600); }
.kpi-card .kpi-sub.sub-warn { color: #DC2626; }
.kpi-card .kpi-sub.sub-muted { color: var(--gray-400); }

/* --- Section Header --- */
.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}
.section-header .sh-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--gray-900);
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-header .sh-title i {
    color: var(--gray-400);
    font-size: 1.1rem;
}

/* --- Thermostat Panel --- */
.thermo-panel {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.thermo-panel .tp-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 1.15rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.thermo-panel .tp-header .tp-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.thermo-panel .tp-header .tp-icon {
    width: 40px; height: 40px;
    background: rgba(251,191,36,0.2);
    border: 1px solid rgba(251,191,36,0.3);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    color: #FBBF24;
}
.thermo-panel .tp-header h6 { color: white; font-weight: 700; margin: 0; font-size: 0.95rem; }
.thermo-panel .tp-header p { color: rgba(255,255,255,0.5); font-size: 0.75rem; margin: 0; }
.thermo-panel .tp-header .tp-badge-ok {
    background: rgba(34,197,94,0.15);
    color: #4ADE80;
    border: 1px solid rgba(34,197,94,0.25);
    font-size: 0.72rem;
    padding: 0.25rem 0.7rem;
    border-radius: 50px;
    font-weight: 600;
}
.thermo-panel .tp-header .tp-badge-warn {
    background: rgba(239,68,68,0.15);
    color: #FCA5A5;
    border: 1px solid rgba(239,68,68,0.25);
    font-size: 0.72rem;
    padding: 0.25rem 0.7rem;
    border-radius: 50px;
    font-weight: 600;
    animation: pulse-badge 2s infinite;
}
.thermo-panel .tp-body { padding: 1.5rem; }

.room-card {
    border-radius: 16px;
    padding: 1.25rem 1rem;
    text-align: center;
    border: 2px solid var(--gray-200);
    background: var(--gray-50);
    transition: all 0.2s ease;
    position: relative;
}
.room-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}
.room-card.room-ok {
    border-color: var(--green-200);
    background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);
}
.room-card.room-danger {
    border-color: #FECACA;
    background: linear-gradient(180deg, #fef2f2 0%, #ffffff 100%);
    animation: pulse-room 2.5s infinite;
}
.room-card .room-code {
    font-weight: 700;
    font-size: 0.85rem;
    margin-bottom: 6px;
    letter-spacing: 0.5px;
}
.room-card.room-ok .room-code { color: var(--green-800); }
.room-card.room-danger .room-code { color: #991B1B; }
.room-card .room-temp {
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 8px;
}
.room-card.room-ok .room-temp { color: var(--green-600); }
.room-card.room-danger .room-temp { color: #DC2626; }
.room-card .room-range {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--gray-400);
    background: white;
    border: 1px solid var(--gray-200);
    padding: 2px 8px;
    border-radius: 6px;
    display: inline-block;
    margin-bottom: 6px;
}
.room-card .room-time {
    font-size: 0.72rem;
    color: var(--gray-400);
    font-weight: 500;
}

/* --- Stock Health Panel --- */
.stock-panel {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.stock-panel .sp-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 1.15rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.stock-panel .sp-header .sp-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.stock-panel .sp-header .sp-icon {
    width: 40px; height: 40px;
    background: rgba(34,197,94,0.2);
    border: 1px solid rgba(34,197,94,0.3);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    color: #4ADE80;
}
.stock-panel .sp-header h6 { color: white; font-weight: 700; margin: 0; font-size: 0.95rem; }
.stock-panel .sp-header p { color: rgba(255,255,255,0.5); font-size: 0.75rem; margin: 0; }
.stock-panel .sp-body { padding: 1.75rem; }

.stock-gauge {
    display: flex;
    align-items: stretch;
    gap: 1.5rem;
}
.stock-gauge .sg-block {
    flex: 1;
    text-align: center;
    padding: 1.5rem 1rem;
    border-radius: 16px;
    position: relative;
}
.stock-gauge .sg-block.sg-available {
    background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);
    border: 2px solid var(--green-200);
}
.stock-gauge .sg-block.sg-quarantine {
    background: linear-gradient(180deg, #fef2f2 0%, #ffffff 100%);
    border: 2px solid #FECACA;
}
.stock-gauge .sg-block .sg-label {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}
.stock-gauge .sg-block.sg-available .sg-label { color: var(--green-700); }
.stock-gauge .sg-block.sg-quarantine .sg-label { color: #991B1B; }
.stock-gauge .sg-block .sg-value {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
}
.stock-gauge .sg-block.sg-available .sg-value { color: var(--green-700); }
.stock-gauge .sg-block.sg-quarantine .sg-value { color: #DC2626; }
.stock-gauge .sg-block .sg-unit {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gray-400);
}
.stock-gauge .sg-divider {
    width: 2px;
    background: var(--gray-200);
    border-radius: 2px;
    align-self: stretch;
    margin: 0.5rem 0;
}

.stock-bar-wrap {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gray-100);
}
.stock-bar-wrap .sbw-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--gray-500);
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
}
.stock-bar {
    height: 12px;
    background: var(--gray-100);
    border-radius: 50px;
    overflow: hidden;
    display: flex;
}
.stock-bar .sb-available {
    background: linear-gradient(90deg, var(--green-500), var(--green-400));
    border-radius: 50px 0 0 50px;
    transition: width 1s ease;
}
.stock-bar .sb-quarantine {
    background: linear-gradient(90deg, #F87171, #FCA5A5);
    transition: width 1s ease;
}
.stock-bar-legend {
    display: flex;
    gap: 1.25rem;
    margin-top: 10px;
}
.stock-bar-legend .sbl-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gray-500);
}
.stock-bar-legend .sbl-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}
.stock-bar-legend .sbl-dot.dot-green { background: var(--green-500); }
.stock-bar-legend .sbl-dot.dot-red { background: #F87171; }
.stock-bar-legend .sbl-dot.dot-gray { background: var(--gray-200); }

/* --- Quick Action Cards --- */
.qa-card {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    padding: 1.35rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}
.qa-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 60%, rgba(22,163,74,0.03) 100%);
    pointer-events: none;
}
.qa-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border-color: var(--green-200);
    color: inherit;
}
.qa-card .qa-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.qa-card .qa-icon.qi-red { background: #FEE2E2; color: #DC2626; }
.qa-card .qa-icon.qi-green { background: var(--green-100); color: var(--green-700); }
.qa-card .qa-icon.qi-blue { background: #DBEAFE; color: #2563EB; }
.qa-card .qa-icon.qi-purple { background: #EDE9FE; color: #7C3AED; }
.qa-card .qa-title { font-weight: 700; font-size: 0.9rem; color: var(--gray-900); margin-bottom: 2px; }
.qa-card .qa-sub { font-size: 0.76rem; color: var(--gray-500); }
.qa-card .qa-arrow { margin-left: auto; color: var(--gray-300); font-size: 1.1rem; transition: all 0.2s; flex-shrink: 0; }
.qa-card:hover .qa-arrow { transform: translateX(4px); color: var(--green-600); }

/* --- Alert Anomali --- */
.alert-anomali {
    background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
    border: 1px solid #FECACA;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 1.25rem;
    animation: fadeInDown 0.4s ease;
}
.alert-anomali .aa-icon {
    width: 38px; height: 38px;
    background: #DC2626;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}
.alert-anomali .aa-title { font-weight: 700; color: #991B1B; font-size: 0.88rem; margin-bottom: 2px; }
.alert-anomali .aa-desc { font-size: 0.8rem; color: #B91C1C; margin: 0; }

/* --- Empty State --- */
.empty-state-mgr {
    text-align: center;
    padding: 2.5rem 1rem;
    color: var(--gray-400);
}
.empty-state-mgr .es-icon {
    width: 64px; height: 64px;
    background: var(--gray-100);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    color: var(--gray-300);
}
.empty-state-mgr h6 { font-size: 0.9rem; font-weight: 700; color: var(--gray-600); margin-bottom: 4px; }
.empty-state-mgr p { font-size: 0.8rem; margin: 0; }

/* --- Animations --- */
@keyframes pulse-room {
    0%, 100% { box-shadow: 0 0 0 0 rgba(220,38,38,0.15); }
    50% { box-shadow: 0 0 0 8px rgba(220,38,38,0); }
}
@keyframes pulse-badge {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Staggered card animation */
.kpi-card { animation: fadeInUp 0.5s ease both; }
.kpi-card:nth-child(1) { animation-delay: 0.05s; }
.kpi-card:nth-child(2) { animation-delay: 0.1s; }
.kpi-card:nth-child(3) { animation-delay: 0.15s; }
.kpi-card:nth-child(4) { animation-delay: 0.2s; }

/* --- Responsive --- */
@media (max-width: 767.98px) {
    .mgr-hero { padding: 1.5rem; }
    .mgr-hero .hero-greeting { font-size: 1.3rem; }
    .stock-gauge { flex-direction: column; gap: 1rem; }
    .stock-gauge .sg-divider { width: 100%; height: 2px; margin: 0; }
    .stock-gauge .sg-block { padding: 1rem; }
    .stock-gauge .sg-block .sg-value { font-size: 1.5rem; }
}
</style>

<div class="container-fluid mt-4 mb-5 px-lg-4">

    <!-- ===== HERO BANNER ===== -->
    <div class="mgr-hero mb-4 animate-box">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="badge-role mb-2"><i class="bi bi-shield-check"></i> Manajer Gudang</span>
                <h2 class="hero-greeting"><?= $salam ?>, <?= $first_name ?>! 📊</h2>
                <p class="hero-sub">Pantau operasional gudang Agrologistik secara <em>real-time</em> dari satu layar.</p>
            </div>
            <div class="hero-date-clock">
                <i class="bi bi-calendar3"></i>
                <?= date('l, d F Y') ?>
                <span style="opacity:0.3;">|</span>
                <i class="bi bi-clock"></i>
                <span class="clock-live" id="mgr-live-clock"></span> WIB
            </div>
        </div>
    </div>
    <script>
        (function() {
            function tick() {
                var now = new Date();
                var h = String(now.getHours()).padStart(2, '0');
                var m = String(now.getMinutes()).padStart(2, '0');
                var s = String(now.getSeconds()).padStart(2, '0');
                var el = document.getElementById('mgr-live-clock');
                if (el) el.textContent = h + ':' + m + ':' + s;
            }
            tick();
            setInterval(tick, 1000);
        })();
    </script>

    <!-- ===== KPI STAT CARDS ===== -->
    <div class="row g-3 mb-4">

        <!-- Pesanan Aktif (Outbound) -->
        <div class="col-6 col-lg-3">
            <div class="kpi-card shadow-sm animate-box">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon icon-blue"><i class="bi bi-cart-check"></i></div>
                </div>
                <div class="kpi-label">Pesanan Aktif</div>
                <div class="kpi-value"><?= $stat['so_aktif']; ?> <span class="kpi-unit">SO</span></div>
                <div class="kpi-sub sub-muted">Sedang diproses tim</div>
            </div>
        </div>

        <!-- Antrean QC -->
        <div class="col-6 col-lg-3">
            <div class="kpi-card shadow-sm animate-box">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon <?= ($stat['antrean_qc'] > 0) ? 'icon-amber' : 'icon-emerald' ?>">
                        <i class="bi bi-clipboard-pulse"></i>
                    </div>
                </div>
                <div class="kpi-label">Antrean QC</div>
                <div class="kpi-value"><?= $stat['antrean_qc']; ?> <span class="kpi-unit">Laporan</span></div>
                <?php if($stat['antrean_qc'] > 0) : ?>
                    <div class="kpi-sub sub-warn"><i class="bi bi-exclamation-circle me-1"></i>Butuh atensi</div>
                <?php else : ?>
                    <div class="kpi-sub sub-ok"><i class="bi bi-check-circle me-1"></i>Bersih hari ini</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Stok Tersedia -->
        <div class="col-6 col-lg-3">
            <div class="kpi-card shadow-sm animate-box">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon icon-green"><i class="bi bi-box-seam"></i></div>
                </div>
                <div class="kpi-label">Stok Tersedia</div>
                <div class="kpi-value"><?= number_format($stat['stok_tersedia'], 0, ',', '.'); ?> <span class="kpi-unit">Kg</span></div>
                <div class="kpi-sub sub-ok"><i class="bi bi-check-circle me-1"></i>Layak jual</div>
            </div>
        </div>

        <!-- Stok Karantina -->
        <div class="col-6 col-lg-3">
            <div class="kpi-card shadow-sm animate-box">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="kpi-icon <?= ($stat['stok_karantina'] > 0) ? 'icon-red' : 'icon-emerald' ?>">
                        <i class="bi bi-shield-exclamation"></i>
                    </div>
                </div>
                <div class="kpi-label">Stok Karantina</div>
                <div class="kpi-value"><?= number_format($stat['stok_karantina'], 0, ',', '.'); ?> <span class="kpi-unit">Kg</span></div>
                <?php if($stat['stok_karantina'] > 0) : ?>
                    <div class="kpi-sub sub-warn"><i class="bi bi-exclamation-triangle me-1"></i>Area tertahan</div>
                <?php else : ?>
                    <div class="kpi-sub sub-ok"><i class="bi bi-check-circle me-1"></i>Tidak ada karantina</div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- ===== THERMOSTAT STATUS PANEL ===== -->
    <div class="thermo-panel shadow-sm mb-4 animate-box">
        <div class="tp-header">
            <div class="tp-left">
                <div class="tp-icon"><i class="bi bi-thermometer-high"></i></div>
                <div>
                    <h6>Status Termostat Ruangan</h6>
                    <p>Monitoring suhu terkini seluruh area penyimpanan</p>
                </div>
            </div>
            <?php if($data['suhu']['jumlah_anomali'] > 0) : ?>
                <span class="tp-badge-warn"><i class="bi bi-exclamation-triangle-fill me-1"></i><?= $data['suhu']['jumlah_anomali'] ?> Anomali</span>
            <?php else : ?>
                <span class="tp-badge-ok"><i class="bi bi-shield-check me-1"></i>Semua Normal</span>
            <?php endif; ?>
        </div>
        <div class="tp-body">
            <?php if(empty($data['suhu']['daftar_suhu'])) : ?>
                <div class="empty-state-mgr">
                    <div class="es-icon"><i class="bi bi-wind"></i></div>
                    <h6>Belum Ada Data Suhu</h6>
                    <p>Pencatatan suhu dari Kru Lapangan belum tersedia hari ini.</p>
                </div>
            <?php else : ?>

                <?php if($data['suhu']['jumlah_anomali'] > 0) : ?>
                    <div class="alert-anomali">
                        <div class="aa-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div>
                            <div class="aa-title">Peringatan Kritis!</div>
                            <p class="aa-desc">Suhu pada ruangan <strong><?= implode(', ', $data['suhu']['daftar_anomali']); ?></strong> terdeteksi di luar batas aman. Segera lakukan pengecekan fisik.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row g-3">
                    <?php foreach($data['suhu']['daftar_suhu'] as $s) : ?>
                        <?php $is_anomali = in_array($s['kode_ruangan'], $data['suhu']['daftar_anomali']); ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="room-card <?= $is_anomali ? 'room-danger' : 'room-ok' ?>">
                                <div class="room-code"><?= $s['kode_ruangan']; ?></div>
                                <div class="room-temp">
                                    <?= number_format($s['suhu_celcius'], 1, ',', '.'); ?>°C
                                </div>
                                <div class="room-range">
                                    <i class="bi bi-arrows-expand me-1"></i><?= $s['rentang_suhu']; ?>
                                </div>
                                <div class="room-time">
                                    <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($s['waktu_catat'])); ?> WIB
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <!-- ===== STOCK HEALTH PANEL ===== -->
    <?php
        $total_stok = $stat['stok_tersedia'] + $stat['stok_karantina'];
        $pct_tersedia = ($total_stok > 0) ? round(($stat['stok_tersedia'] / $total_stok) * 100, 1) : 100;
        $pct_karantina = ($total_stok > 0) ? round(($stat['stok_karantina'] / $total_stok) * 100, 1) : 0;
    ?>
    <div class="stock-panel shadow-sm mb-4 animate-box">
        <div class="sp-header">
            <div class="sp-left">
                <div class="sp-icon"><i class="bi bi-pie-chart-fill"></i></div>
                <div>
                    <h6>Kesehatan Stok Gudang</h6>
                    <p>Proporsi tonase stok layak jual vs area karantina</p>
                </div>
            </div>
            <a href="<?= BASEURL; ?>/stok" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-medium" style="font-size: 0.78rem;">
                <i class="bi bi-layers me-1"></i>Lihat Detail Rak
            </a>
        </div>
        <div class="sp-body">
            <div class="stock-gauge">
                <div class="sg-block sg-available">
                    <div class="sg-label"><i class="bi bi-check-circle me-1"></i>Stok Tersedia</div>
                    <div class="sg-value"><?= number_format($stat['stok_tersedia'], 2, ',', '.'); ?></div>
                    <div class="sg-unit">Kilogram</div>
                </div>
                <div class="sg-divider"></div>
                <div class="sg-block sg-quarantine">
                    <div class="sg-label"><i class="bi bi-shield-exclamation me-1"></i>Stok Karantina</div>
                    <div class="sg-value"><?= number_format($stat['stok_karantina'], 2, ',', '.'); ?></div>
                    <div class="sg-unit">Kilogram</div>
                </div>
            </div>

            <div class="stock-bar-wrap">
                <div class="sbw-label">
                    <span>Distribusi Stok</span>
                    <span class="fw-bold text-dark"><?= number_format($total_stok, 0, ',', '.'); ?> Kg Total</span>
                </div>
                <div class="stock-bar">
                    <div class="sb-available" style="width: <?= $pct_tersedia ?>%;"></div>
                    <div class="sb-quarantine" style="width: <?= $pct_karantina ?>%;"></div>
                </div>
                <div class="stock-bar-legend">
                    <div class="sbl-item"><span class="sbl-dot dot-green"></span> Tersedia (<?= $pct_tersedia ?>%)</div>
                    <div class="sbl-item"><span class="sbl-dot dot-red"></span> Karantina (<?= $pct_karantina ?>%)</div>
                    <?php if($total_stok <= 0) : ?>
                        <div class="sbl-item"><span class="sbl-dot dot-gray"></span> Belum ada stok</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== QUICK ACTIONS ===== -->
    <div class="section-header">
        <div class="sh-title">
            <i class="bi bi-lightning-charge-fill text-warning"></i> Akses Cepat
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <a href="<?= BASEURL; ?>/waste" class="qa-card shadow-sm animate-box">
                <div class="qa-icon qi-red"><i class="bi bi-graph-up-arrow"></i></div>
                <div>
                    <div class="qa-title">Laporan Waste</div>
                    <div class="qa-sub">Rasio penyusutan barang</div>
                </div>
                <i class="bi bi-chevron-right qa-arrow"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="<?= BASEURL; ?>/stok" class="qa-card shadow-sm animate-box">
                <div class="qa-icon qi-green"><i class="bi bi-boxes"></i></div>
                <div>
                    <div class="qa-title">Stok & Rak</div>
                    <div class="qa-sub">Lokasi & informasi stok</div>
                </div>
                <i class="bi bi-chevron-right qa-arrow"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="<?= BASEURL; ?>/outbound" class="qa-card shadow-sm animate-box">
                <div class="qa-icon qi-blue"><i class="bi bi-truck"></i></div>
                <div>
                    <div class="qa-title">Outbound</div>
                    <div class="qa-sub">Pesanan & ekspedisi</div>
                </div>
                <i class="bi bi-chevron-right qa-arrow"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="<?= BASEURL; ?>/pegawai" class="qa-card shadow-sm animate-box">
                <div class="qa-icon qi-purple"><i class="bi bi-people"></i></div>
                <div>
                    <div class="qa-title">Data Pegawai</div>
                    <div class="qa-sub">Kelola akun & akses</div>
                </div>
                <i class="bi bi-chevron-right qa-arrow"></i>
            </a>
        </div>
    </div>

</div>