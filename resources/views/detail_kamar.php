
<?php
function eDetail($value)
{
    return htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
}

function rupiahDetail($angka)
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

$namaPengguna = session('nama', 'Pencari Kost');
$kamar = $kamar ?? null;

if (!$kamar) {
    echo '<p>Data kamar tidak ditemukan.</p>';
    return;
}

$nomorKamar = trim((string) ($kamar->no_kamar ?? ''));
$tipeKamar = trim((string) ($kamar->tipe_kamar ?? ''));
$namaKamar = ($tipeKamar !== '' && $nomorKamar !== '')
    ? 'Kamar ' . $tipeKamar . $nomorKamar
    : ($kamar->nama_kamar ?? 'Detail Kamar');

$statusKamar = trim((string) ($kamar->status_kamar ?? 'Tidak diketahui'));
$fasilitas = trim((string) ($kamar->fasilitas ?? ''));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kamar - KostKu</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f3ef;
            color: #493729;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            padding: 28px 18px;
            background: #765238;
            color: white;
        }

        .brand {
            margin: 0 0 8px;
            font-size: 25px;
        }

        .subtitle {
            margin-bottom: 35px;
            color: #eadbce;
            font-size: 13px;
        }

        .menu {
            display: block;
            margin-bottom: 10px;
            padding: 13px 14px;
            border-radius: 9px;
            color: white;
            text-decoration: none;
        }

        .menu:hover,
        .menu.aktif {
            background: #927052;
        }

        .logout {
            position: absolute;
            right: 18px;
            bottom: 25px;
            left: 18px;
        }

        .logout button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: #f7f3ef;
            color: #765238;
            font-size: 14px;
            cursor: pointer;
        }

        .konten {
            margin-left: 250px;
            padding: 35px;
        }

        .kembali {
            display: inline-block;
            margin-bottom: 22px;
            color: #765238;
            text-decoration: none;
            font-weight: bold;
        }

        .judul {
            margin-bottom: 25px;
        }

        .judul h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .judul p {
            margin: 0;
            color: #806d5e;
        }

        .kartu {
            max-width: 850px;
            padding: 30px;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 18px rgba(80, 55, 35, 0.08);
        }

        .label {
            margin-bottom: 10px;
            color: #806d5e;
            font-size: 13px;
        }

        .harga {
            margin: 0 0 22px;
            color: #765238;
            font-size: 28px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            margin-bottom: 25px;
            padding: 7px 13px;
            border-radius: 20px;
            background: #e4f4e8;
            color: #26743a;
            font-size: 13px;
            font-weight: bold;
        }

        .status.penuh {
            background: #fbe5e2;
            color: #a33428;
        }

        .bagian {
            padding: 20px 0;
            border-top: 1px solid #eee5dd;
        }

        .bagian h2 {
            margin: 0 0 15px;
            font-size: 18px;
        }

        .baris {
            display: flex;
            gap: 20px;
            margin: 12px 0;
        }

        .baris strong {
            width: 155px;
            flex-shrink: 0;
        }

        .baris span {
            overflow-wrap: anywhere;
        }

        .tombol {
            display: inline-block;
            margin-top: 20px;
            padding: 13px 22px;
            border-radius: 9px;
            background: #765238;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .tombol:hover {
            background: #5d3e29;
        }

        @media (max-width: 760px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .logout {
                position: static;
                margin-top: 20px;
            }

            .konten {
                margin-left: 0;
                padding: 22px;
            }

            .baris {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <h2 class="brand">🏠 KostKu</h2>
        <div class="subtitle">Sistem Pencarian dan Booking Kost</div>

        <a class="menu" href="<?= eDetail(url('/dashboard/pencari')) ?>">
            🏠 Dashboard
        </a>

        <a class="menu aktif" href="<?= eDetail(url('/cari-kost')) ?>">
            🔍 Cari Kost
        </a>

        <a class="menu" href="<?= eDetail(url('/riwayat-booking')) ?>">
            📋 Riwayat Booking
        </a>

        <a class="menu" href="<?= eDetail(url('/profil')) ?>">
            👤 Profil
        </a>

        <form class="logout" action="<?= eDetail(url('/logout')) ?>" method="POST">
            <?= csrf_field() ?>
            <button type="submit">🚪 Logout</button>
        </form>
    </aside>

    <main class="konten">
        <a class="kembali" href="<?= eDetail(url('/kost/' . $kamar->id_kost . '/tipe-kamar')) ?>">
            ← Kembali ke Daftar Kamar
        </a>

        <div class="judul">
            <h1>Detail Kamar</h1>
            <p>Lihat informasi kamar sebelum melakukan booking.</p>
        </div>

        <section class="kartu">
            <div class="label">Nama kamar</div>
            <h2><?= eDetail($namaKamar) ?></h2>

            <p class="harga">
                <?= rupiahDetail($kamar->harga ?? 0) ?>/bulan
            </p>

            <?php
            $tersedia = in_array(
                strtolower($statusKamar),
                ['tersedia', 'available', 'kosong'],
                true
            );
            ?>

            <span class="status <?= $tersedia ? '' : 'penuh' ?>">
                <?= eDetail($statusKamar) ?>
            </span>

            <div class="bagian">
                <h2>Informasi Kamar</h2>

                <div class="baris">
                    <strong>Nomor kamar</strong>
                    <span><?= eDetail($nomorKamar ?: '-') ?></span>
                </div>

                <div class="baris">
                    <strong>Tipe kamar</strong>
                    <span><?= eDetail($tipeKamar ?: '-') ?></span>
                </div>

                <div class="baris">
                    <strong>Nama kost</strong>
                    <span><?= eDetail($kamar->nama_kost ?? '-') ?></span>
                </div>

                <div class="baris">
                    <strong>Alamat kost</strong>
                    <span><?= eDetail($kamar->alamat_kost ?? '-') ?></span>
                </div>

                <div class="baris">
                    <strong>Fasilitas kamar</strong>
                    <span><?= eDetail($fasilitas ?: 'Belum ada informasi fasilitas') ?></span>
                </div>
            </div>

            <div class="bagian">
                <h2>Deskripsi Kost</h2>
                <p><?= nl2br(eDetail($kamar->deskripsi_kost ?? 'Belum ada deskripsi kost.')) ?></p>
            </div>

            <?php if ($tersedia): ?>
                <a class="tombol"
                   href="<?= eDetail(url('/booking/' . $kamar->id_kamar)) ?>">
                    Booking Kamar
                </a>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
