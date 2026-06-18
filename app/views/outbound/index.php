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
                                        <button type="button" class="btn btn-sm btn-primary rounded-pill fw-medium shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalAutoRoute" data-url="<?= BASEURL; ?>/outbound/prosesPicking/<?= $so['id_so']; ?>">
                                            <i class="bi bi-cpu me-1"></i> Auto-Route (FEFO)
                                        </button>
                                        
                                    <?php elseif($so['status_pesanan'] == 'proses_picking') : ?>
                                        <?php if($_SESSION['role'] == 'kru_lapangan') : ?>
                                            <a href="<?= BASEURL; ?>/outbound/detailPicking/<?= $so['id_so']; ?>" class="btn btn-info btn-sm rounded-pill fw-medium px-3 shadow-sm text-white">
                                                <i class="bi bi-list-task me-1"></i> Lihat Picking List
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted fw-medium" style="font-size: 0.85rem;"><i class="bi bi-hourglass-split me-1"></i> Menunggu Kru Lapangan</span>
                                        <?php endif; ?>
                                        
                                    <?php elseif($so['status_pesanan'] == 'siap_kirim') : ?>
                                        <?php if($_SESSION['role'] == 'admin_gudang') : ?>
                                            <a href="<?= BASEURL; ?>/outbound/formEkspedisi/<?= $so['id_so']; ?>" class="btn btn-warning btn-sm rounded-pill fw-medium px-3 shadow-sm">
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
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalAutoRouteLabel">Konfirmasi Eksekusi FEFO</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                <i class="bi bi-cpu fs-3"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Jalankan Algoritma FEFO?</h6>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Sistem akan mencari rak dengan stok yang paling mendekati kadaluwarsa untuk pesanan ini.</p>
            </div>
        </div>
      </div>
      <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-light rounded-pill px-4 fw-medium" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmAutoRoute" class="btn btn-primary rounded-pill px-4 fw-medium">Ya, Eksekusi</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalAutoRoute = document.getElementById('modalAutoRoute');
    if (modalAutoRoute) {
        modalAutoRoute.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            document.getElementById('btnConfirmAutoRoute').setAttribute('href', url);
        });
    }
});
</script>