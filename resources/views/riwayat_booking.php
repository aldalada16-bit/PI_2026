
<?php
$namaSession = session('nama', 'Pengguna');

$nama = htmlspecialchars(
    $namaSession ?: 'Pengguna',
    ENT_QUOTES,
    'UTF-8'
);

// Data booking contoh sementara
$riwayatBooking = [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Booking | KostKu</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f7f3ef;
            color: #403126;
        }

        .sidebar {
            width: 245px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #765238;
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        .tagline {
            color: #e7d7c9;
            font-size: 12px;
            margin-top: 7px;
            margin-bottom: 38px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #f8eee5;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .menu a:hover,
        .menu a.active {
            background: #9b7656;
        }

        .menu-icon {
            width: 23px;
            text-align: center;
            font-size: 18px;
        }

        .logout {
            margin-top: auto;
            padding-top: 25px;
        }

        .logout button {
            width: 100%;
            padding: 13px;
            background: #5c3c29;
            border: none;
            border-radius: 9px;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .main {
            margin-left: 245px;
            padding: 35px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .topbar h1 {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .muted {
            color: #8c7b6d;
            font-size: 14px;
            line-height: 1.6;
        }

        .user {
            background: white;
            border-radius: 10px;
            padding: 13px 18px;
            font-size: 14px;
            white-space: nowrap;
        }

        .intro {
            background: #e9d9c8;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 28px;
        }

        .intro h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .intro p {
            color: #725b48;
            font-size: 14px;
            line-height: 1.7;
        }

        .content-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 3px 14px #00000008;
        }

        .content-card h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .empty {
            text-align: center;
            padding: 40px 20px;
            color: #8c7b6d;
            line-height: 1.8;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .empty h3 {
            color: #403126;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .btn {
            display: inline-block;
            margin-top: 18px;
            padding: 12px 20px;
            background: #765238;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn:hover {
            background: #5c3c29;
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }

            .tagline {
                margin-bottom: 20px;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 5px;
            }

            .menu a {
                margin-bottom: 0;
            }

            .logout {
                margin-top: 10px;
            }

            .main {
                margin-left: 0;
                padding: 22px 16px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<aside class="sidebar">

    <div class="logo">KostKu</div>
    <div class="tagline">Temukan tempat tinggalmu</div>

    <nav class="menu">
        <a href="/dashboard/pencari">
            <span class="menu-icon">🏠</span>
            Dashboard
        </a>

        <a href="/cari-kost">
            <span class="menu-icon">🔎</span>
            Cari Kost
        </a>

        <a href="/riwayat-booking" class="active">
            <span class="menu-icon">📋</span>
            Riwayat Booking
        </a>

        <a href="/profil">
            <span class="menu-icon">👤</span>
            Profil
        </a>
    </nav>

    <form class="logout" action="/logout" method="POST">
        <?= csrf_field() ?>
        <button type="submit">🚪 Logout</button>
    </form>

</aside>

<main class="main">

    <header class="topbar">
        <div>
            <h1>Riwayat Booking</h1>
            <p class="muted">
                Lihat riwayat pemesanan kost yang pernah kamu lakukan.
            </p>
        </div>

        <div class="user">
            👋 Hai, <strong><?= $nama ?></strong>
        </div>
    </header>

    <section class="intro">
        <h2>Riwayat Pemesananmu</h2>
        <p>
            Di halaman ini, kamu dapat melihat daftar booking kost
            beserta informasi dan status pemesanannya.
        </p>
    </section>

    <section class="content-card">

        <h2>Daftar Booking</h2>

        <?php if (empty($riwayatBooking)): ?>

            <div class="empty">
                <div class="empty-icon">📋</div>

                <h3>Belum Ada Riwayat Booking</h3>

                <p>
                    Kamu belum memiliki riwayat pemesanan kost.
                    Kost yang berhasil kamu booking nantinya akan
                    ditampilkan di halaman ini.
                </p>

                <a href="/cari-kost" class="btn">
                    Cari Kost Sekarang
                </a>
            </div>

        <?php else: ?>

            <!-- Daftar booking akan ditampilkan di sini
                 setelah terhubung ke database. -->

        <?php endif; ?>

    </section>

</main>

</body>
</html>
