<!-- Mengatur tinggi minimum area agar bisa persis di tengah (vertikal & horizontal) -->
<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    
    <!-- Memperbesar ukuran form: di layar besar (lg) ambil 6 kolom, menengah (md) 8 kolom -->
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-4">
            
            <!-- Header diperlebar (py-4) dan teks dibesarkan (h4) -->
            <div class="card-header bg-success text-white text-center py-4 rounded-top-4">
                <h4 class="mb-0 fw-bold">🔒 Portal Login Sistem</h4>
            </div>
            
            <!-- Padding dalam card dibesarkan (p-5) -->
            <div class="card-body p-5">
                
                <!-- TEMPATKAN FLASHER DI SINI -->
                <div class="row">
                    <div class="col-12">
                        <?php Flasher::flash(); ?>
                    </div>
                </div>
                
                <form action="<?= BASEURL; ?>/auth/prosesLogin" method="POST">
                    
                    <div class="mb-4">
                        <label for="username" class="form-label fw-bold fs-5">Username</label>
                        <!-- Class form-control-lg untuk memperbesar kotak input -->
                        <input type="text" class="form-control form-control-lg" id="username" name="username" required autocomplete="off" placeholder="Masukkan username Anda">
                    </div>
                    
                    <div class="mb-5">
                        <label for="password" class="form-label fw-bold fs-5">Password</label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" required placeholder="Masukkan password Anda">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <!-- Tombol dibuat lebih tebal dan besar (py-3) -->
                        <button type="submit" class="btn btn-success btn-lg fs-5 fw-bold py-3 shadow-sm">Masuk ke Sistem</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>