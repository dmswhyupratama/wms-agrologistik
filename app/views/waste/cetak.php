<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <style>
        /* CSS Khusus untuk Kertas Cetak */
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; line-height: 1.5; margin: 0; padding: 20px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 10pt; }
        .judul-laporan { text-align: center; font-weight: bold; font-size: 14pt; margin-bottom: 20px; text-decoration: underline; }
        
        .summary-box { width: 100%; margin-bottom: 20px; }
        .summary-box table { border: none; width: 50%; }
        .summary-box td { border: none; padding: 2px 5px; }

        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 10pt; }
        .table-data th, .table-data td { border: 1px solid #000; padding: 8px; }
        .table-data th { background-color: #f2f2f2; text-align: center; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .signature-box { width: 100%; margin-top: 40px; }
        .signature-box table { border: none; width: 100%; text-align: center; }
        .signature-box td { border: none; width: 33%; padding-top: 80px; }
        
        /* Tombol print disembunyikan saat layar benar-benar dicetak ke kertas */
        @media print {
            .no-print { display: none; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #198754; color: white; border: none; cursor: pointer;">🖨️ Cetak / Save PDF Sekarang</button>
    </div>

    <div class="kop-surat">
        <h1>AGROLOGISTIK NUSANTARA</h1>
        <p>Jl. Raya Agrologistik No. 88, Kawasan Industri Terpadu<br>
        Email: operasional@agrologistik.co.id | Telp: (021) 1234567</p>
    </div>

    <div class="judul-laporan">
        LAPORAN EVALUASI PENYUSUTAN (WASTE) KOMODITAS
    </div>

    <div class="summary-box">
        <table>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>: <?= date('d F Y'); ?></td>
            </tr>
            <tr>
                <td><strong>Total Stok Aktif (Gudang)</strong></td>
                <td>: <?= number_format($data['statistik']['total_stok'], 2, ',', '.'); ?> Kg</td>
            </tr>
            <tr>
                <td><strong>Total Limbah Dimusnahkan</strong></td>
                <td>: <?= number_format($data['statistik']['total_waste'], 2, ',', '.'); ?> Kg</td>
            </tr>
            <tr>
                <td><strong>Persentase Susut Harian</strong></td>
                <td>: <strong><?= number_format($data['statistik']['persentase'], 2, ',', '.'); ?> %</strong> 
                    <?php if($data['statistik']['is_alert']) echo "(PERINGATAN: Melebihi Batas Toleransi 5%)"; ?>
                </td>
            </tr>
        </table>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Waktu & Tanggal</th>
                <th width="20%">Komoditas (SKU)</th>
                <th width="25%">Alasan Penyusutan</th>
                <th width="10%">Dilaporkan</th>
                <th width="10%">Recovery</th>
                <th width="15%">Pemusnahan Final</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($data['laporan'])) : ?>
                <tr>
                    <td colspan="7" class="text-center">TIDAK ADA DATA PEMUSNAHAN BARANG.</td>
                </tr>
            <?php else : ?>
                <?php $no = 1; foreach($data['laporan'] as $log) : ?>
                    <?php $limbah_murni = $log['berat_susut_kg'] - $log['berat_recovery_kg']; ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center">
                            <?= date('d/m/Y', strtotime($log['waktu_catat'])); ?><br>
                            <?= date('H:i', strtotime($log['waktu_catat'])); ?> WIB
                        </td>
                        <td>
                            <strong><?= $log['komoditas']; ?></strong><br>
                            <small><?= $log['kode_sku']; ?></small>
                        </td>
                        <td><?= $log['keterangan_ng']; ?></td>
                        <td class="text-right"><?= number_format($log['berat_susut_kg'], 2, ',', '.'); ?> Kg</td>
                        <td class="text-right"><?= number_format($log['berat_recovery_kg'], 2, ',', '.'); ?> Kg</td>
                        <td class="text-right"><strong><?= number_format($limbah_murni, 2, ',', '.'); ?> Kg</strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="signature-box">
        <table>
            <tr>
                <td>
                    Disetujui Oleh,<br><strong>Manajer Operasional</strong>
                    <br><br><br><br><br>
                    ( <?= $_SESSION['nama_lengkap']; ?> )
                </td>
                <td>
                    <br><strong>Quality Control (QC)</strong>
                    <br><br><br><br><br>
                    ( .................................... )
                </td>
                <td>
                    Mengetahui,<br><strong>Direktur Utama</strong>
                    <br><br><br><br><br>
                    ( .................................... )
                </td>
            </tr>
        </table>
    </div>

</body>
</html>