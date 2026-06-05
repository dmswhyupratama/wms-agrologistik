<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-truck me-2"></i>Manajemen Outbound</h2>
                <p class="text-muted">Pantau pesanan keluar dan eksekusi algoritma pencarian stok (FEFO).</p>
            </div>
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
                            <th>Tanggal</th>
                            <th>Nama Klien</th>
                            <th>Komoditas</th>
                            <th>Total Diminta</th>
                            <th>Status</th>
                            <th class="text-center">Aksi Sistem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['so'])) : ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pesanan masuk.</td></tr>
                        <?php else : ?>
                            <?php foreach($data['so'] as $so) : ?>
                                <tr>
                                    <td class="fw-bold text-dark">SO-<?= str_pad($so['id_so'], 4, '0', STR_PAD_LEFT); ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($so['created_at'])); ?></td>
                                    <td><?= $so['nama_klien']; ?></td>
                                    <td><?= $so['komoditas_dipesan']; ?></td>
                                    <td class="fw-bold text-primary"><?= number_format($so['total_diminta_kg'], 2, ',', '.'); ?> Kg</td>
                                    
                                    <td>
                                        <?php if($so['status_pesanan'] == 'pending') : ?>
                                            <span class="badge bg-warning text-dark">Menunggu Proses</span>
                                        <?php elseif($so['status_pesanan'] == 'proses_picking') : ?>
                                            <span class="badge bg-info text-dark">Proses Picking</span>
                                        <?php elseif($so['status_pesanan'] == 'siap_kirim') : ?>
                                            <span class="badge bg-primary">Siap Kirim</span>
                                        <?php elseif($so['status_pesanan'] == 'selesai') : ?>
                                            <span class="badge bg-success">Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if($so['status_pesanan'] == 'pending' && $_SESSION['role'] == 'admin_gudang') : ?>
                                            <a href="<?= BASEURL; ?>/outbound/prosesPicking/<?= $so['id_so']; ?>" class="btn btn-primary btn-sm fw-bold shadow-sm" onclick="return confirm('Eksekusi algoritma pencarian rak untuk pesanan ini?');">
                                                <i class="bi bi-cpu me-1"></i> Auto-Route (FEFO)
                                            </a>
                                            
                                        <?php elseif($so['status_pesanan'] == 'proses_picking') : ?>
                                            <?php if($_SESSION['role'] == 'kru_lapangan') : ?>
                                                <a href="<?= BASEURL; ?>/outbound/detailPicking/<?= $so['id_so']; ?>" class="btn btn-outline-info btn-sm fw-bold">
                                                    <i class="bi bi-list-task me-1"></i> Lihat Picking List
                                                </a>
                                            <?php else : ?>
                                                <span class="badge bg-light text-secondary border"><i class="bi bi-hourglass-split me-1"></i> Menunggu Kru Lapangan</span>
                                            <?php endif; ?>
                                            
                                        <?php elseif($so['status_pesanan'] == 'siap_kirim') : ?>
                                            <?php if($_SESSION['role'] == 'admin_gudang') : ?>
                                                <a href="<?= BASEURL; ?>/outbound/formEkspedisi/<?= $so['id_so']; ?>" class="btn btn-warning btn-sm text-dark fw-bold shadow-sm">
                                                    <i class="bi bi-truck me-1"></i> Proses Ekspedisi
                                                </a>
                                            <?php else : ?>
                                                <span class="badge bg-light text-secondary border"><i class="bi bi-box-seam me-1"></i> Menunggu Ekspedisi</span>
                                            <?php endif; ?>
                                            
                                        <?php else : ?>
                                            <span class="text-muted small"><i class="bi bi-check-all"></i> Selesai</span>
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