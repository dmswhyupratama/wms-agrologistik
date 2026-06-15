<div class="container-fluid mt-4 mb-5 px-lg-4">
    <div class="row mb-4">
        <div class="col-12">
            <?php Flasher::flash(); ?>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;"><i class="bi bi-box-arrow-in-down me-2 text-green"></i>Manajemen Inbound Pemasok</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Lakukan validasi jadwal kedatangan armada sebelum truk memasuki area Loading Dock Gudang.</p>
        </div>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 border-0">
        <div class="table-responsive">
            <table class="table table-borderless table-hover align-middle mb-0" style="font-size: 0.95rem;">
                <thead class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <th class="fw-semibold pb-3 ps-3">No. ASN</th>
                        <th class="fw-semibold pb-3">Jadwal Tiba</th>
                        <th class="fw-semibold pb-3">Nama Pemasok</th>
                        <th class="fw-semibold pb-3">Komoditas (Buah)</th>
                        <th class="fw-semibold pb-3">Total Estimasi</th>
                        <th class="fw-semibold pb-3">Status</th>
                        <th class="fw-semibold pb-3 text-center pe-3">Aksi / Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if( empty($data['asn']) ) : ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted opacity-25 d-block mb-3"></i>
                            <span class="text-muted">Belum ada pengajuan masuk dari pemasok.</span>
                        </td>
                    </tr>
                    <?php else : ?>
                        <?php foreach( $data['asn'] as $asn ) : ?>
                        <tr style="border-bottom: 1px solid #f9fafb;">
                            <td class="ps-3 py-3">
                                <span class="fw-bold text-dark">ASN-<?= str_pad($asn['id_asn'], 3, '0', STR_PAD_LEFT); ?></span>
                            </td>
                            <td class="py-3">
                                <div class="text-dark fw-medium"><?= date('d M Y', strtotime($asn['waktu_rencana_tiba'])); ?></div>
                                <div class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($asn['waktu_rencana_tiba'])); ?> WIB</div>
                            </td>
                            <td class="py-3 fw-medium text-dark"><?= $asn['nama_pemasok']; ?></td>
                            <td class="py-3 text-muted" style="font-size: 0.85rem; max-width: 200px;"><div class="text-truncate" title="<?= $asn['daftar_komoditas']; ?>"><?= $asn['daftar_komoditas']; ?></div></td>
                            <td class="py-3"><strong class="text-green"><?= number_format($asn['total_estimasi'], 2, ',', '.'); ?> Kg</strong></td>
                            
                            <td class="py-3">
                                <?php 
                                    if($asn['status_jadwal'] == 'menunggu') {
                                        echo '<span class="badge badge-soft-warning rounded-pill px-3 fw-medium">Menunggu</span>';
                                    } elseif($asn['status_jadwal'] == 'disetujui') {
                                        echo '<span class="badge badge-soft-primary rounded-pill px-3 fw-medium">Disetujui</span>';
                                    } elseif($asn['status_jadwal'] == 'ditolak') {
                                        echo '<span class="badge badge-soft-danger rounded-pill px-3 fw-medium">Ditolak</span>';
                                    } elseif($asn['status_jadwal'] == 'menunggu_qc') {
                                        echo '<span class="badge badge-soft-info rounded-pill px-3 fw-medium">Diinspeksi QC</span>';
                                    } else {
                                        echo '<span class="badge badge-soft-success rounded-pill px-3 fw-medium">Selesai</span>';
                                    }
                                ?>
                            </td>
                            
                            <td class="py-3 text-center pe-3">
                                <div class="d-flex justify-content-center gap-2">
                                <?php if($asn['status_jadwal'] == 'menunggu') : ?>
                                    <button type="button" class="btn btn-sm btn-green rounded-pill fw-medium px-3" data-bs-toggle="modal" data-bs-target="#modalSetuju" data-url="<?= BASEURL; ?>/admin/setujuiAsn/<?= $asn['id_asn']; ?>"><i class="bi bi-check-lg"></i> Setujui</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill fw-medium px-3" data-bs-toggle="modal" data-bs-target="#modalTolak" data-url="<?= BASEURL; ?>/admin/tolakAsn/<?= $asn['id_asn']; ?>"><i class="bi bi-x-lg"></i> Tolak</button>
                                
                                <?php elseif($asn['status_jadwal'] == 'disetujui') : ?>
                                    <a href="<?= BASEURL; ?>/admin/timbang/<?= $asn['id_asn']; ?>" class="btn btn-sm btn-primary rounded-pill fw-medium px-3"><i class="bi bi-speedometer2"></i> Timbang Truk</a>
                                
                                <?php elseif($asn['status_jadwal'] == 'ditolak') : ?>
                                    <span class="text-muted fw-medium" style="font-size: 0.85rem;"><i class="bi bi-dash-circle me-1"></i> Dibatalkan</span>
                                    
                                <?php else : ?>
                                    <span class="text-muted fw-medium fst-italic" style="font-size: 0.85rem;"><i class="bi bi-arrow-right-circle me-1"></i> Berada di QC</span>
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

<!-- Modal Confirm Setuju -->
<div class="modal fade" id="modalSetuju" tabindex="-1" aria-labelledby="modalSetujuLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalSetujuLabel">Konfirmasi Persetujuan</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-green-light text-green rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                <i class="bi bi-check-circle fs-3"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Setujui Jadwal Ini?</h6>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Truk akan diizinkan masuk ke Loading Dock untuk proses pembongkaran muatan.</p>
            </div>
        </div>
      </div>
      <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-light rounded-pill px-4 fw-medium" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmSetuju" class="btn btn-green rounded-pill px-4 fw-medium">Ya, Setujui</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Confirm Tolak -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalTolakLabel">Konfirmasi Penolakan</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                <i class="bi bi-x-circle fs-3"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Tolak Jadwal Ini?</h6>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Truk tidak akan diizinkan masuk. Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
      </div>
      <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-light rounded-pill px-4 fw-medium" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmTolak" class="btn btn-danger rounded-pill px-4 fw-medium">Ya, Tolak</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalSetuju = document.getElementById('modalSetuju');
    if (modalSetuju) {
        modalSetuju.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            document.getElementById('btnConfirmSetuju').setAttribute('href', url);
        });
    }

    const modalTolak = document.getElementById('modalTolak');
    if (modalTolak) {
        modalTolak.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            document.getElementById('btnConfirmTolak').setAttribute('href', url);
        });
    }
});
</script>