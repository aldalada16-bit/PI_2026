<?php

$idBooking = '__BOOKING_ID__';


if (!$idBooking) {
    echo 'ID booking tidak ditemukan.';
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking - KostKu</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 25px 15px;
            background: #FAF5EF;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 465px;
            margin: 0 auto;
            padding: 22px;
            background: #fff;
            border: 1px solid #6F4E37;
            border-radius: 10px;
        }

        h2 {
            margin-top: 0;
            color: #6F4E37;
            text-align: center;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            color: #8A5A16;
            background: #FFF0CC;
            border-radius: 6px;
            font-size: 13px;
        }

        .section {
            margin-top: 22px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .item {
            margin: 14px 0;
        }

        .label {
            display: block;
            margin-bottom: 5px;
            color: #777;
            font-size: 12px;
        }

        .value {
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button {
            flex: 1;
            padding: 12px 8px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .reject {
            color: #CC3948;
            background: white;
            border: 1px solid #CC3948;
        }

        .accept {
            color: white;
            background: #6F4E37;
            border: 1px solid #6F4E37;
        }

        .back {
            display: block;
            margin-top: 20px;
            color: #6F4E37;
            text-align: center;
            text-decoration: none;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Detail Booking</h2>

    <div class="item">
        <span class="label">ID BOOKING</span>
        <div class="value">
            <?= htmlspecialchars((string) $idBooking) ?>
        </div>
    </div>

    <div class="item">
        <span class="label">STATUS BOOKING</span>
        <span class="status" id="status">Memuat data...</span>
    </div>

    <div class="section">
        <h3>Data Calon Penyewa</h3>

        <div class="item">
            <span class="label">Nama Lengkap</span>
            <div class="value" id="nama">-</div>
        </div>

        <div class="item">
            <span class="label">No. WhatsApp</span>
            <div class="value" id="whatsapp">-</div>
        </div>

        <div class="item">
            <span class="label">Unit Dipesan</span>
            <div class="value" id="kamar">-</div>
        </div>

        <div class="item">
            <span class="label">Rencana Masuk</span>
            <div class="value" id="tanggal">-</div>
        </div>

        <div class="item">
            <span class="label">Durasi Sewa</span>
            <div class="value" id="durasi">-</div>
        </div>

        <div class="item">
            <span class="label">Catatan</span>
            <div class="value" id="catatan">-</div>
        </div>
    </div>

    <div class="section">
        <h3>Ketersediaan Unit Saat Ini</h3>
        <div class="value" id="ketersediaan">-</div>
    </div>

    <div class="section">
        <h3>Keputusan Pemilik Kost</h3>

        <div class="buttons">
            <button type="button" class="reject"
                    onclick="kirimKeputusan('Ditolak')">
                Tolak Booking
            </button>

            <button type="button" class="accept"
                    onclick="kirimKeputusan('Diterima')">
                Terima Booking
            </button>
        </div>

        <div class="message" id="pesan"></div>
    </div>

    <a class="back" href="/dashboard/pemilik">
        Kembali ke Dashboard
    </a>
</div>

<script>
const idBooking = <?= json_encode((string) $idBooking) ?>;

async function muatBooking() {
    try {
        const response = await fetch(
            '/api/booking/' + encodeURIComponent(idBooking),
            { credentials: 'same-origin' }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal memuat booking.');
        }

        const isi = (id, nilai) => {
            document.getElementById(id).textContent =
                nilai ?? '-';
        };

        isi('status', data.status_booking);
        isi('nama', data.nama_penyewa);
        isi('whatsapp', data.no_whatsapp);
        isi('kamar', data.nama_kamar);
        isi('tanggal', data.tanggal_masuk);
        isi('durasi', data.durasi_sewa);
        isi('catatan', data.catatan);
        isi('ketersediaan', data.status_kamar);

    } catch (error) {
        document.getElementById('pesan').textContent =
            error.message;
    }
}

async function kirimKeputusan(status) {
    if (!confirm('Yakin ingin ' + status.toLowerCase() +
        ' booking ini?')) {
        return;
    }

    const pesan = document.getElementById('pesan');

    try {
        const response = await fetch(
            '/api/booking/' + encodeURIComponent(idBooking) +
            '/keputusan',
            {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': await ambilTokenCSRF()
                },
                body: JSON.stringify({ status })
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal menyimpan keputusan.');
        }

        pesan.textContent = data.message;
        await muatBooking();

    } catch (error) {
        pesan.textContent = error.message;
    }
}

async function ambilTokenCSRF() {
    const response = await fetch('/csrf-token', {
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json' }
    });

    if (!response.ok) {
        throw new Error('Token keamanan tidak tersedia.');
    }

    const data = await response.json();
    return data.token;
}

muatBooking();
</script>

</body>
</html>