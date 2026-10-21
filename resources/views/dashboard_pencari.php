<?php
$nama = $_SESSION["nama"] ?? "Pengguna";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KostKu</title>

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
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background-color: #765238;
            color: white;
            padding: 22px 15px;
            display: flex;
            flex-direction: column;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            padding-left: 5px;
        }

        .logo-icon {
            font-size: 30px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 13px 12px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            gap: 13px;
            font-size: 14px;
            font-weight: bold;
        }

        .menu a:hover,
        .menu a.active {
            background-color: #d9a17e;
        }

        .menu-icon {
            width: 22px;
            text-align: center;
            font-size: 20px;
        }

        .logout {
            margin-top: auto;
        }

        .logout a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 12px;
            font-size: 14px;
            font-weight: bold;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 20px 25px;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .welcome h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .welcome p {
            color: #888;
            font-size: 13px;
            font-weight: bold;
        }

        .header-icons {
            display: flex;
            gap: 20px;
            font-size: 20px;
        }

        /* SEARCH */
        .search-box {
            margin-top: 25px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            height: 42px;
            border: 1px solid #d4d0cc;
            border-radius: 8px;
            padding: 0 45px 0 15px;
            outline: none;
            background: white;
        }

        .search-box span {
            position: absolute;
            right: 15px;
            top: 11px;
            color: #888;
            font-size: 18px;
        }

        /* SUMMARY */
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 30px;
        }

        .summary-card {
            background-color: white;
            border: 1px solid #d5d0cc;
            min-height: 82px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .summary-icon {
            font-size: 28px;
            color: #765238;
        }

        .summary-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .summary-title {
            color: #777;
            font-size: 11px;
            font-weight: bold;
        }

        .summary-number {
            font-size: 21px;
            font-weight: bold;
        }

        .summary-desc {
            color: #777;
            font-size: 10px;
            font-weight: bold;
        }

        /* REKOMENDASI */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 35px;
            margin-bottom: 12px;
        }

        .section-header h2 {
            font-size: 14px;
        }

        .lihat-semua {
            color: #777;
            font-size: 11px;
            text-decoration: none;
        }

        .kost-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .kost-card {
            background-color: white;
            border: 1px solid #d5d0cc;
            border-radius: 7px;
            padding: 10px;
            display: flex;
            gap: 12px;
            position: relative;
        }

        .kost-image {
            width: 62px;
            height: 62px;
            background-color: #ddd;
            border-radius: 6px;
            object-fit: cover;
        }

        .kost-info {
            flex: 1;
        }

        .kost-name {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kost-location {
            color: #777;
            font-size: 9px;
            margin-bottom: 7px;
        }

        .kost-price {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .kost-facilities {
            color: #777;
            font-size: 9px;
        }

        .favorite {
            position: absolute;
            right: 10px;
            top: 8px;
            color: #777;
            font-size: 17px;
        }

        .available {
            color: #23833b;
            font-size: 10px;
            font-weight: bold;
            margin-top: 8px;
        }

        /* RESPONSIVE */
        @media (max-width: 800px) {

            .sidebar {
                width: 180px;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .kost-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {

            .sidebar {
                width: 65px;
                padding: 20px 8px;
            }

            .logo {
                justify-content: center;
            }

            .logo-text,
            .menu-text,
            .logout-text {
                display: none;
            }

            .menu a,
            .logout a {
                justify-content: center;
            }

            .content {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="logo">
                <span class="logo-icon">⌂</span>
                <span class="logo-text">KostKu</span>
            </div>

            <nav class="menu">

                <a href="index.php?page=dashboard" class="active">
                    <span class="menu-icon">⌂</span>
                    <span class="menu-text">Dashboard</span>
                </a>

                <a href="index.php?page=cari_kost">
                    <span class="menu-icon">⌕</span>
                    <span class="menu-text">Cari Kost</span>
                </a>

                <a href="index.php?page=riwayat">
                    <span class="menu-icon">◷</span>
                    <span class="menu-text">Riwayat Booking</span>
                </a>

                <a href="index.php?page=profil">
                    <span class="menu-icon">♙</span>
                    <span class="menu-text">Profil</span>
                </a>

            </nav>

            <div class="logout">
                <a href="index.php?page=logout">
                    <span class="menu-icon">↪</span>
                    <span class="logout-text">Logout</span>
                </a>
            </div>

        </aside>


        <!-- CONTENT -->
        <main class="content">

            <!-- HEADER -->
            <div class="header">

                <div class="welcome">
                    <h1>Halo, <?= htmlspecialchars($nama) ?>!</h1>
                    <p>Temukan kost terbaik sesuai kebutuhanmu</p>
                </div>

                <div class="header-icons">
                    <span>♧</span>
                    <span>♙</span>
                </div>

            </div>


            <!-- SEARCH -->
            <div class="search-box">

                <input type="text" placeholder="Cari kost, lokasi, atau fasilitas...">

                <span>⌕</span>

            </div>


            <!-- SUMMARY -->
            <div class="summary">

                <div class="summary-card">

                    <div class="summary-icon">⌂</div>

                    <div class="summary-info">
                        <span class="summary-title">Booking Aktif</span>
                        <span class="summary-number">0</span>
                        <span class="summary-desc">Dalam proses</span>
                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon">◷</div>

                    <div class="summary-info">
                        <span class="summary-title">Riwayat Booking</span>
                        <span class="summary-number">0</span>
                        <span class="summary-desc">Pernah melakukan booking</span>
                    </div>

                </div>


                <div class="summary-card">

                    <div class="summary-icon">♙</div>

                    <div class="summary-info">
                        <span class="summary-title">Profil</span>
                        <span class="summary-desc">Lengkapi profilmu</span>
                    </div>

                </div>

            </div>

<!-- REKOMENDASI -->
            <div class="section-header">
                <h2>Rekomendasi Kost</h2>
                <a href="index.php?page=cari_kost" class="lihat-semua">
                    Lihat semua →
                </a>
            </div>

            <div class="kost-list">
                <?php if (!empty($daftarKost) && is_array($daftarKost)): ?>
                    <?php foreach ($daftarKost as $kost): ?>
                        <div class="kost-card">
                            <div class="kost-image">
                                <?php if (!empty($kost['foto_kost'])): ?>
                                    <img src="<?= htmlspecialchars($kost['foto_kost']) ?>"
                                         alt="<?= htmlspecialchars($kost['nama_kost']) ?>"
                                         style="width:100%; height:100%; object-fit:cover; border-radius:6px;">
                                <?php else: ?>
                                    <div style="width:100%; height:100%; background:#ddd; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#777;">No Foto</div>
                                <?php endif; ?>
                            </div>

                            <div class="kost-info">
                                <div class="kost-name">
                                    <?= htmlspecialchars($kost['nama_kost'] ?? 'Nama Kost') ?>
                                </div>

                                <div class="kost-location">
                                    ◉ <?= htmlspecialchars($kost['alamat'] ?? '-') ?>
                                </div>

                                <div class="kost-facilities">
                                    ♧ <?= htmlspecialchars($kost['fasilitas'] ?? '-') ?>
                                </div>

                                <div class="available">
                                    <?= htmlspecialchars($kost['kamar_tersedia'] ?? 'Tersedia') ?>
                                </div>
                            </div>

                            <div class="favorite">♡</div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p>Tidak ada kost yang tersedia.</p>
                <?php endif; ?>
            </div>

        </main>

    </div>

</body>

</html>