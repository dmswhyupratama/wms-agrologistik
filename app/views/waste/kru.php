<style>
/* ===== WASTE KRU PAGE STYLES ===== */

/* --- Page Header --- */
.waste-kru-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
.waste-kru-header .wkh-left h2 {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.waste-kru-header .wkh-left h2 i {
    color: #DC2626;
    font-size: 1.3rem;
}
.waste-kru-header .wkh-left p {
    color: var(--gray-500);
    font-size: 0.88rem;
    margin: 0;
}

/* --- Step Indicators --- */
.wk-steps {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 1.75rem;
    overflow-x: auto;
    padding-bottom: 4px;
}
.wk-step {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    white-space: nowrap;
    transition: all 0.2s;
}
.wk-step .wk-step-num {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
    font-weight: 800;
    flex-shrink: 0;
}
.wk-step .wk-step-text {
    font-size: 0.82rem;
    font-weight: 600;
}
.wk-step.step-active {
    background: #FEF2F2;
    border: 1.5px solid #FECACA;
}
.wk-step.step-active .wk-step-num {
    background: #DC2626;
    color: white;
    box-shadow: 0 2px 8px rgba(220,38,38,0.3);
}
.wk-step.step-active .wk-step-text { color: #991B1B; }
.wk-step.step-pending {
    background: transparent;
    border: 1.5px solid var(--gray-200);
}
.wk-step.step-pending .wk-step-num {
    background: var(--gray-100);
    color: var(--gray-400);
}
.wk-step.step-pending .wk-step-text { color: var(--gray-400); }
.wk-step-connector {
    width: 32px;
    height: 2px;
    background: var(--gray-200);
    flex-shrink: 0;
}

/* --- Main Form Card --- */
.wk-form-card {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.wk-form-card .wkf-header {
    background: linear-gradient(135deg, #7f1d1d 0%, #991B1B 50%, #B91C1C 100%);
    padding: 1.5rem 1.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.wk-form-card .wkf-header::after {
    content: '';
    position: absolute;
    top: -50px; right: -30px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.wk-form-card .wkf-header .wkf-icon-wrap {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
}
.wk-form-card .wkf-header h5 {
    color: white; font-weight: 700; margin: 0; font-size: 1.05rem;
}
.wk-form-card .wkf-header p {
    color: rgba(255,255,255,0.65); font-size: 0.78rem; margin: 0;
}
.wk-form-card .wkf-header .wkf-badge {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.85);
    font-size: 0.72rem;
    padding: 0.3rem 0.85rem;
    border-radius: 50px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 1;
}
.wk-form-card .wkf-body {
    padding: 2rem 1.75rem;
}

/* --- Form Field Section --- */
.wk-field-section {
    margin-bottom: 1.5rem;
}
.wk-field-label {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 6px;
}
.wk-field-label i {
    color: var(--gray-400);
    font-size: 1rem;
}
.wk-field-label .required-dot {
    width: 6px; height: 6px;
    background: #DC2626;
    border-radius: 50%;
    flex-shrink: 0;
}
.wk-field-hint {
    font-size: 0.76rem;
    color: var(--gray-400);
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
}
.wk-field-hint i { font-size: 0.85rem; }

/* --- Custom Input --- */
.wk-input-wrap {
    background: var(--gray-50);
    border: 2px solid var(--gray-200);
    border-radius: 14px;
    display: flex;
    align-items: center;
    overflow: hidden;
    transition: all 0.25s ease;
}
.wk-input-wrap:focus-within {
    border-color: #EF4444;
    background: white;
    box-shadow: 0 0 0 4px rgba(239,68,68,0.08);
}
.wk-input-wrap .wk-inp-icon {
    padding: 0 0 0 1.15rem;
    font-size: 1.15rem;
    color: var(--gray-300);
    display: flex;
    align-items: center;
    transition: color 0.25s;
}
.wk-input-wrap:focus-within .wk-inp-icon {
    color: #EF4444;
}
.wk-input-wrap input,
.wk-input-wrap select {
    border: none;
    background: transparent;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-900);
    flex: 1;
    padding: 0.85rem 1rem;
    outline: none;
}
.wk-input-wrap input::placeholder {
    color: var(--gray-400);
    font-weight: 400;
}
.wk-input-wrap .wk-inp-suffix {
    padding: 0 1.15rem;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--gray-400);
    border-left: 2px solid var(--gray-200);
    background: white;
    align-self: stretch;
    display: flex;
    align-items: center;
}

/* Berat variant */
.wk-input-wrap.wk-berat input {
    text-align: center;
    font-size: 1.5rem;
    font-weight: 800;
    color: #DC2626;
    letter-spacing: -0.5px;
}
.wk-input-wrap.wk-berat .wk-inp-suffix {
    font-size: 1.1rem;
}

/* Custom Select */
.wk-select-wrap {
    background: var(--gray-50);
    border: 2px solid var(--gray-200);
    border-radius: 14px;
    overflow: hidden;
    transition: all 0.25s ease;
}
.wk-select-wrap:focus-within {
    border-color: #EF4444;
    background: white;
    box-shadow: 0 0 0 4px rgba(239,68,68,0.08);
}
.wk-select-wrap select {
    border: none;
    background: transparent;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--gray-700);
    padding: 0.85rem 1rem;
    width: 100%;
    outline: none;
    cursor: pointer;
}
.wk-select-wrap select option[disabled] {
    color: var(--gray-400);
}

/* --- Penyebab Option Pills --- */
.wk-cause-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.wk-cause-option {
    display: none;
}
.wk-cause-label {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.85rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 14px;
    background: var(--gray-50);
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gray-600);
}
.wk-cause-label:hover {
    border-color: var(--gray-300);
    background: white;
}
.wk-cause-label .wk-cause-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
    transition: all 0.2s;
}
.wk-cause-label .wk-cause-icon.ci-orange { background: #FFF7ED; color: #EA580C; }
.wk-cause-label .wk-cause-icon.ci-purple { background: #F5F3FF; color: #7C3AED; }
.wk-cause-label .wk-cause-icon.ci-emerald { background: #ECFDF5; color: #059669; }
.wk-cause-label .wk-cause-icon.ci-blue { background: #EFF6FF; color: #2563EB; }

.wk-cause-option:checked + .wk-cause-label {
    border-color: #FCA5A5;
    background: #FEF2F2;
    color: #991B1B;
    box-shadow: 0 0 0 4px rgba(239,68,68,0.08);
}
.wk-cause-option:checked + .wk-cause-label .wk-cause-icon {
    background: #DC2626 !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(220,38,38,0.3);
}

/* --- Divider --- */
.wk-divider {
    height: 1px;
    background: var(--gray-100);
    margin: 1.75rem 0;
}

/* --- Submit Button --- */
.wk-btn-submit {
    background: linear-gradient(135deg, #991B1B, #DC2626, #EF4444);
    border: none;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    padding: 1rem;
    border-radius: 14px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 14px rgba(220,38,38,0.3);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}
.wk-btn-submit::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s ease;
}
.wk-btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220,38,38,0.4);
    color: white;
}
.wk-btn-submit:hover::after {
    left: 100%;
}
.wk-btn-submit:active {
    transform: translateY(0);
}
.wk-btn-submit i { font-size: 1.2rem; }

/* --- Info Banner --- */
.wk-info-banner {
    background: linear-gradient(135deg, #FFF7ED, #FFFBEB);
    border: 1px solid #FDE68A;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    margin-bottom: 1.75rem;
}
.wk-info-banner .wk-info-icon {
    width: 36px; height: 36px;
    background: #F59E0B;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(245,158,11,0.3);
}
.wk-info-banner .wk-info-title {
    font-weight: 700;
    color: #92400E;
    font-size: 0.85rem;
    margin-bottom: 2px;
}
.wk-info-banner p {
    margin: 0;
    font-size: 0.8rem;
    color: #A16207;
    line-height: 1.55;
    font-weight: 500;
}

/* --- Animations --- */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.wk-form-card { animation: fadeInUp 0.5s ease both; animation-delay: 0.1s; }
.wk-steps { animation: fadeInUp 0.4s ease both; }

/* --- Responsive --- */
@media (max-width: 767.98px) {
    .wk-form-card .wkf-body { padding: 1.5rem 1.25rem; }
    .wk-form-card .wkf-header { padding: 1.25rem; }
    .wk-cause-grid { grid-template-columns: 1fr; }
    .wk-steps { gap: 0; }
    .wk-step { padding: 0.6rem 0.85rem; }
    .wk-step .wk-step-text { font-size: 0.75rem; }
    .wk-input-wrap.wk-berat input { font-size: 1.25rem; }
}
</style>

<div class="container-fluid mt-4 mb-5 px-lg-4">

    <!-- FLASH MESSAGES -->
    <div class="row mb-3">
        <div class="col-12"><?php Flasher::flash(); ?></div>
    </div>

    <!-- PAGE HEADER -->
    <div class="waste-kru-header">
        <div class="wkh-left">
            <h2><i class="bi bi-exclamation-triangle-fill"></i> Lapor Barang Rusak</h2>
            <p>Pindai barcode SKU dan pisahkan stok bermasalah ke Area Karantina.</p>
        </div>
    </div>

    <!-- STEP INDICATORS -->
    <div class="wk-steps">
        <div class="wk-step step-active">
            <div class="wk-step-num">1</div>
            <div class="wk-step-text">Isi Formulir</div>
        </div>
        <div class="wk-step-connector"></div>
        <div class="wk-step step-pending">
            <div class="wk-step-num">2</div>
            <div class="wk-step-text">Review QC</div>
        </div>
        <div class="wk-step-connector"></div>
        <div class="wk-step step-pending">
            <div class="wk-step-num">3</div>
            <div class="wk-step-text">Diproses</div>
        </div>
    </div>

    <!-- MAIN FORM CARD -->
    <div class="wk-form-card shadow-sm">
        <div class="wkf-header">
            <div class="d-flex align-items-center gap-3">
                <div class="wkf-icon-wrap"><i class="bi bi-clipboard2-x"></i></div>
                <div>
                    <h5>Formulir Karantina</h5>
                    <p>Pisahkan barang bermasalah dari stok utama</p>
                </div>
            </div>
            <div class="wkf-badge d-none d-md-inline-flex">
                <i class="bi bi-shield-exclamation"></i> Area Karantina
            </div>
        </div>
        <div class="wkf-body">

            <!-- Info Banner -->
            <div class="wk-info-banner">
                <div class="wk-info-icon"><i class="bi bi-lightbulb-fill"></i></div>
                <div>
                    <div class="wk-info-title">Panduan Pengisian</div>
                    <p>Pastikan menembak barcode yang tepat pada kardus. Berat yang diinput akan otomatis dipotong dari stok gudang aktual setelah diverifikasi oleh QC.</p>
                </div>
            </div>

            <form action="<?= BASEURL; ?>/waste/laporKarantina" method="POST">

                <!-- Scan Barcode -->
                <div class="wk-field-section">
                    <div class="wk-field-label">
                        <i class="bi bi-upc-scan"></i>
                        Scan Barcode SKU (Target)
                        <span class="required-dot"></span>
                    </div>
                    <div class="wk-input-wrap">
                        <div class="wk-inp-icon"><i class="bi bi-qr-code-scan"></i></div>
                        <input type="text" name="kode_sku" placeholder="Tembak barcode atau ketik manual, cth: SKU-260603-014" required autocomplete="off">
                    </div>
                    <div class="wk-field-hint">
                        <i class="bi bi-info-circle"></i> Arahkan scanner ke barcode pada kardus / label SKU
                    </div>
                </div>

                <div class="row g-3">
                    <!-- Estimasi Berat -->
                    <div class="col-md-5">
                        <div class="wk-field-section mb-0">
                            <div class="wk-field-label">
                                <i class="bi bi-speedometer"></i>
                                Estimasi Berat Rusak
                                <span class="required-dot"></span>
                            </div>
                            <div class="wk-input-wrap wk-berat">
                                <input type="number" step="0.01" name="berat_karantina" placeholder="0.0" required>
                                <span class="wk-inp-suffix">Kg</span>
                            </div>
                            <div class="wk-field-hint">
                                <i class="bi bi-calculator"></i> Timbang atau estimasi berat kasar
                            </div>
                        </div>
                    </div>

                    <!-- Indikasi Penyebab -->
                    <div class="col-md-7">
                        <div class="wk-field-section mb-0">
                            <div class="wk-field-label">
                                <i class="bi bi-search"></i>
                                Indikasi Penyebab Kerusakan
                                <span class="required-dot"></span>
                            </div>
                            <div class="wk-cause-grid">
                                <input type="radio" name="keterangan_ng" value="Pembusukan Alami (Overripe)" id="cause-1" class="wk-cause-option" required>
                                <label for="cause-1" class="wk-cause-label">
                                    <div class="wk-cause-icon ci-orange"><i class="bi bi-droplet-half"></i></div>
                                    <span>Pembusukan Alami (Overripe)</span>
                                </label>

                                <input type="radio" name="keterangan_ng" value="Cacat Fisik / Memar Benturan" id="cause-2" class="wk-cause-option">
                                <label for="cause-2" class="wk-cause-label">
                                    <div class="wk-cause-icon ci-purple"><i class="bi bi-bandaid"></i></div>
                                    <span>Cacat Fisik / Memar Benturan</span>
                                </label>

                                <input type="radio" name="keterangan_ng" value="Serangan Hama / Jamur" id="cause-3" class="wk-cause-option">
                                <label for="cause-3" class="wk-cause-label">
                                    <div class="wk-cause-icon ci-emerald"><i class="bi bi-bug"></i></div>
                                    <span>Serangan Hama / Jamur</span>
                                </label>

                                <input type="radio" name="keterangan_ng" value="Kemasan Basah / Terkontaminasi" id="cause-4" class="wk-cause-option">
                                <label for="cause-4" class="wk-cause-label">
                                    <div class="wk-cause-icon ci-blue"><i class="bi bi-moisture"></i></div>
                                    <span>Kemasan Basah / Terkontaminasi</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wk-divider"></div>

                <!-- Submit Button -->
                <button type="submit" class="wk-btn-submit" onclick="return confirm('Pindahkan barang secara fisik ke Area Karantina setelah menekan OK.');">
                    <i class="bi bi-box-arrow-right"></i>
                    Karantina & Lapor QC
                </button>
            </form>

        </div>
    </div>

</div>