<?php
$nama = $_SESSION["nama"] ?? "Bapak/Ibu Pemilik";
$totalKamar = $totalKamar ?? 0;
$daftarKamar = $daftarKamar ?? [];
$totalBooking = $totalBooking ?? 0;
$daftarBooking = $daftarBooking ?? [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik Kost - KostKu</title>

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
            width: 240px;
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
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 30px;
            padding-left: 5px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.2;
        }

        .menu a:hover,
        .menu a.active {
            background-color: #d9a17e;
        }

        .menu-icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .logout {
            margin-top: auto;
        }

        .logout a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            font-size: 14px;
            font-weight: bold;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 25px 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .welcome h1 {
            font-size: 24px;
            color: #111;
            margin-bottom: 4px;
        }

        .welcome p {
            color: #888;
            font-size: 13px;
            font-weight: bold;
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #555;
            font-size: 18px;
        }

        .date-badge {
            font-size: 11px;
            color: #888;
            font-weight: bold;
        }

        /* SUMMARY CARDS */
        .summary {
            display: flex;
            gap: 25px;
            margin-bottom: 30px;
        }

        .summary-card {
            background-color: white;
            border: 1px solid #e0dad5;
            border-radius: 6px;
            padding: 18px 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            width: 280px;
        }

        .summary-icon {
            font-size: 32px;
            color: #765238;
        }

        .summary-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .summary-title {
            color: #666;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .summary-number {
            font-size: 26px;
            font-weight: bold;
            color: #111;
        }

        .summary-desc {
            color: #777;
            font-size: 11px;
            font-weight: bold;
            margin-top: 2px;
        }

        /* SECTIONS & TABLES */
        .card-box {
            background: white;
            border: 1px solid #e0dad5;
            border-radius: 8px;
            padding: 18px 20px;
            margin-bottom: 20px;
        }

        .box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .box-header h2 {
            font-size: 14px;
            color: #111;
            font-weight: bold;
        }

        .lihat-semua {
            color: #777;
            font-size: 12px;
            text-decoration: none;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        th, td {
            padding: 10px 8px;
        }

        th {
            color: #222;
            font-weight: bold;
            border-bottom: 1px solid #eee;
        }

        td {
            color: #333;
        }

        .status-tersedia {
            color: #23833b;
            font-weight: bold;
        }

        .status-terisi {
            color: #a94442;
            font-weight: bold;
        }

        .status-menunggu {
            color: #d9832e;
            font-weight: bold;
        }

        .status-dikonfirmasi {
            color: #23833b;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="logo">
                <span>⌂</span>
                <span>KostKu</span>
            </div>

            <nav class="menu">

                <a href="index.php?page=dashboard" class="active">
                    <span class="menu-icon">⌂</span>
                    <span>Dashboard</span>
                </a>

                <a href="/kelola-kost-kamar">
                    <span class="menu-icon">▤</span>
                    <span>Kelola Data Kost & Kamar</span>
                </a>

                <a href="index.php?page=memproses_booking">
                    <span class="menu-icon">📅</span>
                    <span>Memproses Booking</span>
                </a>

                <a href="index.php?page=pembayaran">
                    <span class="menu-icon">💳</span>
                    <span>Pembayaran</span>
                </a>

                <a href="index.php?page=profil">
                    <span class="menu-icon">👤</span>
                    <span>Profil Kost</span>
                </a>

            </nav>

            <div class="logout">
                <a href="index.php?page=logout">
                    <span class="menu-icon">↪</span>
                    <span>Logout</span>
                </a>
            </div>

        </aside>


        <!-- CONTENT -->
        <main class="content">

            <!-- HEADER -->
            <div class="header">

                <div class="welcome">
                    <h1>Dashboard Pemilik Kost</h1>
                    <p>Selamat datang, <?= htmlspecialchars($nama) ?></p>
                </div>

                <div class="header-icons">
                    <span>📅</span>
                    <span>🔔</span>
                    <span>👤</span>
                </div>

            </div>


            <!-- SUMMARY -->
            <div class="summary">

                <div class="summary-card">
                    <div class="summary-icon">⌂</div>
                    <div class="summary-info">
                        <span class="summary-title">Total Kamar</span>
                        <span class="summary-number"><?= $totalKamar ?></span>
                        <span class="summary-desc">Kamar tersedia</span>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon">📅</div>
                    <div class="summary-info">
                        <span class="summary-title">Booking Masuk</span>
                        <span class="summary-number"><?= $totalBooking ?></span>
                        <span class="summary-desc">Dalam proses</span>
                    </div>
                </div>

            </div>


            <!-- DAFTAR KAMAR -->
            <div class="card-box">

                <div class="box-header">
                    <h2>Daftar Kamar</h2>
                    <a href="index.php?page=kelola_kost" class="lihat-semua">Lihat semua ›</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Nomor Kamar</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($daftarKamar)): ?>
                            <?php $no = 1; foreach ($daftarKamar as $kamar): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($kamar['nama_kamar'] ?? $kamar['nomor_kamar'] ?? 'Kamar') ?></strong></td>
                                    <td>Rp. <?= number_format($kamar['harga'] ?? 0, 0, ',', '.') ?>/bulan</td>
                                    <td>
                                        <?php if (($kamar['status'] ?? '') == 'Terisi'): ?>
                                            <span class="status-terisi">Terisi</span>
                                        <?php else: ?>
                                            <span class="status-tersedia">Tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="color: #888; text-align: center; padding: 15px;">Belum ada kamar yang terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>


            <!-- BOOKING TERBARU -->
            <div class="card-box">

                <div class="box-header">
                    <h2>Booking Terbaru</h2>
                    <a href="index.php?page=memproses_booking" class="lihat-semua">Lihat semua ›</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Penyewa</th>
                            <th>Kamar</th>
                            <th>Tanggal Booking</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($daftarBooking)): ?>
                            <?php foreach ($daftarBooking as $b): ?>
                                <tr>
                                    <td><?= htmlspecialchars($b['nama_penyewa'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($b['kamar'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($b['tanggal_booking'] ?? '-') ?></td>
                                    <td>
                                        <?php if (($b['status'] ?? '') == 'Dikonfirmasi'): ?>
                                            <span class="status-dikonfirmasi">Dikonfirmasi</span>
                                        <?php else: ?>
                                            <span class="status-menunggu">Menunggu Konfirmasi</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="color: #888; text-align: center; padding: 15px;">Belum ada data booking masuk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

        </main>

    </div>

</body>

</html>