<div class="container-fluid mt-4 mb-5 px-lg-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;"><i class="bi bi-truck me-2 text-green"></i>Manajemen Outbound</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Pantau pesanan keluar dan eksekusi algoritma pencarian stok (FEFO).</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 border-0 animate-box">
        <div class="table-responsive">
            <table class="table table-borderless table-hover align-middle mb-0" style="font-size: 0.95rem;">
                <thead class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <th class="fw-semibold pb-3 ps-3">ID SO</th>
                        <th class="fw-semibold pb-3">Tanggal</th>
                        <th class="fw-semibold pb-3">Nama Klien</th>
                        <th class="fw-semibold pb-3">Komoditas</th>
                        <th class="fw-semibold pb-3">Total Diminta</th>
                        <th class="fw-semibold pb-3">Status</th>
                        <th class="fw-semibold pb-3 text-center pe-3">Aksi Sistem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data['so'])) : ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted opacity-25 d-block mb-3"></i>
                                <span class="text-muted">Belum ada pesanan masuk.</span>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach($data['so'] as $so) : ?>
                            <tr style="border-bottom: 1px solid #f9fafb;">
                                <td class="ps-3 py-3">
                                    <span class="fw-bold text-dark">SO-<?= str_pad($so['id_so'], 4, '0', STR_PAD_LEFT); ?></span>
                                </td>
                                <td class="py-3">
                                    <div class="text-dark fw-medium"><?= date('d M Y', strtotime($so['created_at'])); ?></div>
                                    <div class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($so['created_at'])); ?> WIB</div>
                                </td>
                                <td class="py-3 fw-medium text-dark"><?= $so['nama_klien']; ?></td>
                                <td class="py-3 text-muted" style="font-size: 0.85rem; max-width: 200px;"><div class="text-truncate" title="<?= $so['komoditas_dipesan']; ?>"><?= $so['komoditas_dipesan']; ?></div></td>
                                <td class="py-3"><strong class="text-green"><?= number_format($so['total_diminta_kg'], 2, ',', '.'); ?> Kg</strong></td>
                                
                                <td class="py-3">
                                    <?php if($so['status_pesanan'] == 'pending') : ?>
                                        <span class="badge badge-soft-warning rounded-pill px-3 fw-medium">Menunggu Proses</span>
                                    <?php elseif($so['status_pesanan'] == 'proses_picking') : ?>
                                        <span class="badge badge-soft-info rounded-pill px-3 fw-medium">Proses Picking</span>
                                    <?php elseif($so['status_pesanan'] == 'siap_kirim') : ?>
                                        <span class="badge badge-soft-primary rounded-pill px-3 fw-medium">Siap Kirim</span>
                                    <?php elseif($so['status_pesanan'] == 'selesai') : ?>
                                        <span class="badge badge-soft-success rounded-pill px-3 fw-medium">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="py-3 text-center pe-3">
                                    <div class="d-flex justify-content-center gap-2">
                                    <?php if($so['status_pesanan'] == 'pending' && $_SESSION['role'] == 'admin_gudang') : ?>
                                        <button type="button" class="btn btn-sm btn-blue rounded-pill fw-medium shadow-sm px-3 hover-elevate" data-bs-toggle="modal" data-bs-target="#modalAutoRoute" data-url="<?= BASEURL; ?>/outbound/prosesPicking/<?= $so['id_so']; ?>">
                                            <i class="bi bi-cpu me-1"></i> Auto-Route (FEFO)
                                        </button>
                                        
                                    <?php elseif($so['status_pesanan'] == 'proses_picking') : ?>
                                        <?php if($_SESSION['role'] == 'kru_lapangan') : ?>
                                            <a href="<?= BASEURL; ?>/outbound/detailPicking/<?= $so['id_so']; ?>" class="btn btn-amber btn-sm rounded-pill fw-medium px-3 shadow-sm hover-elevate text-white">
                                                <i class="bi bi-list-task me-1"></i> Lihat Picking List
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted fw-medium" style="font-size: 0.85rem;"><i class="bi bi-hourglass-split me-1"></i> Menunggu Kru Lapangan</span>
                                        <?php endif; ?>
                                        
                                    <?php elseif($so['status_pesanan'] == 'siap_kirim') : ?>
                                        <?php if($_SESSION['role'] == 'admin_gudang') : ?>
                                            <a href="<?= BASEURL; ?>/outbound/formEkspedisi/<?= $so['id_so']; ?>" class="btn btn-green btn-sm rounded-pill fw-medium px-3 shadow-sm hover-elevate">
                                                <i class="bi bi-truck me-1"></i> Proses Ekspedisi
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted fw-medium" style="font-size: 0.85rem;"><i class="bi bi-box-seam me-1"></i> Menunggu Ekspedisi</span>
                                        <?php endif; ?>
                                        
                                    <?php else : ?>
                                        <span class="text-muted fw-medium small"><i class="bi bi-check-all me-1"></i> Selesai</span>
                                    <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Auto Route -->
<div class="modal fade" id="modalAutoRoute" tabindex="-1" aria-labelledby="modalAutoRouteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
      <div class="modal-body p-4 text-center">
        <!-- Premium Icon -->
        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 mt-2 shadow-sm" style="width: 80px; height: 80px;">
            <i class="bi bi-check-lg" style="font-size: 3.5rem; -webkit-text-stroke: 2px;"></i>
        </div>
        
        <h4 class="fw-bold text-dark mb-2">Jalankan FEFO?</h4>
        <p class="text-muted mb-4 small px-2">Sistem akan otomatis mencari rak dengan stok yang paling mendekati kadaluwarsa untuk pesanan ini.</p>
        
        <div class="d-flex flex-column gap-2">
            <a href="#" id="btnConfirmAutoRoute" class="btn btn-blue rounded-pill py-2 fw-bold shadow-sm w-100">
                <i class="bi bi-play-circle me-1"></i> Ya, Eksekusi
            </a>
            <button type="button" class="btn btn-light rounded-pill py-2 fw-medium w-100 text-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalAutoRoute = document.getElementById('modalAutoRoute');
    if (modalAutoRoute) {
        // Pindahkan modal ke luar dari container agar tidak freeze (z-index issue)
        document.body.appendChild(modalAutoRoute);
        
        modalAutoRoute.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            document.getElementById('btnConfirmAutoRoute').setAttribute('href', url);
        });
    }
});
</script>