<div class="container-fluid mt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-people-fill me-2"></i>Manajemen Pegawai</h2>
                <p class="text-muted">Kelola akses *login* untuk Kru Lapangan, Quality Control, dan Admin Gudang.</p>
            </div>
            <button type="button" class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPegawai">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Pegawai
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Lengkap</th>
                            <th>Username</th>
                            <th>Jabatan (Role)</th>
                            <th>Status Akses</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['pegawai'] as $p) : ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= $p['nama_lengkap']; ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $p['username']; ?></span></td>
                                <td>
                                    <?php 
                                        if($p['role'] == 'kru_lapangan') echo 'Kru Lapangan';
                                        elseif($p['role'] == 'qc') echo 'Quality Control';
                                        elseif($p['role'] == 'admin_gudang') echo 'Admin Gudang';
                                    ?>
                                </td>
                                <td>
                                    <?php if($p['is_active'] == 1) : ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-x-circle me-1"></i>Non-aktif (Resign)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if($p['is_active'] == 1) : ?>
                                        <a href="<?= BASEURL; ?>/pegawai/nonaktif/<?= $p['id_user']; ?>" class="btn btn-sm btn-outline-danger fw-bold" onclick="return confirm('Cabut akses login pegawai ini secara permanen?');">
                                            <i class="bi bi-person-dash-fill me-1"></i>Cabut Akses
                                        </a>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-secondary fw-bold" disabled>Dinonaktifkan</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modalTambahPegawai" tabindex="-1" aria-labelledby="modalTambahPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-success text-white border-0 rounded-top-4">
                <h5 class="modal-title fw-bold" id="modalTambahPegawaiLabel"><i class="bi bi-person-plus me-2"></i>Registrasi Pegawai Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= BASEURL; ?>/pegawai/tambah" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_lengkap" required autocomplete="off">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required autocomplete="off" placeholder="Gunakan huruf kecil tanpa spasi">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password Awal <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Jabatan (Role) <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="" selected disabled>-- Pilih Jabatan --</option>
                            <option value="kru_lapangan">Kru Lapangan (Operasional Fisik)</option>
                            <option value="qc">Quality Control (Inspeksi)</option>
                            <option value="admin_gudang">Admin Gudang (Inbound/Outbound)</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success fw-bold rounded-pill">Simpan & Aktifkan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>