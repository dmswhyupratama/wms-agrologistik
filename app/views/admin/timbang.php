<div class="container-fluid mt-4 mb-5 px-lg-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;"><i class="bi bi-speedometer2 me-2 text-green"></i>Timbang Truk Inbound</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Masukkan berat aktual hasil timbangan gudang sebelum dioper ke Petugas QC.</p>
        </div>
        <a href="<?= BASEURL; ?>/admin/inbound" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium hover-elevate text-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 border-0 mb-4">
        <h6 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="bi bi-truck me-2 text-primary"></i>Detail Informasi Armada</h6>
        
        <div class="row g-4 mb-2">
            <div class="col-md-6">
                <p class="mb-1 text-muted fw-medium" style="font-size: 0.85rem;">Nama Pemasok</p>
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-shop fs-5"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0"><?= $data['asn']['nama_pemasok']; ?></h5>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1 text-muted fw-medium" style="font-size: 0.85rem;">Jadwal Tiba</p>
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-calendar-event fs-5"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0"><?= date('d F Y', strtotime($data['asn']['waktu_rencana_tiba'])); ?> <span class="badge badge-soft-info ms-2"><?= date('H:i', strtotime($data['asn']['waktu_rencana_tiba'])); ?> WIB</span></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 border-0">
        <form action="<?= BASEURL; ?>/admin/simpanTimbang" method="POST">
            <input type="hidden" name="id_asn" value="<?= $data['asn']['id_asn']; ?>">

            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-list-check me-2 text-success"></i>Daftar Komoditas (Input Berat Fisik)</h6>
            </div>
            
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle mb-0" style="font-size: 0.95rem;">
                    <thead class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <th class="fw-semibold pb-3 ps-3" width="5%">No</th>
                            <th class="fw-semibold pb-3">Jenis Buah</th>
                            <th class="fw-semibold pb-3 text-end">Estimasi Pemasok</th>
                            <th class="fw-semibold pb-3 text-end pe-3" width="30%">Berat Aktual (Kg) <span class="text-danger">*</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($data['detail'] as $row) : ?>
                        <tr style="border-bottom: 1px solid #f9fafb;">
                            <td class="ps-3 py-3 text-muted"><?= $no++; ?></td>
                            <td class="py-3 fw-bold text-dark"><?= $row['komoditas']; ?></td>
                            <td class="py-3 text-end text-muted fw-medium"><?= number_format($row['estimasi_berat_kg'], 2, ',', '.'); ?> Kg</td>
                            <td class="py-3 pe-3">
                                <input type="hidden" name="id_detail[]" value="<?= $row['id_detail']; ?>">
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.01" class="form-control bg-light border-0 px-3 py-2 fw-medium" name="berat_aktual_kg[]" placeholder="Estimasi: <?= $row['estimasi_berat_kg']; ?>" required>
                                    <span class="input-group-text bg-light border-0 text-muted fw-medium px-3">Kg</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4 pt-3">
                <button type="submit" class="btn btn-green rounded-pill fw-medium px-4 py-2 shadow-sm"><i class="bi bi-save2 me-2"></i>Simpan & Oper ke QC</button>
            </div>
        </form>
    </div>
</div>