<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <?php Flasher::flash(); ?>
            <h2 class="fw-bold text-success"><i class="bi bi-box-seam me-2"></i>Manajemen Inbound Pemasok</h2>
            <p class="text-muted">Lakukan validasi jadwal kedatangan armada sebelum truk memasuki area Loading Dock Gudang.</p>
            <hr>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3 px-4">Jadwal Tiba</th>
                            <th>Nama Pemasok</th>
                            <th>Komoditas (Buah)</th>
                            <th>Total Estimasi (Kg)</th>
                            <th>Status Validasi</th>
                            <th class="text-center">Aksi / Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if( empty($data['asn']) ) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada pengajuan masuk dari pemasok.</td>
                        </tr>
                        <?php else : ?>
                            <?php foreach( $data['asn'] as $asn ) : ?>
                            <tr>
                                <td class="px-4 fw-bold"><?= date('d M Y', strtotime($asn['waktu_rencana_tiba'])); ?><br><span class="badge bg-light text-dark"><?= date('H:i', strtotime($asn['waktu_rencana_tiba'])); ?> WIB</span></td>
                                
                                <td class="fw-medium text-primary"><?= $asn['nama_pemasok']; ?></td>
                                <td class="text-secondary"><?= $asn['daftar_komoditas']; ?></td>
                                <td><strong class="text-success"><?= number_format($asn['total_estimasi'], 2, ',', '.'); ?> Kg</strong></td>
                                
                                <td>
                                    <?php 
                                        if($asn['status_jadwal'] == 'menunggu') {
                                            echo '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Menunggu</span>';
                                        } elseif($asn['status_jadwal'] == 'disetujui') {
                                            echo '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Disetujui</span>';
                                        } elseif($asn['status_jadwal'] == 'ditolak') {
                                            echo '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>';
                                        } elseif($asn['status_jadwal'] == 'menunggu_qc') {
                                            echo '<span class="badge bg-info text-dark"><i class="bi bi-search"></i> Diinspeksi QC</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary"><i class="bi bi-check2-all"></i> Selesai</span>';
                                        }
                                    ?>
                                </td>
                                
                                <td class="text-center">
                                    <?php if($asn['status_jadwal'] == 'menunggu') : ?>
                                        <a href="<?= BASEURL; ?>/admin/setujuiAsn/<?= $asn['id_asn']; ?>" class="btn btn-sm btn-success fw-bold me-1" onclick="return confirm('Setujui jadwal masuk truk ini?');"><i class="bi bi-check-lg"></i> Setujui</a>
                                        <a href="<?= BASEURL; ?>/admin/tolakAsn/<?= $asn['id_asn']; ?>" class="btn btn-sm btn-outline-danger fw-bold" onclick="return confirm('Tolak jadwal masuk truk ini?');"><i class="bi bi-x-lg"></i> Tolak</a>
                                    
                                    <?php elseif($asn['status_jadwal'] == 'disetujui') : ?>
                                        <a href="<?= BASEURL; ?>/admin/timbang/<?= $asn['id_asn']; ?>" class="btn btn-sm btn-primary fw-bold"><i class="bi bi-speedometer2"></i> Timbang Truk</a>
                                    
                                    <?php elseif($asn['status_jadwal'] == 'ditolak') : ?>
                                        <span class="text-muted"><i class="bi bi-dash-circle"></i> Dibatalkan</span>
                                        
                                    <?php else : ?>
                                        <span class="text-muted fst-italic"><i class="bi bi-arrow-right-circle"></i> Berada di QC</span>
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