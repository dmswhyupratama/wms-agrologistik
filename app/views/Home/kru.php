<div class="container-fluid mt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-success">Halo, <?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?>! 👋</h2>
            <p class="text-muted">Selamat bertugas. Berikut ringkasan aktivitas lapanganmu hari ini.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="row mb-4 g-3">
        <div class="col-6">
            <div class="card bg-primary text-white shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-3 text-center">
                    <i class="bi bi-list-task fs-1 mb-2"></i>
                    <h2 class="fw-bold mb-0"><?= $data['tugas_picking']; ?></h2>
                    <p class="small mb-0 opacity-75">Tugas Picking</p>
                </div>
                <a href="<?= BASEURL; ?>/outbound" class="card-footer bg-dark bg-opacity-25 text-white text-center text-decoration-none border-0 rounded-bottom-4 small fw-bold">
                    Lihat Tugas <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>
        <div class="col-6">
            <div class="card bg-success text-white shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-3 text-center">
                    <i class="bi bi-boxes fs-1 mb-2"></i>
                    <h2 class="fw-bold mb-0"><i class="bi bi-search"></i></h2>
                    <p class="small mb-0 opacity-75">Cari Rak / Stok</p>
                </div>
                <a href="<?= BASEURL; ?>/stok" class="card-footer bg-dark bg-opacity-25 text-white text-center text-decoration-none border-0 rounded-bottom-4 small fw-bold">
                    Buka Fitur <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-white p-3 rounded-top-4">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-thermometer-half me-2"></i>Catat Suhu Ruangan</h6>
                </div>
                <div class="card-body p-4">
                    <form action="<?= BASEURL; ?>/home/simpanLogSuhu" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Pilih Ruang Penyimpanan <span class="text-danger">*</span></label>
                            <select class="form-select fw-medium" name="id_ruangan" required>
                                <option value="" selected disabled>-- Pilih Ruangan --</option>
                                <?php foreach($data['ruangan'] as $r) : ?>
                                    <option value="<?= $r['id_ruangan']; ?>"><?= $r['kode_ruangan']; ?> (<?= $r['nama_ruangan']; ?>)</option>
                                <?php endforeach; ?> 
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-dark">Suhu Tercatat di Termostat (°C) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.1" class="form-control text-center fw-bold text-primary" name="suhu_tercatat" placeholder="0.0" required>
                                <span class="input-group-text bg-light text-muted fw-bold">°C</span>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold rounded-pill text-dark shadow-sm">
                                <i class="bi bi-save2 me-2"></i>Simpan Log Suhu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h6 class="fw-bold text-muted mb-3"><i class="bi bi-clock-history me-2"></i>Log Terakhir Hari Ini</h6>
            
            <?php if(empty($data['riwayat_suhu'])) : ?>
                <div class="alert alert-light text-center text-muted border-0 shadow-sm rounded-4 py-4">
                    <i class="bi bi-wind fs-2 d-block mb-2"></i>
                    Belum ada pencatatan suhu hari ini.
                </div>
            <?php else : ?>
                <div class="list-group shadow-sm rounded-4 border-0">
                    <?php foreach($data['riwayat_suhu'] as $log) : ?>
                        <?php 
                            // LOGIKA DETEKSI ANOMALI SUHU
                            // 1. Bersihkan string "°C" dari database (misal: "0°C - 2°C" jadi "0 - 2")
                            $rentang_bersih = str_replace('°C', '', $log['rentang_suhu']);
                            
                            // 2. Pecah batas minimum dan maksimum berdasarkan tanda strip "-"
                            $batas = explode('-', $rentang_bersih);
                            $min_suhu = (float)trim($batas[0]);
                            $max_suhu = (float)trim($batas[1]);
                            $suhu_aktual = (float)$log['suhu_celcius'];

                            // 3. Tentukan apakah suhu keluar jalur
                            $is_abnormal = ($suhu_aktual < $min_suhu || $suhu_aktual > $max_suhu);
                        ?>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center p-3 border-0 border-bottom <?= $is_abnormal ? 'bg-danger-subtle' : ''; ?>">
                            <div>
                                <h6 class="mb-1 fw-bold <?= $is_abnormal ? 'text-danger' : 'text-dark'; ?>">
                                    <?= $log['kode_ruangan']; ?> 
                                    <span class="badge bg-light text-secondary border fw-normal ms-1"><?= $log['rentang_suhu']; ?></span>
                                </h6>
                                
                                <small class="text-muted d-block mb-1">
                                    <i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($log['waktu_catat'])); ?> &nbsp;|&nbsp; 
                                    <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($log['waktu_catat'])); ?> WIB
                                </small>

                                <?php if($is_abnormal) : ?>
                                    <div class="text-danger small fw-bold mt-1">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>Suhu di luar batas aman!
                                    </div>
                                <?php endif; ?>
                            </div>

                            <span class="badge <?= $is_abnormal ? 'bg-danger' : 'bg-info text-dark border-info-subtle'; ?> rounded-pill fs-6 px-3 border shadow-sm">
                                <?= number_format($suhu_aktual, 1, ',', '.'); ?> °C
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>