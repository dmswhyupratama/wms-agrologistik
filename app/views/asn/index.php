<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-success"><i class="bi bi-clock-history me-2"></i>Riwayat Pengajuan ASN</h3>
            <?php if( $_SESSION['role'] == 'pemasok' ) : ?>
                <a href="<?= BASEURL; ?>/asn/tambah" class="btn btn-success fw-bold shadow-sm">
                    + Ajukan Jadwal Baru
                </a>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-12">
                <?php Flasher::flash(); ?>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th>Waktu Rencana Tiba</th>
                                <th>Komoditas</th>
                                <th>Estimasi Berat</th>
                                <th>Status Validasi Gudang</th>
                                <th>Instruksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( empty($data['asn']) ) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat pengajuan jadwal.</td>
                            </tr>
                            <?php else : ?>
                                <?php $i = 1; foreach( $data['asn'] as $asn ) : ?>
                                <tr>
                                    <td class="px-4 fw-bold text-secondary"><?= $i++; ?></td>
                                    <td><?= date('d M Y - H:i', strtotime($asn['waktu_rencana_tiba'])); ?> WIB</td>
                                    <td class="fw-medium text-dark"><?= $asn['komoditas']; ?></td>
                                    <td><?= number_format($asn['estimasi_berat_kg'], 2, ',', '.'); ?> Kg</td>
                                    <td>
                                        <?php 
                                            // Pewarnaan Status Dinamis
                                            if($asn['status_jadwal'] == 'menunggu') {
                                                echo '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Menunggu</span>';
                                                $instruksi = "Tunggu konfirmasi admin";
                                            } elseif($asn['status_jadwal'] == 'disetujui') {
                                                echo '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Disetujui</span>';
                                                $instruksi = "<span class='text-success fw-bold'>Kirim armada ke gudang</span>";
                                            } else {
                                                echo '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>';
                                                $instruksi = "<span class='text-danger'>Ajukan jadwal ulang</span>";
                                            }
                                        ?>
                                    </td>
                                    <td><?= $instruksi; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>