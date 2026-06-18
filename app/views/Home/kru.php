<?php
    $first_name = explode(' ', trim($_SESSION['nama_lengkap']))[0];
    $hour = (int)date('H');
    if ($hour >= 5 && $hour < 12)       $salam = 'Selamat Pagi';
    elseif ($hour >= 12 && $hour < 15)  $salam = 'Selamat Siang';
    elseif ($hour >= 15 && $hour < 18)  $salam = 'Selamat Sore';
    else                                $salam = 'Selamat Malam';
    $tugas = (int)$data['tugas_picking'];
?>

<style>
/* ===== KRU DASHBOARD STYLES ===== */
.kru-hero {
    background: #ffffff;
    border-radius: 20px;
    padding: 2rem 2.25rem;
    position: relative;
    overflow: hidden;
    border: 1px solid var(--gray-200);
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.kru-hero::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 260px; height: 100%;
    background: linear-gradient(135deg, transparent 0%, var(--green-50) 100%);
    pointer-events: none;
}
.kru-hero .badge-role {
    background: var(--green-100);
    color: var(--green-800);
    border: 1px solid var(--green-200);
    font-size: 0.75rem;
    padding: 0.3rem 0.75rem;
    border-radius: 50px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.kru-hero .stat-chip {
    border-radius: 14px;
    padding: 0.85rem 1.25rem;
    text-align: center;
    min-width: 110px;
    transition: transform 0.15s, box-shadow 0.15s;
}
.kru-hero .stat-chip:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.kru-hero .stat-chip.chip-picking {
    background: var(--green-100);
    border: 1px solid var(--green-200);
}
.kru-hero .stat-chip.chip-picking .stat-num  { color: var(--green-800); }
.kru-hero .stat-chip.chip-picking .stat-label { color: var(--green-700); }
.kru-hero .stat-chip.chip-log {
    background: #EFF6FF;
    border: 1px solid #BFDBFE;
}
.kru-hero .stat-chip.chip-log .stat-num  { color: #1D4ED8; }
.kru-hero .stat-chip.chip-log .stat-label { color: #2563EB; }
.kru-hero .stat-chip.alert-chip {
    background: #FEF2F2;
    border: 1px solid #FECACA;
}
.kru-hero .stat-chip.alert-chip .stat-num  { color: #991B1B; }
.kru-hero .stat-chip.alert-chip .stat-label { color: #DC2626; }
.kru-hero .stat-chip .stat-num {
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1;
}
.kru-hero .stat-chip .stat-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 5px;
}

.action-card {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.1rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}
.action-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 60%, rgba(22,163,74,0.04) 100%);
}
.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--green-200);
    color: inherit;
}
.action-card .ac-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.action-card .ac-icon.green { background: var(--green-100); color: var(--green-700); }
.action-card .ac-icon.blue  { background: #DBEAFE; color: #2563EB; }
.action-card .ac-title { font-weight: 700; font-size: 0.95rem; color: var(--gray-900); margin-bottom: 2px; }
.action-card .ac-sub   { font-size: 0.78rem; color: var(--gray-500); }
.action-card .ac-arrow { margin-left: auto; color: var(--gray-300); font-size: 1.1rem; transition: transform 0.2s; }
.action-card:hover .ac-arrow { transform: translateX(4px); color: var(--green-600); }

.temp-card {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
}
.temp-card .tc-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.temp-card .tc-header .tc-icon-wrap {
    width: 40px; height: 40px;
    background: rgba(251,191,36,0.2);
    border: 1px solid rgba(251,191,36,0.3);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    color: #FBBF24;
}
.temp-card .tc-header h6 { color: white; font-weight: 700; margin: 0; font-size: 0.95rem; }
.temp-card .tc-header p  { color: rgba(255,255,255,0.55); font-size: 0.75rem; margin: 0; }
.temp-card .tc-body { padding: 1.5rem; }

.temp-input-wrap {
    background: var(--gray-50);
    border: 2px solid var(--gray-200);
    border-radius: 14px;
    display: flex; align-items: center;
    overflow: hidden;
    transition: border-color 0.2s;
}
.temp-input-wrap:focus-within { border-color: var(--green-500); }
.temp-input-wrap input {
    border: none; background: transparent;
    text-align: center;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--gray-900);
    flex: 1;
    padding: 0.65rem 1rem;
    outline: none;
}
.temp-input-wrap input::placeholder { color: var(--gray-400); font-weight: 400; }
.temp-input-wrap .unit {
    padding: 0 1rem;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gray-400);
    border-left: 2px solid var(--gray-200);
    background: white;
    align-self: stretch;
    display: flex; align-items: center;
}

