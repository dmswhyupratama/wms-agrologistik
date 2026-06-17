<div class="container-fluid mt-4 mb-5">
    
    <!-- HEADER -->
    <div class="row mb-4">
        <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold text-green-dark mb-1 d-flex align-items-center">
                    <div class="bg-green-light text-green rounded-3 p-2 me-3 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                    Manajemen Sales Order
                </h2>
                <p class="text-muted mb-0 ms-1" style="font-size: 0.95rem;">Kelola daftar pesanan klien dan pantau status distribusi komoditas.</p>
            </div>
            <a href="<?= BASEURL; ?>/penjualan/tambah" class="btn btn-green btn-lg fw-bold rounded-pill d-flex align-items-center">
                <i class="bi bi-plus-circle-fill me-2 fs-5"></i>Buat Pesanan Baru
            </a>
        </div>
    </div>

    <!-- FLASHER -->
    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="card-clean">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-clean table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">ID SO</th>
                            <th>Tgl. Pemesanan</th>
                            <th>Klien</th>
                            <th>Komoditas</th>
                            <th class="text-end">Total Permintaan</th>
                            <th>Admin Sales</th>
                            <th class="pe-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['pesanan'])) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="fw-medium mb-0">Belum ada data pesanan (Sales Order).</p>
                                        <small>Klik "Buat Pesanan Baru" untuk mulai melayani klien.</small>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach($data['pesanan'] as $so) : ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">SO-<?= str_pad($so['id_so'], 4, '0', STR_PAD_LEFT); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium text-dark"><?= date('d M Y', strtotime($so['created_at'])); ?></span>
                                            <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($so['created_at'])); ?> WIB</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-1 me-2 text-secondary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            <?= $so['nama_klien']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium"><?= $so['komoditas_dipesan']; ?></span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-primary" style="font-size: 1.05rem;">
                                            <?= number_format($so['total_diminta_kg'], 2, ',', '.'); ?>
                                        </span> 
                                        <span class="text-muted fw-medium" style="font-size: 0.8rem;">Kg</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary"><i class="bi bi-person me-1"></i><?= explode(' ', trim($so['nama_admin']))[0]; ?></span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <?php if($so['status_pesanan'] == 'pending') : ?>
                                            <span class="badge badge-soft badge-soft-warning"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                        <?php elseif($so['status_pesanan'] == 'proses_picking') : ?>
                                            <span class="badge badge-soft badge-soft-info"><i class="bi bi-box-seam me-1"></i>Picking</span>
                                        <?php elseif($so['status_pesanan'] == 'siap_kirim') : ?>
                                            <span class="badge badge-soft badge-soft-primary"><i class="bi bi-truck me-1"></i>Siap Kirim</span>
                                        <?php elseif($so['status_pesanan'] == 'selesai') : ?>
                                            <span class="badge badge-soft badge-soft-success"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>
                                        <?php endif; ?>
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