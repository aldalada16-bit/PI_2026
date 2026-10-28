
<?php

function eKost($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function rupiahKost($angka) {
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

$modeTipeKamar = $modeTipeKamar ?? false;
$daftarKost = collect($daftarKost ?? []);
$daftarKamar = collect($daftarKamar ?? []);

$namaPengguna = session('nama', 'Pencari Kost');

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cari Kost - KostKu</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background: #f7f3ef;
    color: #3d3027;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: #765238;
    color: white;
    padding: 30px 18px;
    display: flex;
    flex-direction: column;
    z-index: 100;
}

.logo {
    font-size: 27px;
    font-weight: bold;
    padding: 0 15px 35px;
}

.menu-label {
    font-size: 11px;
    color: #e9d9c8;
    padding: 0 15px;
    margin-bottom: 12px;
    letter-spacing: 1px;
}

.menu {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.menu a {
    text-decoration: none;
    color: #f7eee7;
    padding: 14px 15px;
    border-radius: 9px;
    font-size: 14px;
    transition: 0.2s;
}

.menu a:hover,
.menu a.aktif {
    background: #d9a17e;
    color: #402b1e;
}

.menu a span,
.sidebar-bawah button span {
    display: inline-block;
    width: 25px;
    margin-right: 8px;
    text-align: center;
    font-size: 16px;
}

.sidebar-bawah {
    margin-top: auto;
}

.sidebar-bawah button {
    width: 100%;
    background: transparent;
    color: white;
    border: none;
    text-align: left;
    padding: 14px 15px;
    border-radius: 9px;
    cursor: pointer;
    font-size: 14px;
}

.sidebar-bawah button:hover {
    background: #5c3e29;
}

/* KONTEN UTAMA */
.main {
    margin-left: 250px;
    padding: 32px 38px;
    min-height: 100vh;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.sambutan {
    color: #76685e;
    font-size: 14px;
}

.profil-mini {
    background: white;
    padding: 10px 16px;
    border-radius: 10px;
    color: #765238;
    font-size: 14px;
    box-shadow: 0 3px 12px #00000008;
}

.judul {
    font-size: 29px;
    color: #765238;
    margin-bottom: 10px;
}

.deskripsi-halaman {
    color: #76685e;
    line-height: 1.7;
    margin-bottom: 25px;
}

.form-pencarian {
    background: white;
    padding: 18px;
    border-radius: 13px;
    margin-bottom: 30px;
    display: flex;
    gap: 12px;
    box-shadow: 0 3px 12px #00000008;
}

.form-pencarian input {
    flex: 1;
    min-width: 0;
    padding: 13px 15px;
    border: 1px solid #ddd0c4;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
}

.form-pencarian input:focus {
    border-color: #765238;
}

.btn {
    display: inline-block;
    background: #765238;
    color: white;
    border: none;
    padding: 12px 17px;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    font-size: 13px;
    text-align: center;
    transition: 0.2s;
}

.btn:hover {
    background: #5c3e29;
}

.btn-kembali {
    background: #e9d9c8;
    color: #5c3e29;
    margin-bottom: 24px;
}

.btn-kembali:hover {
    background: #ddc5ad;
}

.judul-bagian {
    color: #765238;
    font-size: 21px;
    margin-bottom: 18px;
}

/* KARTU KOST */
.grid-kost {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
}

.kartu {
    background: white;
    border: 1px solid #eee4dc;
    border-radius: 13px;
    overflow: hidden;
    box-shadow: 0 4px 14px #00000008;
    transition: transform 0.2s, box-shadow 0.2s;
}

.kartu:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px #00000010;
}

.foto-kost,
.foto-placeholder {
    width: 100%;
    height: 175px;
    object-fit: cover;
    display: block;
    background: #e9d9c8;
}

.foto-placeholder {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #765238;
    font-size: 14px;
}

.isi-kartu {
    padding: 18px;
}

.isi-kartu h3 {
    color: #765238;
    font-size: 18px;
    margin-bottom: 9px;
}

.alamat {
    font-size: 13px;
    color: #76685e;
    line-height: 1.6;
    margin-bottom: 12px;
}

.label-tipe {
    display: inline-block;
    background: #f3e6da;
    color: #765238;
    padding: 6px 9px;
    border-radius: 6px;
    font-size: 11px;
    margin-bottom: 12px;
}

.harga {
    color: #765238;
    font-size: 17px;
    font-weight: bold;
    margin: 15px 0;
}

.isi-kartu .btn {
    width: 100%;
}

/* KARTU INDIVIDUAL KAMAR */
.grid-tipe {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}

.kartu-tipe {
    background: white;
    border: 1px solid #eee4dc;
    border-radius: 13px;
    padding: 22px;
    
}

/* GAMBAR KAMAR */
.foto-kamar {
    width: calc(100% + 44px);
    height: 220px;
    object-fit: cover;
    display: block;
    margin: -22px -22px 20px;
    border-radius: 13px 13px 0 0;
    background: #e9d9c8;
}

/* Supaya gambar tidak terlalu besar di layar kecil */
@media (max-width: 700px) {
    .foto-kamar {
        height: 200px;
    }
}

.kartu-tipe h3 {
    color: #765238;
    font-size: 19px;
    margin-bottom: 13px;
    overflow-wrap: anywhere;
}

.detail-tipe {
    width: 100%;
    font-size: 13px;
    color: #76685e;
    line-height: 1.8;
    margin: 14px 0;
    overflow-wrap: anywhere;
}

.detail-tipe p {
    margin-bottom: 6px;
}

.status {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    background: #e5f4e5;
    color: #28733a;
    font-size: 12px;
}

.status-penuh {
    background: #fbe7e7;
    color: #a32f2f;
}

.kartu-tipe .harga {
    margin-top: auto;
    margin-bottom: 16px;
    padding-top: 4px;
}

.kartu-tipe .btn {
    width: 100%;
}

.kosong {
    background: white;
    padding: 35px 20px;
    text-align: center;
    border-radius: 12px;
    color: #76685e;
    line-height: 1.9;
    grid-column: 1 / -1;
}

.kosong h3 {
    color: #765238;
    margin-bottom: 8px;
}

footer {
    margin-top: 45px;
    color: #88786b;
    font-size: 12px;
    text-align: center;
    padding: 20px 0;
}

/* RESPONSIVE */
@media (max-width: 1100px) {
    .grid-kost,
    .grid-tipe {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .main {
        padding: 28px 24px;
    }
}

@media (max-width: 700px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 16px;
    }

    .logo {
        padding: 0 5px 15px;
    }

    .menu-label {
        display: none;
    }

    .menu {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 5px;
    }

    .menu a {
        padding: 10px;
        font-size: 12px;
    }

    .sidebar-bawah {
        margin-top: 10px;
    }

    .sidebar-bawah button {
        padding: 10px;
    }

    .main {
        margin-left: 0;
        padding: 23px 16px;
    }

    .grid-kost,
    .grid-tipe {
        grid-template-columns: 1fr;
    }

    .form-pencarian {
        flex-direction: column;
    }

    .form-pencarian input {
        width: 100%;
    }

    .judul {
        font-size: 25px;
    }
}
</style>
</head>

<body>

<aside class="sidebar">
    <div class="logo">KostKu</div>

    <div class="menu-label">MENU UTAMA</div>

    <nav class="menu">
        <a href="<?= url('/dashboard/pencari') ?>">
            <span>🏠</span> Dashboard
        </a>

        <a href="<?= url('/cari-kost') ?>" class="aktif">
            <span>🔍</span> Cari Kost
        </a>

        <a href="<?= url('/riwayat-booking') ?>">
            <span>📋</span> Riwayat Booking
        </a>

        <a href="<?= url('/profil') ?>">
            <span>👤</span> Profil
        </a>
    </nav>

    <div class="sidebar-bawah">
        <form action="<?= url('/logout') ?>" method="POST">
            <?= csrf_field() ?>
            <button type="submit">
                <span>🚪</span> Logout
            </button>
        </form>
    </div>
</aside>

<main class="main">

    <div class="topbar">
        <div>
            <p class="sambutan">
                Temukan tempat tinggal yang sesuai kebutuhanmu.
            </p>
        </div>

        <div class="profil-mini">
            <?= eKost($namaPengguna) ?>
        </div>
    </div>

    <?php if (!$modeTipeKamar): ?>

        <h1 class="judul">Cari Kost</h1>

        <p class="deskripsi-halaman">
            Temukan kost berdasarkan nama atau alamat, lalu lihat pilihan kamar yang tersedia.
        </p>

        <form action="<?= url('/cari-kost') ?>"
              method="GET"
              class="form-pencarian">

            <input
                type="text"
                name="q"
                placeholder="Cari nama kost atau alamat..."
                value="<?= eKost(request('q')) ?>"
            >

            <button type="submit" class="btn">Cari Kost</button>
        </form>

        <h2 class="judul-bagian">Daftar Kost</h2>

        <div class="grid-kost">

        <?php if ($daftarKost->isEmpty()): ?>

            <div class="kosong">
                <h3>Kost belum ditemukan</h3>
                <p>Coba gunakan kata kunci pencarian yang berbeda.</p>
            </div>

        <?php else: ?>

            <?php foreach ($daftarKost as $kost): ?>

                <?php
                $kamarKost = collect($kost->daftar_kamar ?? []);

                $hargaKamar = $kamarKost
                    ->filter(fn($k) => isset($k->harga) && is_numeric($k->harga))
                    ->pluck('harga');

                $jumlahKamar = $kamarKost->count();
                ?>

                <article class="kartu">

                  
<?php if (!empty($kost->foto_kost)): ?>

    <img
        class="foto-kost"
        src="<?= eKost(
            str_starts_with($kost->foto_kost, 'http://') ||
            str_starts_with($kost->foto_kost, 'https://')
                ? $kost->foto_kost
                : asset($kost->foto_kost)
        ) ?>"
        alt="Foto <?= eKost($kost->nama_kost) ?>"
        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
    >

    <div class="foto-placeholder" style="display:none;">
        Foto kost tidak dapat dimuat
    </div>

<?php else: ?>

    <div class="foto-placeholder">
        Foto kost belum tersedia
    </div>

<?php endif; ?>


                    <div class="isi-kartu">

                        <h3><?= eKost($kost->nama_kost) ?></h3>

                        <p class="alamat">
                            📍 <?= eKost($kost->alamat) ?>
                        </p>

                        <div class="label-tipe">
                            <?= $jumlahKamar ?> kamar terdaftar
                        </div>

                        <?php if ($hargaKamar->isNotEmpty()): ?>

                            <p class="harga">
                                Mulai <?= rupiahKost($hargaKamar->min()) ?>/bulan
                            </p>

                        <?php else: ?>

                            <p class="harga">Harga belum ditentukan</p>

                        <?php endif; ?>

                        <a
                            href="<?= eKost(url('/kost/' . $kost->id_kost . '/tipe-kamar')) ?>"
                            class="btn"
                        >
                            Lihat Pilihan Kamar
                        </a>

                    </div>
                </article>

            <?php endforeach; ?>

        <?php endif; ?>

        </div>

    <?php else: ?>

        <a href="<?= url('/cari-kost') ?>" class="btn btn-kembali">
            &larr; Kembali ke Daftar Kost
        </a>

        <?php $kostTerpilih = $daftarKost->first(); ?>

        <?php if ($kostTerpilih): ?>

            <h1 class="judul">
                <?= eKost($kostTerpilih->nama_kost) ?>
            </h1>

            <p class="deskripsi-halaman">
                📍 <?= eKost($kostTerpilih->alamat) ?>
            </p>

        <?php endif; ?>

        <h2 class="judul-bagian">Daftar Kamar</h2>

        <div class="grid-tipe">

        <?php if ($daftarKamar->isEmpty()): ?>

            <div class="kosong">
                <h3>Belum ada kamar</h3>
                <p>Pemilik kost belum menambahkan data kamar.</p>
            </div>

        <?php else: ?>

            <?php foreach ($daftarKamar as $kamar): ?>

                <?php
                $tipe = trim((string) ($kamar->tipe_kamar ?? ''));
                $nomor = trim((string) ($kamar->no_kamar ?? ''));

                /*
                 * Tipe A + A01 menjadi Kamar Tipe A01.
                 * Tipe B + B01 menjadi Kamar Tipe B01.
                 */
                $nomorTampilan = preg_replace('/^[A-Za-z]/', '', $nomor);

                if ($tipe !== '' && $nomor !== '') {
                    $namaKamar = 'Kamar ' . $tipe . $nomorTampilan;
                } elseif (!empty($kamar->nama_kamar)) {
                    $namaKamar = $kamar->nama_kamar;
                } else {
                    $namaKamar = 'Kamar ' . $nomor;
                }

                $statusKamar = trim(
                    (string) ($kamar->status_kamar ?? '')
                );

                $tersedia = in_array(
                    strtolower($statusKamar),
                    ['tersedia', 'available', 'kosong'],
                    true
                );

                $fasilitas = trim(
                    (string) ($kamar->fasilitas ?? '')
                );
                ?>

                <article class="kartu-tipe">
                   <img
                        src="<?= eKost(asset('uploads/ys_kost.PNG')) ?>"
                        alt="Foto <?= eKost($namaKamar ?? 'kamar kost') ?>"
                        class="foto-kamar"
                        onerror="this.style.display='none';"
                    >

                    <h3><?= eKost($namaKamar) ?></h3>

                    <?php if ($tersedia): ?>

                        <span class="status">Tersedia</span>

                    <?php else: ?>

                        <span class="status status-penuh">
                            <?= eKost(
                                $statusKamar !== ''
                                    ? $statusKamar
                                    : 'Tidak tersedia'
                            ) ?>
                        </span>

                    <?php endif; ?>

                    <div class="detail-tipe">

                        <p>
                            <strong>Nomor kamar:</strong>
                            <?= eKost($nomor !== '' ? $nomor : '-') ?>
                        </p>

                        <p>
                            <strong>Tipe:</strong>
                            <?= eKost($tipe !== '' ? $tipe : '-') ?>
                        </p>

                        <p>
                            <strong>Fasilitas:</strong>
                            <?= eKost($fasilitas !== '' ? $fasilitas : '-') ?>
                        </p>

                    </div>

                    <p class="harga">
                        <?= rupiahKost($kamar->harga ?? 0) ?>/bulan
                    </p>

                    <a
                        href="<?= eKost(url('/kamar/' . $kamar->id_kamar)) ?>"
                        class="btn"
                    >
                        Lihat Detail
                    </a>

                </article>

            <?php endforeach; ?>

        <?php endif; ?>

        </div>

    <?php endif; ?>

    <footer>
        &copy; <?= date('Y') ?> KostKu. Temukan kost yang sesuai kebutuhanmu.
    </footer>

</main>

</body>
</html>