.form-select-custom {
    background: var(--gray-50);
    border: 2px solid var(--gray-200) !important;
    border-radius: 12px !important;
    font-weight: 500;
    font-size: 0.88rem;
    color: var(--gray-700);
    padding: 0.6rem 0.9rem;
    transition: border-color 0.2s;
    box-shadow: none !important;
}
.form-select-custom:focus { border-color: var(--green-500) !important; }

.btn-save-suhu {
    background: linear-gradient(135deg, var(--green-700), var(--green-500));
    border: none;
    color: white;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 0.85rem;
    border-radius: 12px;
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(22,163,74,0.3);
    transition: all 0.2s;
}
.btn-save-suhu:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(22,163,74,0.4);
    color: white;
}

.log-item {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.2s;
}
.log-item:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.07); }
.log-item .li-stripe {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 5px;
}
.log-item .li-icon-wrap {
    width: 46px; height: 46px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.log-item .li-temp-badge {
    margin-left: auto;
    font-size: 1.1rem;
    font-weight: 800;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    white-space: nowrap;
    flex-shrink: 0;
}
.log-item .li-room { font-weight: 700; font-size: 0.9rem; color: var(--gray-900); }
.log-item .li-meta { font-size: 0.76rem; color: var(--gray-400); display: flex; align-items: center; gap: 8px; margin-top: 2px; }
.log-item .li-warn { font-size: 0.75rem; font-weight: 700; color: #DC2626; display: inline-flex; align-items: center; gap: 4px; margin-top: 5px; background: #FEE2E2; padding: 2px 8px; border-radius: 6px; }

.empty-log-state { background: white; border-radius: 16px; border: 1px solid var(--gray-200); padding: 3rem 1rem; text-align: center; }

/* ===== MOBILE OPTIMIZATIONS ===== */
@media (max-width: 767.98px) {
    /* Hero: compact */
    .kru-hero {
        padding: 1.25rem 1.15rem;
        border-radius: 16px;
    }
    .kru-hero h2 {
        font-size: 1.25rem !important;
    }
    .kru-hero p {
        font-size: 0.8rem !important;
    }
    .kru-hero .badge-role {
        font-size: 0.68rem;
        padding: 0.25rem 0.6rem;
    }
    .kru-hero .stat-chip {
        min-width: 90px;
        padding: 0.65rem 0.85rem;
        border-radius: 12px;
    }
    .kru-hero .stat-chip .stat-num {
        font-size: 1.25rem;
    }
    .kru-hero .stat-chip .stat-label {
        font-size: 0.62rem;
    }

    /* Action cards: compact */
    .action-card {
        padding: 1.1rem;
        gap: 0.85rem;
        border-radius: 14px;
    }
    .action-card:hover {
        transform: none;
    }
    .action-card .ac-icon {
        width: 42px; height: 42px;
        font-size: 1.15rem;
        border-radius: 12px;
    }
    .action-card .ac-title {
        font-size: 0.88rem;
    }
    .action-card .ac-sub {
        font-size: 0.72rem;
    }

    /* Temp card form */
    .temp-card {
        border-radius: 16px;
    }
    .temp-card .tc-header {
        padding: 1rem 1.15rem;
    }
    .temp-card .tc-header .tc-icon-wrap {
        width: 36px; height: 36px;
        font-size: 0.95rem;
    }
    .temp-card .tc-header h6 {
        font-size: 0.88rem;
    }
    .temp-card .tc-body {
        padding: 1.15rem;
    }
    .temp-input-wrap input {
        font-size: 1rem;
        padding: 0.55rem 0.75rem;
    }
    .temp-input-wrap .unit {
        padding: 0 0.75rem;
        font-size: 0.95rem;
    }
    .form-select-custom {
        font-size: 0.82rem;
        padding: 0.55rem 0.75rem;
    }
    .btn-save-suhu {
        font-size: 0.88rem;
        padding: 0.75rem;
        border-radius: 10px;
    }

    /* Log items: compact */
    .log-item {
        padding: 0.85rem 1rem;
        gap: 0.75rem;
        border-radius: 14px;
    }
    .log-item .li-icon-wrap {
        width: 38px; height: 38px;
        font-size: 1.05rem;
        border-radius: 10px;
    }
    .log-item .li-room {
        font-size: 0.82rem;
    }
    .log-item .li-meta {
        font-size: 0.68rem;
        gap: 5px;
    }
    .log-item .li-temp-badge {
        font-size: 0.9rem;
        padding: 0.35rem 0.7rem;
        border-radius: 10px;
    }
    .log-item .li-warn {
        font-size: 0.68rem;
        padding: 2px 6px;
    }

    .empty-log-state {
        padding: 2rem 1rem;
        border-radius: 14px;
    }
}

/* Small phones */
@media (max-width: 374px) {
    .kru-hero {
        padding: 1rem;
    }
    .kru-hero h2 {
        font-size: 1.1rem !important;
    }
    .kru-hero .stat-chip {
        min-width: 80px;
        padding: 0.5rem 0.7rem;
    }
    .kru-hero .stat-chip .stat-num {
        font-size: 1.1rem;
    }
    .action-card {
        padding: 0.95rem;
    }
    .log-item .li-icon-wrap {
        width: 34px; height: 34px;
        font-size: 0.95rem;
    }
    .log-item .li-temp-badge {
        font-size: 0.82rem;
        padding: 0.3rem 0.6rem;
    }
}
</style>

<div class="container-fluid mt-4 mb-5 px-lg-4">

    <!-- FLASH MESSAGES -->
    <div class="row mb-4">
        <div class="col-12"><?php Flasher::flash(); ?></div>
    </div>

    <!-- ===== HERO BANNER ===== -->
    <div class="kru-hero mb-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="badge-role mb-2"><i class="bi bi-person-badge"></i> Kru Gudang</span>
                <h2 class="fw-bold mb-1" style="font-size: 1.6rem; letter-spacing: -0.5px; color: var(--gray-900);"><?= $salam ?>, <?= $first_name ?>! 👋</h2>
                <p class="mb-0" style="color: var(--gray-500); font-size:0.9rem;">
                    <?= date('l, d F Y') ?> &nbsp;·&nbsp; <i class="bi bi-clock me-1"></i><span id="kru-live-clock"></span> WIB
                </p>
                <script>
                    (function() {
                        function tick() {
                            var now = new Date();
                            var h = String(now.getHours()).padStart(2, '0');
                            var m = String(now.getMinutes()).padStart(2, '0');
                            var el = document.getElementById('kru-live-clock');
                            if (el) el.textContent = h + ':' + m;
                        }
                        tick();
                        setInterval(tick, 1000);
                    })();
                </script>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <div class="stat-chip <?= $tugas > 0 ? 'alert-chip' : 'chip-picking' ?>">
                    <div class="stat-num"><?= $tugas ?></div>
                    <div class="stat-label"><?= $tugas > 0 ? '⚠ Tugas Picking' : 'Tugas Picking' ?></div>
                </div>
                <div class="stat-chip chip-log">
                    <div class="stat-num"><?= count($data['riwayat_suhu']) ?></div>
                    <div class="stat-label">Log Suhu Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== AKSI CEPAT ===== -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <p class="fw-bold text-muted mb-2" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px;">Aksi Cepat</p>
        </div>
        <div class="col-md-6">
            <a href="<?= BASEURL; ?>/outbound" class="action-card shadow-sm">
                <div class="ac-icon blue">
                    <i class="bi bi-list-check"></i>
                </div>
                <div>
                    <div class="ac-title">Daftar Tugas Picking</div>
                    <div class="ac-sub">
                        <?php if($tugas > 0): ?>
                            <span class="badge bg-danger rounded-pill me-1"><?= $tugas ?></span> pesanan menunggu diproses
                        <?php else: ?>
                            Tidak ada tugas aktif saat ini
                        <?php endif; ?>
                    </div>
                </div>
                <i class="bi bi-chevron-right ac-arrow"></i>
            </a>
        </div>
        <div class="col-md-6">
            <a href="<?= BASEURL; ?>/stok" class="action-card shadow-sm">
                <div class="ac-icon green">
                    <i class="bi bi-boxes"></i>
                </div>
                <div>
                    <div class="ac-title">Cari Rak / Stok</div>
                    <div class="ac-sub">Lokasi rak, komoditas, dan informasi stok</div>
                </div>
                <i class="bi bi-chevron-right ac-arrow"></i>
            </a>
        </div>
    </div>

    <!-- ===== MAIN CONTENT: FORM + LOG ===== -->
    <div class="row g-4">

        <!-- CATAT SUHU RUANGAN -->
        <div class="col-lg-5 col-xl-4">
            <div class="temp-card shadow-sm h-100">
                <div class="tc-header">
                    <div class="tc-icon-wrap"><i class="bi bi-thermometer-sun"></i></div>
                    <div>
                        <h6>Catat Suhu Ruangan</h6>
                        <p>Input suhu termostat langsung di sini</p>
                    </div>
                </div>
                <div class="tc-body">
                    <form action="<?= BASEURL; ?>/home/simpanLogSuhu" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark mb-2" style="font-size:0.85rem;">
                                <i class="bi bi-door-open me-1 text-muted"></i>Pilih Ruangan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-custom" name="id_ruangan" required>
                                <option value="" selected disabled>-- Pilih Ruangan --</option>
                                <?php foreach($data['ruangan'] as $r) : ?>
                                    <option value="<?= $r['id_ruangan']; ?>"><?= $r['kode_ruangan']; ?> · <?= $r['nama_ruangan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2" style="font-size:0.85rem;">
                                <i class="bi bi-thermometer-half me-1 text-muted"></i>Suhu Termostat <span class="text-danger">*</span>
                            </label>
                            <div class="temp-input-wrap">
                                <input type="number" step="0.1" name="suhu_tercatat" placeholder="0.0" required>
                                <span class="unit">°C</span>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Masukkan angka sesuai tampilan di termostat ruangan.</p>
                        </div>

                        <button type="submit" class="btn-save-suhu">
                            <i class="bi bi-floppy2-fill"></i> Simpan Log Suhu
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- LOG SUHU HARI INI -->
        <div class="col-lg-7 col-xl-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-0">Log Suhu Hari Ini</h6>
                    <p class="text-muted mb-0" style="font-size:0.8rem;">Menampilkan 5 log terakhir per hari ini</p>
                </div>
                <?php $anomali_count = count(array_filter($data['riwayat_suhu'], function($l){ $b=explode('-',str_replace('°C','',$l['rentang_suhu'])); return (float)$l['suhu_celcius']<(float)trim($b[0])||(float)$l['suhu_celcius']>(float)trim($b[1]); })); ?>
                <?php if($anomali_count > 0): ?>
                    <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm"><i class="bi bi-exclamation-triangle-fill me-1"></i><?= $anomali_count ?> Anomali</span>
                <?php else: ?>
                    <span class="badge badge-soft-success rounded-pill px-3 py-2"><i class="bi bi-shield-check me-1"></i>Semua Normal</span>
                <?php endif; ?>
            </div>

            <?php if(empty($data['riwayat_suhu'])) : ?>
                <div class="empty-log-state">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;">
                        <i class="bi bi-wind fs-2 text-muted opacity-50"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Belum ada pencatatan</h6>
                    <p class="text-muted small mb-0">Riwayat suhu hari ini akan muncul setelah kamu mengisi form di sebelah kiri.</p>
                </div>
            <?php else : ?>
                <div class="d-flex flex-column gap-3">
                    <?php foreach($data['riwayat_suhu'] as $log) : ?>
                        <?php
                            $rentang_bersih = str_replace('°C', '', $log['rentang_suhu']);
                            $batas    = explode('-', $rentang_bersih);
                            $min_suhu = (float)trim($batas[0]);
                            $max_suhu = (float)trim($batas[1]);
                            $suhu_aktual = (float)$log['suhu_celcius'];
                            $is_abnormal = ($suhu_aktual < $min_suhu || $suhu_aktual > $max_suhu);
                        ?>
                        <div class="log-item shadow-sm">
                            <div class="li-stripe" style="background: <?= $is_abnormal ? '#EF4444' : '#22C55E' ?>;"></div>
                            <div class="li-icon-wrap" style="background: <?= $is_abnormal ? '#FEE2E2' : '#DCFCE7' ?>;">
                                <i class="bi <?= $is_abnormal ? 'bi-exclamation-triangle-fill text-danger' : 'bi-thermometer-half text-success' ?>"></i>
                            </div>
                            <div style="min-width:0;">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="li-room"><?= $log['kode_ruangan'] ?></span>
                                    <span class="badge bg-light text-secondary border fw-normal px-2" style="font-size:0.7rem;"><?= $log['rentang_suhu'] ?></span>
                                </div>
                                <div class="li-meta">
                                    <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($log['waktu_catat'])) ?>
                                    <span style="opacity:0.4;">|</span>
                                    <i class="bi bi-clock"></i> <?= date('H:i', strtotime($log['waktu_catat'])) ?> WIB
                                </div>
                                <?php if($is_abnormal): ?>
                                    <div class="li-warn"><i class="bi bi-exclamation-octagon-fill"></i> Suhu di luar batas aman!</div>
                                <?php endif; ?>
                            </div>
                            <div class="li-temp-badge" style="background:<?= $is_abnormal ? '#FEE2E2' : '#DCFCE7' ?>; color:<?= $is_abnormal ? '#991B1B' : '#166534' ?>;">
                                <?= number_format($suhu_aktual, 1, ',', '.') ?> °C
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>