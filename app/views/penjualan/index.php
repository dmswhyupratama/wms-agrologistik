<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-cart-check me-2"></i>Manajemen Sales Order</h2>
                <p class="text-muted">Kelola daftar pesanan klien dan pantau status distribusi komoditas.</p>
            </div>
            <a href="<?= BASEURL; ?>/penjualan/tambah" class="btn btn-primary btn-lg fw-bold shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Buat Pesanan Baru
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID SO</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Nama Klien</th>
                            <th>Komoditas</th>
                            <th>Total Diminta</th>
                            <th>Admin Pemroses</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['pesanan'])) : ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pesanan (Sales Order).</td></tr>
                        <?php else : ?>
                            <?php foreach($data['pesanan'] as $so) : ?>
                                <tr>
                                    <td class="fw-bold">SO-<?= str_pad($so['id_so'], 4, '0', STR_PAD_LEFT); ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($so['created_at'])); ?></td>
                                    <td class="fw-bold text-dark"><?= $so['nama_klien']; ?></td>
                                    <td><?= $so['komoditas_dipesan']; ?></td>
                                    <td class="fw-bold text-primary"><?= number_format($so['total_diminta_kg'], 2, ',', '.'); ?> Kg</td>
                                    <td><?= $so['nama_admin']; ?></td>
                                    <td>
                                        <?php if($so['status_pesanan'] == 'pending') : ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                        <?php elseif($so['status_pesanan'] == 'proses_picking') : ?>
                                            <span class="badge bg-info text-dark"><i class="bi bi-box-seam me-1"></i>Proses Picking</span>
                                        <?php elseif($so['status_pesanan'] == 'siap_kirim') : ?>
                                            <span class="badge bg-primary"><i class="bi bi-truck me-1"></i>Siap Kirim</span>
                                        <?php elseif($so['status_pesanan'] == 'selesai') : ?>
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>
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