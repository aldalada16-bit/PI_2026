<?php
$daftarKost = $daftarKost ?? [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Kost - KostKu</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f7f3ef;
            color: #222;
            padding: 25px 35px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* HEADER & NAVIGATION */
        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .back-btn {
            text-decoration: none;
            color: #222;
            font-size: 28px;
            font-weight: bold;
            line-height: 1;
        }

        .header-title h1 {
            font-size: 24px;
            font-weight: bold;
            color: #111;
        }

        .action-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .btn-tambah {
            background-color: #765238;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-tambah:hover {
            background-color: #5c3e28;
        }

        /* EMPTY STATE CONTAINER */
        .empty-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 40px;
        }

        .icon-circle {
            width: 110px;
            height: 110px;
            background-color: #eaddd7;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 48px;
            color: #765238;
        }

        .empty-state h2 {
            font-size: 18px;
            font-weight: bold;
            color: #111;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 13px;
            color: #777;
            max-width: 320px;
            line-height: 1.5;
        }

        /* KOST LIST (JIKA ADA DATA) */
        .kost-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .kost-card {
            background: white;
            border: 1px solid #d5d0cc;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            gap: 15px;
        }

        .kost-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .kost-info {
            flex: 1;
        }

        .kost-info h3 {
            font-size: 15px;
            margin-bottom: 5px;
        }

        .kost-info p {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }

        .footer-label {
            margin-top: auto;
            text-align: center;
            padding-top: 40px;
            font-size: 16px;
            font-weight: bold;
            color: #e5d8d0;
        }
    </style>
</head>

<body>

    <!-- HEADER TITLE & BACK BUTTON -->
    <div class="header-title">
        <a href="{{ url('/kelola-kost-kamar') }}" class="back-btn">‹</a>
        <h1>Kelola Data Kost</h1>
    </div>

    <!-- TOMBOL TAMBAH DAT A KOST -->
    <div class="action-row">
        <a href="{{ url('/kelola-kost/tambah') }}" class="btn-tambah">+ Tambah Data Kost</a>
    </div>

    <!-- KONDISI DATA KOST -->
    <?php if (empty($daftarKost)): ?>

        <!-- KONDISI JIKA DATA KOSONG (EMPTY STATE) -->
        <div class="empty-state">
            <div class="icon-circle">
                ⌂
            </div>
            <h2>Belum ada data Kost</h2>
            <p>
                Saat ini anda belum menambahkan data kost. Silakan klik tombol diatas untuk menambahkan kost baru
            </p>
        </div>

    <?php else: ?>

        <!-- KONDISI JIKA ADA DATA KOST -->
        <div class="kost-grid">
            <?php foreach ($daftarKost as $kost): ?>
                <div class="kost-card">
                    <?php if (!empty($kost['foto_kost'])): ?>
                        <img src="<?= htmlspecialchars($kost['foto_kost']) ?>" alt="Foto Kost">
                    <?php else: ?>
                        <div style="width: 80px; height: 80px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #888;">No Image</div>
                    <?php endif; ?>

                    <div class="kost-info">
                        <h3><?= htmlspecialchars($kost['nama_kost']) ?></h3>
                        <p><?= htmlspecialchars($kost['alamat']) ?></p>
                        <a href="index.php?page=edit_kost&id=<?= $kost['id_kost'] ?>" style="font-size: 12px; color: #765238; font-weight: bold; text-decoration: none;">Edit Kost ›</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <div class="footer-label">
        Kelola Kost
    </div>

</body>

</html>