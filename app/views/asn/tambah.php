<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-4">
            <a href="<?= BASEURL; ?>/home" class="btn btn-outline-secondary btn-sm me-3"><i class="bi bi-arrow-left"></i> Kembali</a>
            <h3 class="fw-bold text-success mb-0">Form Pengajuan Pra-Inbound</h3>
        </div>

        <div class="card shadow-sm border-0 rounded-4 border-top border-success border-4">
            <div class="card-body p-4 p-md-5">
                <form id="form-asn" action="<?= BASEURL; ?>/asn/prosesTambah" method="POST">
                    
                    <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2">1. Input Jadwal Tiba Armada</h5>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-medium">Tanggal Rencana Tiba</label>
                            <input type="date" class="form-control form-control-lg bg-light" id="tanggal" name="tanggal" min="<?= date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="jam" class="form-label fw-medium">Jam Kedatangan</label>
                            <input type="time" class="form-control form-control-lg bg-light" id="jam" name="jam" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-end border-bottom pb-2 mb-4">
                        <h5 class="fw-bold text-secondary mb-0">2. Rincian Muatan Buah Segar</h5>
                        <button type="button" id="btn-tambah-baris" class="btn btn-sm btn-outline-success fw-bold">
                            <i class="bi bi-plus-lg"></i> Tambah Buah
                        </button>
                    </div>

                    <div id="komoditas-container">
                        <div class="row mb-3 komoditas-row bg-white border rounded-3 p-3 position-relative shadow-sm align-items-end">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Pilih Buah</label>
                                <select class="form-select form-select-lg bg-light" name="komoditas[]" required>
                                    <option value="" disabled selected>-- Pilih Komoditas --</option>
                                    <option value="Apel Fuji">Apel Fuji</option>
                                    <option value="Jeruk Mandarin">Jeruk Mandarin</option>
                                    <option value="Pisang Cavendish">Pisang Cavendish</option>
                                </select>
                            </div>
                            <div class="col-md-5 mt-3 mt-md-0">
                                <label class="form-label fw-medium">Estimasi Berat (Kg)</label>
                                <div class="input-group input-group-lg">
                                    <input type="number" step="0.01" class="form-control bg-light" name="estimasi_berat_kg[]" required placeholder="Contoh: 600">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end justify-content-center mt-3 mt-md-0 btn-hapus-container">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-success btn-lg fw-bold py-3 shadow-sm">
                            <i class="bi bi-send-check me-2"></i> Submit Data ASN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi Repeater Tambah Baris
    document.getElementById('btn-tambah-baris').addEventListener('click', function() {
        const container = document.getElementById('komoditas-container');
        const firstRow = container.querySelector('.komoditas-row');
        
        const newRow = firstRow.cloneNode(true);

        // Kosongkan nilai select dan input berat
        newRow.querySelector('select').value = '';
        newRow.querySelector('input').value = '';

        // Tambahkan tombol hapus
        const btnHapusContainer = newRow.querySelector('.btn-hapus-container');
        btnHapusContainer.innerHTML = '<button type="button" class="btn btn-outline-danger btn-lg btn-hapus" title="Hapus Baris"><i class="bi bi-trash3-fill"></i></button>';

        btnHapusContainer.querySelector('.btn-hapus').addEventListener('click', function() {
            newRow.remove();
        });

        container.appendChild(newRow);
    });

    // Validasi Cegah Duplikat sebelum Submit
    document.getElementById('form-asn').addEventListener('submit', function(e) {
        const selects = document.querySelectorAll('select[name="komoditas[]"]');
        let selectedValues = [];
        let hasDuplicate = false;

        selects.forEach(function(select) {
            let value = select.value;
            if (value && selectedValues.includes(value)) {
                hasDuplicate = true;
            } else {
                selectedValues.push(value);
            }
        });

        if (hasDuplicate) {
            e.preventDefault(); 
            alert('Peringatan: Terdapat komoditas buah yang sama diinput lebih dari satu kali! Silakan gabungkan estimasi beratnya dalam satu baris, atau hapus baris yang berlebih.');
        }
    });
</script>