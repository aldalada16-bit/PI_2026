
<?php
use Illuminate\Support\Facades\DB;

// Mengambil nama pengguna dari session Laravel
$namaSession = session('nama', 'Pengguna');

$nama = htmlspecialchars(
    $namaSession ?: 'Pengguna',
    ENT_QUOTES,
    'UTF-8'
);

 // Mengambil data kost yang sudah disiapkan oleh route
$daftarKost = $daftarKost ?? collect();

// Menghitung jumlah kost yang ditampilkan
$jumlahKost = $daftarKost->count();


// Format harga ke rupiah
if (!function_exists('rupiahDashboard')) {
    function rupiahDashboard($angka)
    {
        return 'Rp' . number_format(
            (float) $angka,
            0,
            ',',
            '.'
        );
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pencari Kost | KostKu</title>

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

        /* SIDEBAR */
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
            overflow-y: auto;
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
            transition: background 0.2s;
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

        .logout button:hover {
            background: #4b3021;
        }

        /* KONTEN UTAMA */
        .main {
            margin-left: 245px;
            padding: 35px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
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
            box-shadow: 0 3px 14px #00000008;
        }

        /* SAPAAN */
        .welcome {
            background: #e9d9c8;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 30px;
        }

        .welcome h2 {
            font-size: 24px;
            margin-bottom: 12px;
        }

        .welcome p {
            color: #725b48;
            line-height: 1.7;
            font-size: 14px;
        }

        /* JUDUL BAGIAN */
        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .section-title h2 {
            font-size: 21px;
        }

        /* RINGKASAN AKTIVITAS */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 3px 14px #00000008;
        }

        .stat-icon {
            font-size: 25px;
            margin-bottom: 14px;
        }

        .stat-card p {
            color: #8c7b6d;
            font-size: 13px;
            margin-bottom: 13px;
        }

        .stat-card h3 {
            color: #765238;
            font-size: 27px;
            margin-bottom: 8px;
        }

        .stat-card small {
            color: #9b8b7e;
            font-size: 12px;
            line-height: 1.5;
        }

        /* REKOMENDASI KOST */
        .kost-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .kost-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 3px 14px #00000008;
            transition: transform 0.2s;
        }

        .kost-card:hover {
            transform: translateY(-3px);
        }

        .kost-image {
            height: 140px;
            background: #e9d9c8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 52px;
            overflow: hidden;
        }

        .kost-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kost-image-placeholder {
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    padding: 12px;
    background: #e9d9c8;
    color: #765238;
    font-size: 14px;
    text-align: center;
}

        .kost-info {
            padding: 18px;
        }

        .kost-info h3 {
            font-size: 17px;
            margin-bottom: 10px;
            overflow-wrap: anywhere;
        }

        .lokasi {
            color: #8c7b6d;
            font-size: 13px;
            margin-bottom: 13px;
            line-height: 1.5;
        }

        .tipe {
            display: inline-block;
            background: #f3e9df;
            color: #765238;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 11px;
            margin-bottom: 13px;
        }

        .harga {
            color: #765238;
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .harga small {
            color: #8c7b6d;
            font-size: 12px;
            font-weight: normal;
        }

        .detail-button {
            display: block;
            padding: 11px;
            background: #765238;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            font-size: 13px;
        }

        .detail-button:hover {
            background: #5c3c29;
        }

        .lihat-semua {
            color: #765238;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
        }

        .lihat-semua:hover {
            text-decoration: underline;
        }

        .kosong {
            grid-column: 1 / -1;
            background: white;
            padding: 25px;
            border-radius: 14px;
            color: #8c7b6d;
            text-align: center;
        }

        /* RESPONSIVE */
        @media (max-width: 1050px) {
            .stats,
            .kost-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .main {
                padding: 25px;
            }
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

            .stats,
            .kost-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="logo">KostKu</div>
    <div class="tagline">Temukan tempat tinggalmu</div>

    <nav class="menu">
        <a href="/dashboard/pencari" class="active">
            <span class="menu-icon">🏠</span>
            Dashboard
        </a>

        <a href="/cari-kost">
            <span class="menu-icon">🔎</span>
            Cari Kost
        </a>

        <a href="/riwayat-booking">
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

<!-- KONTEN DASHBOARD -->
<main class="main">

    <!-- HEADER -->
    <header class="topbar">
        <div>
            <h1>Dashboard</h1>
            <p class="muted">
                Temukan tempat tinggal yang nyaman untukmu.
            </p>
        </div>

        <div class="user">
            👋 Hai, <strong><?= $nama ?></strong>
        </div>
    </header>

    <!-- SAPAAN -->
    <section class="welcome">
        <h2>Selamat datang, <?= $nama ?>!</h2>

        <p>
            Senang melihatmu kembali di KostKu.
            Jelajahi pilihan kost yang tersedia dan temukan
            tempat tinggal yang sesuai dengan kebutuhanmu.
        </p>
    </section>

    <!-- RINGKASAN AKTIVITAS -->
    <section>
        <div class="section-title">
            <h2>Ringkasan Aktivitas</h2>
        </div>

        <div class="stats">

            <div class="stat-card">
                <div class="stat-icon">🏡</div>
                <p>Kost Tersedia</p>
                <h3><?= $jumlahKost ?></h3>
                <small>
                    Total kost yang terdaftar di database
                </small>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <p>Booking Saya</p>
                <h3>0</h3>
                <small>
                    Total booking yang telah dilakukan
                </small>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <p>Booking Aktif</p>
                <h3>0</h3>
                <small>
                    Booking yang sedang diproses
                </small>
            </div>

        </div>
    </section>

    <!-- REKOMENDASI KOST -->
    <section>
        <div class="section-title">
            <h2>Rekomendasi Kost</h2>

            <a href="/cari-kost" class="lihat-semua">
                Cari Kost →
            </a>
        </div>

        <div class="kost-list">

            <?php if ($daftarKost->isEmpty()): ?>

                <div class="kosong">
                    Belum ada data kost yang terdaftar.
                </div>

            <?php else: ?>

                <?php foreach ($daftarKost as $kost): ?>

                    <?php
                    // Mengambil kamar untuk kost ini
                     $daftarKamar = $kost->daftar_kamar
                    ?? collect();

                    $kamarTermurah = $daftarKamar->first();
                    ?>

                    <article class="kost-card">

                        
<div class="kost-image">
    <?php
    $fotoKostDashboard = trim((string) ($kost->foto_kost ?? ''));

    if ($fotoKostDashboard !== '') {
        if (
            str_starts_with($fotoKostDashboard, 'http://') ||
            str_starts_with($fotoKostDashboard, 'https://')
        ) {
            $urlFotoDashboard = $fotoKostDashboard;
        } else {
            $pathFotoDashboard = ltrim($fotoKostDashboard, '/');

            // Jika database berisi uploads/ys_kost.PNG
            $urlFotoDashboard = asset($pathFotoDashboard);
        }
    } else {
        $urlFotoDashboard = asset('uploads/ys_kost.PNG');
    }
    ?>

    <img
        src="<?= htmlspecialchars($urlFotoDashboard, ENT_QUOTES, 'UTF-8') ?>"
        alt="Foto <?= htmlspecialchars($kost->nama_kost ?? 'Kost', ENT_QUOTES, 'UTF-8') ?>"
        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
    >

    <div class="kost-image-placeholder" style="display:none;">
        🏡 Foto kost belum tersedia
    </div>
</div>


                        <div class="kost-info">

                            <h3>
                                <?= htmlspecialchars(
                                    $kost->nama_kost ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </h3>

                            <p class="lokasi">
                                📍
                                <?= htmlspecialchars(
                                    $kost->alamat ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </p>

                            <span class="tipe">
                                <?= $daftarKamar->count() ?>
                                kamar terdaftar
                            </span>

                            <p class="harga">
                                <?php if ($kamarTermurah): ?>

                                    <?= rupiahDashboard(
                                        $kamarTermurah->harga
                                    ) ?>

                                    <small>/ bulan</small>

                                <?php else: ?>

                                    <small>
                                        Harga kamar belum tersedia
                                    </small>

                                <?php endif; ?>
                            </p>

                            <a
                                href="/kost/<?= (int) $kost->id_kost ?>/tipe-kamar"
                                class="detail-button"
                            >
                                Lihat Pilihan Tipe Kamar
                            </a>

                        </div>
                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </section>

</main>

</body>
</html>
