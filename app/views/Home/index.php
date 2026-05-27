<?php /** @var array $data */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
</head>
<body>
    <h1>Selamat Datang di WMS Agrologistik Nusantara</h1>
    <p>Pondasi arsitektur Model-View-Controller (MVC) berhasil dikonfigurasi dengan sukses!</p>

    <hr>
    
    <h3>Daftar Pengguna Sistem (Test Database):</h3>
    <ul>
        <?php foreach( $data['users'] as $user ) : ?>
            <li>
                Nama: <strong><?= $user['nama_lengkap']; ?></strong> 
                (Role: <?= $user['role']; ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>