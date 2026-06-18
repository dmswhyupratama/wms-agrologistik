<?php
    $total_items = count($data['picking'] ?? []);
    $done_items = 0;
    if(!empty($data['picking'])) {
        foreach($data['picking'] as $p) {
            if($p['status_picking'] == 'selesai') $done_items++;
        }
    }
    $progress_pct = ($total_items > 0) ? round(($done_items / $total_items) * 100) : 0;
    $all_done = ($total_items > 0 && $done_items === $total_items);
?>

<style>
/* ===== SPLIT PANEL DASHBOARD LAYOUT ===== */
.dp-split-layout {
    display: flex;
    min-height: calc(100vh - 70px);
    margin: -1.5rem;
    background: var(--gray-50);
}

.dp-wrapper {
    display: flex;
    flex-direction: row;
    align-items: stretch;
    background: #f8fafc;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid var(--gray-200);
    min-height: 80vh;
}

/* Left Panel: Info SO */
.dp-info-panel {
    width: 380px;
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
    padding: 2rem 1.5rem;
    position: relative;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
}

.dp-info-panel::after {
    content: '';
    position: absolute;
    top: -60px; right: -30px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.dp-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    font-weight: 600;
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    transition: color 0.15s;
    margin-bottom: 2rem;
    z-index: 1;
}
.dp-back:hover { color: white; }

.dp-so-tag {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.9);
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.3rem 0.85rem;
    border-radius: 50px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 1rem;
    align-self: flex-start;
    z-index: 1;
}

.dp-info-panel h3 {
    font-size: 1.5rem;
    font-weight: 800;
    color: white;
    margin: 0;
    letter-spacing: -0.5px;
    z-index: 1;
}

.dp-info-sub {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    margin: 0.5rem 0 1.5rem;
    z-index: 1;
    line-height: 1.5;
}

.dp-info-divider {
    height: 1px;
    background: rgba(255,255,255,0.1);
    margin: 1rem 0 1.5rem;
    z-index: 1;
}

.dp-info-client {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    z-index: 1;
}

.dp-info-client .dp-hc-icon {
    width: 36px; height: 36px;
    background: rgba(96,165,250,0.2);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    color: #93C5FD;
    flex-shrink: 0;
}

.dp-info-client .dp-hc-label {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.45);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dp-info-client .dp-hc-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: white;
}

.dp-info-progress {
    margin-top: auto;
    z-index: 1;
}

.dp-info-progress .dp-hp-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.dp-info-progress .dp-hp-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: rgba(255,255,255,0.5);
}

.dp-info-progress .dp-hp-count {
    font-size: 0.82rem;
    font-weight: 800;
    color: white;
}

.dp-info-progress .dp-hp-count span {
    color: #4ADE80;
}

.dp-hp-track {
    height: 6px;
    background: rgba(255,255,255,0.1);
    border-radius: 50px;
    overflow: hidden;
}

