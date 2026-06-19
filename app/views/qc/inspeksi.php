<div class="container-fluid py-4 pb-5 px-3 px-lg-4">

    <!-- ============================================================ -->
    <!-- PAGE HEADER                                                  -->
    <!-- ============================================================ -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?= BASEURL ?>/qc"
           class="d-inline-flex align-items-center justify-content-center rounded-3 text-decoration-none"
           style="width:36px; height:36px; background:var(--gray-100); color:var(--gray-600); border:1px solid var(--gray-200); flex-shrink:0;">
            <i class="bi bi-arrow-left" style="font-size:0.9rem;"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-0" style="letter-spacing:-0.5px;">
                Form Inspeksi Fisik
            </h4>
            <p class="mb-0" style="font-size:0.85rem;">
                Isi parameter fisik. Sistem akan menentukan kelayakan dan masa kedaluwarsa secara otomatis.
            </p>
        </div>
    </div>

    <form action="<?= BASEURL ?>/qc/prosesDecision" method="POST">
        <input type="hidden" name="id_asn" value="<?= $data['asn']['id_asn'] ?>">

        <div class="row g-4">

            <!-- ===================================================== -->
            <!-- LEFT COLUMN: Form Inputs                              -->
            <!-- ===================================================== -->
            <div class="col-lg-8">

                <!-- Parameter Armada -->
                <div class="card-clean animate-box p-4 mb-4" style="animation-delay:0.05s;">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--gray-200);">
                        <div class="stat-icon" style="background:var(--gray-100); color:var(--gray-700); flex-shrink:0;">
                            <i class="bi bi-thermometer-half"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Parameter Armada</h6>
                            <p class="mb-0" style="font-size:0.82rem;">Kondisi fisik kendaraan pengangkut.</p>
                        </div>
                    </div>

                    <label class="fw-semibold text-dark mb-1" style="font-size:0.875rem;">
                        Suhu Box Truk Saat Pintu Dibuka (°C) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="number" step="0.1" class="form-control" name="suhu_truk"
                               placeholder="Contoh: 12.5" required
                               style="border-radius:var(--radius-md) 0 0 var(--radius-md); border-color:var(--gray-300); font-size:0.95rem; font-weight:600;">
                        <span class="input-group-text fw-bold" style="background:var(--gray-50); color:var(--gray-500); border-color:var(--gray-300);">°C</span>
                    </div>
                    <div class="mt-2 d-flex align-items-center gap-1" style="font-size:0.8rem; color:#D97706;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Suhu di atas <strong>15°C</strong> akan otomatis menyebabkan seluruh batch retur.
                    </div>
                </div>

                <!-- Rincian Komoditas -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="bi bi-boxes me-1" style="color:var(--green-600);"></i>
                        Rincian Komoditas
                    </h6>
                    <span class="badge-soft badge-soft-success" style="font-size:0.75rem; border-radius:6px; padding:0.25em 0.65em;">
                        <?= count($data['detail']) ?> Item
                    </span>
                </div>

                <?php foreach ($data['detail'] as $i => $row): ?>
                <div class="card-clean animate-box p-4 mb-3" style="animation-delay:<?= 0.05 + ($i * 0.05) ?>s; border-left:4px solid var(--green-400);">
                    <input type="hidden" name="id_detail[]" value="<?= $row['id_detail'] ?>">

                    <!-- Komoditas Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-2"
                                 style="width:28px; height:28px; background:var(--green-100); color:var(--green-700); font-size:0.75rem; font-weight:800;">
                                <?= $i + 1 ?>
                            </div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size:0.95rem;"><?= htmlspecialchars($row['komoditas']) ?></h6>
                        </div>
                        <span class="badge-soft badge-soft-success" style="font-size:0.78rem; border-radius:6px; padding:0.3em 0.75em;">
                            <?= $row['berat_aktual_kg'] ?> Kg
                        </span>
                    </div>

                    <div class="row g-3">
                        <!-- Kematangan -->
                        <div class="col-md-4">
                            <label class="fw-semibold mb-1 d-block" style="font-size:0.8rem; color:var(--gray-600); text-transform:uppercase; letter-spacing:0.5px;">
                                Tingkat Kematangan
                            </label>
                            <select class="form-select" name="kematangan[]" required
                                    style="font-size:0.875rem; border-color:var(--gray-300); border-radius:var(--radius-md);">
                                <option value="" selected disabled>-- Pilih --</option>
                                <option value="Hijau">Hijau (Belum Matang)</option>
                                <option value="Kekuningan">Kekuningan (Standar)</option>
                                <option value="Kuning Matang">Kuning Matang (Siap Jual)</option>
                            </select>
                        </div>

                        <!-- Kekerasan -->
                        <div class="col-md-4">
                            <label class="fw-semibold mb-1 d-block" style="font-size:0.8rem; color:var(--gray-600); text-transform:uppercase; letter-spacing:0.5px;">
                                Tingkat Kekerasan
                            </label>
                            <select class="form-select" name="kekerasan[]" required
                                    style="font-size:0.875rem; border-color:var(--gray-300); border-radius:var(--radius-md);">
                                <option value="" selected disabled>-- Pilih --</option>
                                <option value="Keras">Keras / Solid</option>
                                <option value="Normal">Normal</option>
                                <option value="Lembek">Lembek / Berair</option>
                            </select>
                        </div>

                        <!-- Cacat Fisik -->
                        <div class="col-md-4">
                            <label class="fw-semibold mb-1 d-block" style="font-size:0.8rem; color:var(--gray-600); text-transform:uppercase; letter-spacing:0.5px;">
                                Cacat Fisik / Memar
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="cacat[]"
                                       min="0" max="100" placeholder="0 – 100" required
                                       style="font-size:0.875rem; border-color:var(--gray-300); border-radius:var(--radius-md) 0 0 var(--radius-md);">
                                <span class="input-group-text" style="font-size:0.875rem; background:var(--gray-50); color:var(--gray-500); border-color:var(--gray-300);">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>

            <!-- ===================================================== -->
            <!-- RIGHT COLUMN: Summary & Actions                       -->
            <!-- ===================================================== -->
            <div class="col-lg-4">
                <div class="card-clean animate-box p-4" style="animation-delay:0.1s; position:sticky; top:80px;">

                    <!-- Info Batch -->
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--gray-200);">
                        <div class="stat-icon stat-icon-green flex-shrink-0">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <div class="text-muted" style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.8px;">Batch Inspeksi</div>
                            <h6 class="fw-bold text-dark mb-0"><?= htmlspecialchars($data['asn']['nama_pemasok']) ?></h6>
                        </div>
                    </div>

                    <!-- Detail Info -->
                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid var(--gray-100);">
                            <span style="font-size:0.82rem; color:var(--gray-500);">Total Komoditas</span>
                            <span class="fw-bold text-dark" style="font-size:0.9rem;"><?= count($data['detail']) ?> Item</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span style="font-size:0.82rem; color:var(--gray-500);">Jadwal Tiba</span>
                            <span class="fw-bold text-dark" style="font-size:0.9rem;"><?= date('H:i', strtotime($data['asn']['waktu_rencana_tiba'])) ?> WIB</span>
                        </div>
                    </div>

                    <!-- Warning Box -->
                    <div class="rounded-3 p-3 mb-4" style="background:#FFFBEB; border:1px solid #FDE68A;">
                        <div class="fw-bold mb-1" style="font-size:0.8rem; color:#92400E;">
                            <i class="bi bi-info-circle-fill me-1"></i> Perhatian
                        </div>
                        <p class="mb-0" style="font-size:0.78rem; color:#92400E; line-height:1.5;">
                            Putusan bersifat final dan tidak dapat diubah. Pastikan semua data telah terisi dengan benar sebelum diproses.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <button type="submit" class="btn-green w-100 d-flex align-items-center justify-content-center gap-2 mb-2"
                            style="border-radius:var(--radius-md); padding:0.75rem 1rem; font-size:0.9rem; border:none; cursor:pointer;"
                            onclick="return confirm('Proses putusan inspeksi menggunakan mesin cerdas? Data tidak dapat diubah lagi.');">
                        <i class="bi bi-cpu"></i>
                        Proses Putusan Otomatis
                    </button>

                    <a href="<?= BASEURL ?>/qc"
                       class="d-flex align-items-center justify-content-center gap-2 text-decoration-none fw-semibold"
                       style="border-radius:var(--radius-md); padding:0.65rem 1rem; font-size:0.875rem;
                              background:var(--gray-100); color:var(--gray-600); border:1px solid var(--gray-200);">
                        <i class="bi bi-x-lg"></i>
                        Batal
                    </a>

                </div>
            </div>

        </div>
    </form>

</div>
