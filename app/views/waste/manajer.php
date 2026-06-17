<?php
    $is_alert = $data['statistik']['is_alert'];
    $persen = $data['statistik']['persentase'];
?>

<style>
/* ===== WASTE MANAJER PAGE STYLES ===== */
.waste-page-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
.waste-page-header .wph-left h2 {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.waste-page-header .wph-left h2 i {
    color: var(--green-600);
    font-size: 1.3rem;
}
.waste-page-header .wph-left p {
    color: var(--gray-500);
    font-size: 0.88rem;
    margin: 0;
}
.waste-page-header .btn-cetak {
    background: white;
    border: 1.5px solid var(--gray-200);
    border-radius: 12px;
    padding: 0.6rem 1.25rem;
    font-weight: 700;
    font-size: 0.85rem;
    color: var(--gray-700);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    text-decoration: none;
}
.waste-page-header .btn-cetak:hover {
    background: var(--gray-50);
    border-color: var(--green-300);
    color: var(--green-800);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* --- Alert Kritis --- */
.waste-alert-critical {
    background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
    border: none;
    border-radius: 18px;
    padding: 1.5rem 1.75rem;
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    color: white;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(220,38,38,0.25);
    position: relative;
    overflow: hidden;
    animation: fadeIn 0.5s ease;
}
.waste-alert-critical::after {
    content: '';
    position: absolute;
    top: -40px; right: -20px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.waste-alert-critical .wac-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}
.waste-alert-critical h4 {
    font-weight: 800;
    font-size: 1rem;
    margin-bottom: 0.3rem;
    color: white;
    letter-spacing: -0.3px;
}
.waste-alert-critical p {
    color: rgba(255,255,255,0.88);
    font-size: 0.88rem;
    margin: 0;
    line-height: 1.55;
}
.waste-alert-critical strong { color: white; }

/* --- Stat Cards --- */
.waste-stat-card {
    background: white;
    border-radius: 18px;
    border: 1px solid var(--gray-200);
    padding: 1.5rem;
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
}
.waste-stat-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 65%, rgba(0,0,0,0.01) 100%);
    pointer-events: none;
}
.waste-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
}
.waste-stat-card .wsc-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}
.waste-stat-card .wsc-label {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
}
.waste-stat-card .wsc-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.waste-stat-card .wsc-icon.wsi-alert { background: #FEE2E2; color: #DC2626; }
.waste-stat-card .wsc-icon.wsi-ok { background: var(--green-100); color: var(--green-700); }
.waste-stat-card .wsc-icon.wsi-dark { background: var(--gray-100); color: var(--gray-600); }
.waste-stat-card .wsc-icon.wsi-blue { background: #DBEAFE; color: #2563EB; }
.waste-stat-card .wsc-value {
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1;
    color: var(--gray-900);
    margin-bottom: 4px;
}
.waste-stat-card .wsc-value .wsc-unit {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gray-400);
    margin-left: 2px;
}
.waste-stat-card .wsc-value.val-danger { color: #DC2626; }
.waste-stat-card .wsc-value.val-success { color: var(--green-700); }
.waste-stat-card .wsc-value.val-blue { color: #2563EB; }
.waste-stat-card .wsc-sub {
    font-size: 0.76rem;
    font-weight: 500;
}
.waste-stat-card .wsc-sub.sub-danger { color: #DC2626; }
.waste-stat-card .wsc-sub.sub-ok { color: var(--green-600); }
.waste-stat-card .wsc-sub.sub-muted { color: var(--gray-400); }

/* Percentage gauge mini bar */
.waste-stat-card .wsc-gauge {
    margin-top: 0.85rem;
    height: 6px;
    background: var(--gray-100);
    border-radius: 50px;
    overflow: hidden;
}
.waste-stat-card .wsc-gauge .wsc-gauge-fill {
    height: 100%;
    border-radius: 50px;
    transition: width 1s ease;
}
.waste-stat-card .wsc-gauge .wsc-gauge-fill.fill-danger {
    background: linear-gradient(90deg, #EF4444, #F87171);
}
.waste-stat-card .wsc-gauge .wsc-gauge-fill.fill-success {
    background: linear-gradient(90deg, var(--green-500), var(--green-400));
}

/* --- Table Card --- */
.waste-table-card {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.waste-table-card .wtc-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 1.15rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.waste-table-card .wtc-header .wtc-icon {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    color: rgba(255,255,255,0.7);
}
.waste-table-card .wtc-header h6 {
    color: white; font-weight: 700; margin: 0; font-size: 0.95rem;
}
.waste-table-card .wtc-header p {
    color: rgba(255,255,255,0.5); font-size: 0.75rem; margin: 0;
}
.waste-table-card .wtc-body { padding: 0; }

/* Table styling */
.waste-table {
    width: 100%;
    margin: 0;
    font-size: 0.88rem;
}
.waste-table thead th {
    text-transform: uppercase;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: var(--gray-400);
    border-bottom: 2px solid var(--gray-100);
    padding: 0.85rem 1rem;
    background: var(--gray-50);
    white-space: nowrap;
}
.waste-table tbody td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid var(--gray-100);
    color: var(--gray-600);
}
.waste-table tbody tr:last-child td { border-bottom: none; }
.waste-table tbody tr {
    transition: background 0.15s;
}
.waste-table tbody tr:hover { background: var(--green-50); }

.waste-table .td-date .td-date-main { font-weight: 700; color: var(--gray-900); font-size: 0.85rem; }
.waste-table .td-date .td-date-time { font-size: 0.75rem; color: var(--gray-400); }
.waste-table .td-komoditas .td-komo-name { font-weight: 700; color: var(--gray-800); }
.waste-table .td-komoditas .td-komo-sku {
    font-size: 0.72rem; color: var(--gray-400);
    background: var(--gray-100); padding: 1px 6px; border-radius: 4px;
    display: inline-block; margin-top: 2px;
    font-family: 'Courier New', monospace; font-weight: 600;
}
.waste-table .td-alasan {
    color: #DC2626; font-weight: 600; font-size: 0.82rem;
}
.waste-table .td-berat {
    font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap;
}
.waste-table .td-berat.berat-normal { color: var(--gray-700); }
.waste-table .td-berat.berat-ok { color: var(--green-700); }
.waste-table .td-berat.berat-bad { color: #DC2626; }
.waste-table .td-aktor .aktor-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.78rem; color: var(--gray-500);
    margin-bottom: 2px;
}
.waste-table .td-aktor .aktor-item:last-child { margin-bottom: 0; }
.waste-table .td-aktor .aktor-item i { color: var(--gray-400); font-size: 0.85rem; }
.waste-table .td-aktor .aktor-item span { font-weight: 600; color: var(--gray-700); }

.waste-table .empty-row td {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--gray-400);
}
.waste-table .empty-row .er-icon {
    width: 56px; height: 56px;
    background: var(--gray-100);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 0.75rem;
    font-size: 1.3rem;
    color: var(--gray-300);
}

/* --- Animations --- */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="container-fluid mt-4 mb-5 px-lg-4">

    <!-- PAGE HEADER -->
    <div class="waste-page-header">
        <div class="wph-left">
            <h2><i class="bi bi-graph-up-arrow"></i> Laporan Penyusutan (Waste)</h2>
            <p>Pantau tingkat efisiensi penyimpanan dan identifikasi lonjakan komoditas busuk.</p>
        </div>
        <a href="<?= BASEURL; ?>/waste/cetakLaporan" target="_blank" class="btn-cetak">
            <i class="bi bi-printer"></i> Cetak Laporan
        </a>
    </div>

    <!-- ALERT KRITIS -->
    <?php if($is_alert) : ?>
        <div class="waste-alert-critical">
            <div class="wac-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
                <h4>PERINGATAN KRITIS: Batas Toleransi Penyusutan Terlampaui!</h4>
                <p>Tingkat pembusukan/limbah harian mencapai <strong><?= number_format($persen, 1, ',', '.'); ?>%</strong> (Batas maksimal 5%). Segera lakukan inspeksi suhu Chiller dan evaluasi kualitas pasokan masuk.</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- 3 STAT CARDS -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="waste-stat-card shadow-sm">
                <div class="wsc-header">
                    <div class="wsc-label">Rasio Penyusutan Hari Ini</div>
                    <div class="wsc-icon <?= $is_alert ? 'wsi-alert' : 'wsi-ok' ?>">
                        <i class="bi <?= $is_alert ? 'bi-exclamation-triangle' : 'bi-check-circle' ?>"></i>
                    </div>
                </div>
                <div class="wsc-value <?= $is_alert ? 'val-danger' : 'val-success' ?>">
                    <?= number_format($persen, 2, ',', '.'); ?> <span class="wsc-unit">%</span>
                </div>
                <?php if($is_alert) : ?>
                    <div class="wsc-sub sub-danger"><i class="bi bi-exclamation-circle me-1"></i>Melebihi batas 5%</div>
                <?php else : ?>
                    <div class="wsc-sub sub-ok"><i class="bi bi-shield-check me-1"></i>Dalam batas aman</div>
                <?php endif; ?>
                <div class="wsc-gauge">
                    <div class="wsc-gauge-fill <?= $is_alert ? 'fill-danger' : 'fill-success' ?>" style="width: <?= min($persen * 10, 100) ?>%;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="waste-stat-card shadow-sm">
                <div class="wsc-header">
                    <div class="wsc-label">Total Limbah Dibuang</div>
                    <div class="wsc-icon wsi-dark"><i class="bi bi-trash3"></i></div>
                </div>
                <div class="wsc-value"><?= number_format($data['statistik']['total_waste'], 2, ',', '.'); ?> <span class="wsc-unit">Kg</span></div>
                <div class="wsc-sub sub-muted">Berat bersih pemusnahan</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="waste-stat-card shadow-sm">
                <div class="wsc-header">
                    <div class="wsc-label">Total Stok Tersedia</div>
                    <div class="wsc-icon wsi-blue"><i class="bi bi-box-seam"></i></div>
                </div>
                <div class="wsc-value val-blue"><?= number_format($data['statistik']['total_stok'], 2, ',', '.'); ?> <span class="wsc-unit">Kg</span></div>
                <div class="wsc-sub sub-ok"><i class="bi bi-check-circle me-1"></i>Stok layak jual</div>
            </div>
        </div>
    </div>

    <!-- TABLE: RIWAYAT EVALUASI -->
    <div class="waste-table-card shadow-sm">
        <div class="wtc-header">
            <div class="wtc-icon"><i class="bi bi-clock-history"></i></div>
            <div>
                <h6>Riwayat Evaluasi Karantina</h6>
                <p>Log lengkap pemusnahan dan recovery barang</p>
            </div>
        </div>
        <div class="wtc-body">
            <div class="table-responsive">
                <table class="waste-table">
                    <thead>
                        <tr>
                            <th>Waktu & Tanggal</th>
                            <th>Komoditas (SKU)</th>
                            <th>Alasan NG</th>
                            <th class="text-end">Dilaporkan</th>
                            <th class="text-end">Diselamatkan</th>
                            <th class="text-end">Dibuang</th>
                            <th>Aktor Terlibat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['laporan'])) : ?>
                            <tr class="empty-row">
                                <td colspan="7">
                                    <div class="er-icon"><i class="bi bi-inbox"></i></div>
                                    <div style="font-weight:700; color:var(--gray-600); margin-bottom:2px;">Belum Ada Riwayat</div>
                                    <div style="font-size:0.8rem;">Data pemusnahan barang akan muncul setelah QC memproses laporan karantina.</div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach($data['laporan'] as $log) : ?>
                                <?php $limbah_murni = $log['berat_susut_kg'] - $log['berat_recovery_kg']; ?>
                                <tr>
                                    <td class="td-date">
                                        <div class="td-date-main"><?= date('d M Y', strtotime($log['waktu_catat'])); ?></div>
                                        <div class="td-date-time"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($log['waktu_catat'])); ?> WIB</div>
                                    </td>
                                    <td class="td-komoditas">
                                        <div class="td-komo-name"><?= $log['komoditas']; ?></div>
                                        <div class="td-komo-sku"><?= $log['kode_sku']; ?></div>
                                    </td>
                                    <td class="td-alasan"><?= $log['keterangan_ng']; ?></td>
                                    <td class="text-end td-berat berat-normal"><?= number_format($log['berat_susut_kg'], 2, ',', '.'); ?> Kg</td>
                                    <td class="text-end td-berat berat-ok"><?= number_format($log['berat_recovery_kg'], 2, ',', '.'); ?> Kg</td>
                                    <td class="text-end td-berat berat-bad"><?= number_format($limbah_murni, 2, ',', '.'); ?> Kg</td>
                                    <td class="td-aktor">
                                        <div class="aktor-item"><i class="bi bi-person"></i> Kru: <span><?= explode(' ', trim($log['pelapor']))[0]; ?></span></div>
                                        <div class="aktor-item"><i class="bi bi-person-check"></i> QC: <span><?= explode(' ', trim($log['pemeriksa']))[0]; ?></span></div>
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