.dp-hp-fill {
    height: 100%;
    border-radius: 50px;
    background: linear-gradient(90deg, #4ADE80, #22C55E);
    transition: width 1s ease;
    box-shadow: 0 0 8px rgba(74,222,128,0.4);
}

.dp-info-progress .dp-hp-status {
    margin-top: 8px;
    font-size: 0.75rem;
    font-weight: 600;
}

.dp-hp-status.status-progress { color: #FBBF24; }
.dp-hp-status.status-done { color: #4ADE80; }

/* Right Panel: Working Area */
.dp-work-panel {
    flex: 1;
    padding: 2.5rem 3rem;
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.dp-section-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    max-width: 600px;
}

/* Picking Card (Full width in right panel) */
.dp-pick-card {
    background: white;
    border-radius: 18px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.04);
}

.dp-pick-card.dp-card-done { opacity: 0.7; }

.dp-card-accent {
    height: 5px;
    width: 100%;
}
.dp-card-accent.accent-active { background: linear-gradient(90deg, #3B82F6, #60A5FA, #93C5FD); }
.dp-card-accent.accent-done { background: linear-gradient(90deg, var(--green-600), var(--green-400)); }

.dp-card-body {
    padding: 2rem;
}

.dp-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.dp-rak-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
}
.dp-rak-badge.rak-active {
    background: #FEF2F2;
    color: #DC2626;
    border: 1px solid #FECACA;
}
.dp-rak-badge.rak-done {
    background: var(--green-100);
    color: var(--green-800);
    border: 1px solid var(--green-200);
}

.dp-card-idx {
    width: 32px; height: 32px;
    background: var(--gray-100);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
    font-weight: 800;
    color: var(--gray-400);
}

.dp-card-komo {
    font-weight: 800;
    font-size: 1.35rem;
    color: var(--gray-900);
    margin-bottom: 6px;
    line-height: 1.3;
}

.dp-card-sku {
    font-size: 0.85rem;
    color: var(--gray-400);
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 1.5rem;
}
.dp-card-sku code {
    background: var(--gray-100);
    color: var(--gray-600);
    padding: 3px 8px;
    border-radius: 6px;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
}

.dp-weight {
    background: var(--gray-50);
    border: 2px solid var(--gray-100);
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.dp-weight .dp-w-label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-400);
    margin-bottom: 4px;
}

.dp-weight .dp-w-num {
    font-size: 1.8rem;
    font-weight: 800;
    line-height: 1;
}
.dp-weight .dp-w-num.num-active { color: #1D4ED8; }
.dp-weight .dp-w-num.num-done { color: var(--green-700); }

.dp-weight .dp-w-unit {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--gray-400);
    margin-left: 2px;
}

.dp-weight .dp-w-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.dp-weight .dp-w-icon.wi-active { background: #DBEAFE; color: #2563EB; }
.dp-weight .dp-w-icon.wi-done { background: var(--green-100); color: var(--green-700); }

.dp-scan-zone {
    margin-bottom: 1.5rem;
}
.dp-scan-zone label {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--gray-600);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.dp-scan-zone label .dot-req {
    width: 6px; height: 6px;
    background: #DC2626;
    border-radius: 50%;
}
.dp-scan-box {
    background: var(--gray-50);
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    display: flex;
    align-items: center;
    overflow: hidden;
    transition: all 0.2s;
}
.dp-scan-box:focus-within {
    border-color: #3B82F6;
    background: white;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.08);
}
.dp-scan-box .dp-sb-icon {
    padding-left: 1rem;
    color: var(--gray-300);
    font-size: 1.15rem;
    transition: color 0.2s;
}
.dp-scan-box:focus-within .dp-sb-icon { color: #3B82F6; }
.dp-scan-box input {
    border: none; background: transparent;
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--gray-900);
    text-align: center;
    flex: 1;
    padding: 0.8rem 1rem;
    outline: none;
}
.dp-scan-box input::placeholder { color: var(--gray-400); font-weight: 400; font-size: 0.85rem; }

.dp-scan-err {
    font-size: 0.8rem;
    font-weight: 600;
    color: #DC2626;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.dp-btn-confirm {
    background: linear-gradient(135deg, #1D4ED8, #3B82F6);
    border: none;
    color: white;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 0.9rem;
    border-radius: 12px;
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(59,130,246,0.25);
    transition: all 0.2s;
}
.dp-btn-confirm:not(.disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59,130,246,0.35);
    color: white;
}
.dp-btn-confirm.disabled { opacity: 0.45; cursor: not-allowed; box-shadow: none; }
.dp-btn-confirm.unlocked {
    background: linear-gradient(135deg, var(--green-700), var(--green-500));
    box-shadow: 0 4px 14px rgba(22,163,74,0.25);
}
.dp-btn-confirm.unlocked:hover {
    box-shadow: 0 6px 20px rgba(22,163,74,0.35);
}

.dp-btn-completed {
    background: var(--green-50);
    border: 1.5px solid var(--green-200);
    color: var(--green-700);
    font-weight: 700;
    font-size: 0.95rem;
    padding: 0.9rem;
    border-radius: 12px;
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}

.dp-empty {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    padding: 4rem 1.5rem;
    text-align: center;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
}
.dp-empty .dp-e-icon {
    width: 72px; height: 72px;
    background: var(--gray-100);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.75rem;
    color: var(--gray-300);
}
.dp-empty h5 { font-weight: 700; color: var(--gray-600); margin-bottom: 4px; }
.dp-empty p { font-size: 0.85rem; color: var(--gray-400); margin: 0; }

/* Modal Styles */
.dp-modal .modal-content { border: none; border-radius: 20px; overflow: hidden; }
.dp-modal .modal-header { background: var(--gray-50); border-bottom: 1px solid var(--gray-100); padding: 1.1rem 1.5rem; }
.dp-modal .modal-title { font-weight: 700; font-size: 1rem; }
.dp-modal .modal-body { padding: 1.5rem; }
.dp-modal .modal-footer { border-top: 1px solid var(--gray-100); padding: 1rem 1.5rem; }
.dp-modal .dp-m-icon {
    width: 48px; height: 48px;
    background: var(--green-100);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    color: var(--green-700);
    flex-shrink: 0;
}
.dp-m-btn-cancel {
    background: var(--gray-100); border: none; color: var(--gray-600);
    font-weight: 600; font-size: 0.85rem; padding: 0.6rem 1.25rem; border-radius: 10px;
    transition: all 0.15s;
}
.dp-m-btn-cancel:hover { background: var(--gray-200); }
.dp-m-btn-ok {
    background: linear-gradient(135deg, var(--green-700), var(--green-500));
    border: none; color: white; font-weight: 700; font-size: 0.85rem;
    padding: 0.6rem 1.25rem; border-radius: 10px;
    box-shadow: 0 4px 12px rgba(22,163,74,0.25);
    transition: all 0.15s; text-decoration: none;
}
.dp-m-btn-ok:hover { color: white; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(22,163,74,0.35); }

/* Mobile View Responsive */
@media (max-width: 991.98px) {
    .dp-wrapper {
        flex-direction: column;
        border-radius: 16px;
        border: none;
        box-shadow: none;
        background: transparent;
    }
    .dp-info-panel {
        width: 100%;
        padding: 1.25rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
    }
    .dp-info-panel::after {
        top: -100px; right: -50px;
    }
    .dp-back {
        margin-bottom: 1rem;
    }
    .dp-info-divider {
        display: none;
    }
    .dp-info-client {
        display: none;
    }
    .dp-info-sub {
        display: none;
    }
    .dp-info-panel h3 {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    .dp-info-progress {
        margin-top: 1rem;
    }
    
    .dp-work-panel {
        padding: 0;
        background: transparent;
    }
    .dp-section-label {
        display: none;
    }
    .dp-pick-card {
        border-radius: 16px;
    }
    .dp-card-body {
        padding: 1.25rem;
    }
    .dp-card-komo {
        font-size: 1.1rem;
    }
    .dp-weight {
        padding: 1rem;
    }
    .dp-weight .dp-w-num {
        font-size: 1.5rem;
    }
    .dp-weight .dp-w-icon {
        width: 40px; height: 40px; font-size: 1.1rem;
    }
}
</style>

<div class="mt-2 mb-4">
    <!-- FLASH -->
    <?php Flasher::flash(); ?>

    <?php if(empty($data['picking'])) : ?>
        <div class="dp-empty shadow-sm mt-4">
            <div class="dp-e-icon"><i class="bi bi-inbox"></i></div>
            <h5>Tidak Ada Data Instruksi</h5>
            <p>Belum ada tugas pengambilan untuk pesanan ini.</p>
        </div>
    <?php else : ?>
        <div class="dp-wrapper shadow-sm">
            <!-- PANEL KIRI: INFO SO -->
            <aside class="dp-info-panel">
                <a href="<?= BASEURL; ?>/outbound" class="dp-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
                
                <div class="dp-so-tag">
                    <i class="bi bi-file-earmark-text"></i>
                    SO-<?= str_pad($data['id_so'], 4, '0', STR_PAD_LEFT); ?>
                </div>
                
                <h3>Tugas Pengambilan</h3>
                <p class="dp-info-sub">Ambil barang dari rak sesuai instruksi & scan barcode untuk validasi</p>
                
                <div class="dp-info-divider"></div>
                
                <div class="dp-info-client">
                    <div class="dp-hc-icon"><i class="bi bi-person-fill"></i></div>
                    <div>
                        <div class="dp-hc-label">Klien</div>
                        <div class="dp-hc-name"><?= $data['picking'][0]['nama_klien']; ?></div>
                    </div>
                </div>
                
                <div class="dp-info-progress">
                    <div class="dp-hp-row">
                        <span class="dp-hp-label">Progress Picking</span>
                        <span class="dp-hp-count"><span><?= $done_items ?></span> / <?= $total_items ?> item</span>
                    </div>
                    <div class="dp-hp-track">
                        <div class="dp-hp-fill" style="width: <?= $progress_pct ?>%;"></div>
                    </div>
                    <?php if($all_done) : ?>
                        <div class="dp-hp-status status-done"><i class="bi bi-check-circle-fill me-1"></i>Semua item selesai diambil!</div>
                    <?php else : ?>
                        <div class="dp-hp-status status-progress"><i class="bi bi-lightning-fill me-1"></i><?= $total_items - $done_items ?> item tersisa</div>
                    <?php endif; ?>
                </div>
            </aside>
            
            <!-- PANEL KANAN: ITEM PICKING -->
            <section class="dp-work-panel">
                <div class="dp-section-label">
                    <i class="bi bi-grid-3x2-gap-fill"></i> Daftar Item Picking
                </div>
                
                <?php foreach($data['picking'] as $index => $item) : ?>
                    <?php $is_done = ($item['status_picking'] == 'selesai'); ?>
                    
                    <div class="dp-pick-card <?= $is_done ? 'dp-card-done' : '' ?> mb-4">
                        <div class="dp-card-accent <?= $is_done ? 'accent-done' : 'accent-active' ?>"></div>
                        <div class="dp-card-body">

                            <div class="dp-card-top">
                                <span class="dp-rak-badge <?= $is_done ? 'rak-done' : 'rak-active' ?>">
                                    <i class="bi bi-geo-alt-fill"></i> <?= $item['lokasi_rak']; ?>
                                </span>
                                <div class="dp-card-idx">#<?= $index + 1; ?></div>
                            </div>

                            <div class="dp-card-komo"><?= $item['komoditas']; ?></div>
                            <div class="dp-card-sku">
                                <i class="bi bi-upc-scan"></i> SKU:
                                <code><?= $item['kode_sku']; ?></code>
                            </div>

                            <div class="dp-weight">
                                <div>
                                    <div class="dp-w-label">Ambil Sebanyak</div>
                                    <div class="dp-w-num <?= $is_done ? 'num-done' : 'num-active' ?>">
                                        <?= number_format($item['berat_diambil_kg'], 2, ',', '.'); ?>
                                        <span class="dp-w-unit">Kg</span>
                                    </div>
                                </div>
                                <div class="dp-w-icon <?= $is_done ? 'wi-done' : 'wi-active' ?>">
                                    <i class="bi <?= $is_done ? 'bi-check-lg' : 'bi-box-seam' ?>"></i>
                                </div>
                            </div>

                            <?php if(!$is_done) : ?>
                                <div class="dp-scan-zone">
                                    <label>Scan Barcode <span class="dot-req"></span></label>
                                    <div class="dp-scan-box">
                                        <div class="dp-sb-icon"><i class="bi bi-qr-code-scan"></i></div>
                                        <input type="text" class="input-barcode"
                                                data-target="<?= $item['kode_sku']; ?>"
                                                data-btn="btn-ambil-<?= $item['id_picking']; ?>"
                                                placeholder="Arahkan scanner ke barcode..." autocomplete="off">
                                    </div>
                                    <div class="dp-scan-err d-none" id="error-<?= $item['id_picking']; ?>">
                                        <i class="bi bi-exclamation-circle-fill"></i> SKU tidak cocok!
                                    </div>
                                </div>

                                <button type="button"
                                    class="dp-btn-confirm disabled action-btn"
                                    id="btn-ambil-<?= $item['id_picking']; ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalKonfirmasiAmbil"
                                    data-url="<?= BASEURL; ?>/outbound/konfirmasiAmbil/<?= $item['id_picking']; ?>/<?= $data['id_so']; ?>">
                                    <i class="bi bi-lock-fill" id="icon-<?= $item['id_picking']; ?>"></i>
                                    Selesai Ambil
                                </button>
                            <?php else : ?>
                                <button class="dp-btn-completed" disabled>
                                    <i class="bi bi-check-circle-fill"></i> Telah Diambil
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade dp-modal" id="modalKonfirmasiAmbil" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Pengambilan</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-start gap-3">
            <div class="dp-m-icon"><i class="bi bi-check2-circle"></i></div>
            <div>
                <h6 class="fw-bold mb-1">Barang Telah Diambil?</h6>
                <p class="text-muted mb-0" style="font-size:0.88rem; line-height:1.6;">Konfirmasi bahwa barang fisik telah Anda ambil dari rak dan siap dipacking.</p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="dp-m-btn-cancel" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmKonfirmasiAmbil" class="dp-m-btn-ok">
            <i class="bi bi-check2-all me-1"></i>Ya, Selesai Ambil
        </a>
      </div>
    </div>
  </div>
</div>

<script>
    document.querySelectorAll('.input-barcode').forEach(input => {
        input.addEventListener('keyup', function() {
            let inputVal = this.value.trim().toUpperCase();
            let targetSKU = this.getAttribute('data-target').toUpperCase();
            let btnId = this.getAttribute('data-btn');

            let btnAction = document.getElementById(btnId);
            let iconBtn = document.getElementById('icon-' + btnId.replace('btn-ambil-', ''));
            let errorMsg = document.getElementById('error-' + btnId.replace('btn-ambil-', ''));

            if(inputVal === '') {
                btnAction.classList.add('disabled');
                btnAction.classList.remove('unlocked');
                errorMsg.classList.add('d-none');
                iconBtn.className = 'bi bi-lock-fill';
                this.style.color = '';
                return;
            }

            if(inputVal === targetSKU) {
                btnAction.classList.remove('disabled');
                btnAction.classList.add('unlocked');
                errorMsg.classList.add('d-none');
                iconBtn.className = 'bi bi-unlock-fill';
                this.style.color = 'var(--green-700)';
            } else {
                btnAction.classList.add('disabled');
                btnAction.classList.remove('unlocked');
                errorMsg.classList.remove('d-none');
                iconBtn.className = 'bi bi-lock-fill';
                this.style.color = '#DC2626';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalKonfirmasiAmbil');
        if (modal) {
            modal.addEventListener('show.bs.modal', event => {
                const url = event.relatedTarget.getAttribute('data-url');
                document.getElementById('btnConfirmKonfirmasiAmbil').setAttribute('href', url);
            });
        }
    });
</script>