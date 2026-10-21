<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kost - KostKu</title>

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
        }

        /* HEADER & NAVIGATION */
        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .back-btn {
            text-decoration: none;
            color: #222;
            font-size: 28px;
            font-weight: bold;
            line-height: 1;
        }

        .header-title h1 {
            font-size: 22px;
            font-weight: bold;
            color: #111;
        }

        /* FORM CONTAINER */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #222;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #b5a89e;
            background-color: white;
            border-radius: 4px;
            font-size: 13px;
            outline: none;
        }

        input::placeholder,
        textarea::placeholder {
            color: #aaa;
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        /* CHECKBOX FASILITAS */
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 15px;
            margin-bottom: 8px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #333;
        }

        .checkbox-item input[type="checkbox"] {
            accent-color: #765238;
        }

        .input-lainnya {
            width: 100%;
            margin-top: 5px;
            padding: 6px 10px;
            font-size: 12px;
        }

        /* UPLOAD BOX */
        .upload-box {
            border: 1px solid #b5a89e;
            background-color: white;
            padding: 25px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
        }

        .upload-icon {
            font-size: 32px;
            color: #888;
            margin-bottom: 8px;
        }

        .upload-text {
            font-size: 11px;
            color: #777;
        }

        .upload-box input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-batal {
            flex: 1;
            padding: 12px;
            border: 1px solid #b5a89e;
            background-color: white;
            color: #222;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-simpan {
            flex: 1;
            padding: 12px;
            border: none;
            background-color: #765238;
            color: white;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-simpan:hover {
            background-color: #5c3e28;
        }
    </style>
</head>

<body>

    <!-- HEADER TITLE & BACK BUTTON -->
    <div class="header-title">
        <a href="index.php?page=data_kost" class="back-btn">‹</a>
        <h1>Tambah Data Kost</h1>
    </div>

    <!-- FORM TAMBAH KOST -->
    <div class="form-container">
        <form action="index.php?page=proses_tambah_kost" method="POST" enctype="multipart/form-data">

            <!-- NAMA KOST -->
            <div class="form-group">
                <label for="nama_kost">Nama Kost</label>
                <input type="text" id="nama_kost" name="nama_kost" placeholder="Kost Mawar" required>
            </div>

            <!-- ALAMAT -->
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Jl. Candi Gebang" required>
            </div>

            <!-- HARGA MULAI & STATUS -->
            <div class="form-row">
                <div class="form-group">
                    <label for="harga">Harga Mulai*</label>
                    <input type="number" id="harga" name="harga" placeholder="800.000">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- FASILITAS -->
            <div class="form-group">
                <label>Fasilitas</label>
                <div class="checkbox-grid">
                    <label class="checkbox-item">
                        <input type="checkbox" name="fasilitas[]" value="WiFi"> Wifi
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="fasilitas[]" value="Dapur Bersama"> Dapur Bersama
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="fasilitas[]" value="AC"> AC
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="fasilitas[]" value="Parkir Motor"> Parkir Motor
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="fasilitas[]" value="Kamar mandi Dalam"> Kamar mandi Dalam
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" id="check_lainnya"> Lainnya
                    </label>
                </div>
                <input type="text" name="fasilitas_lainnya" class="input-lainnya" placeholder="(fasilitas lain)">
            </div>

            <!-- DESKRIPSI -->
            <div class="form-group">
                <label for="deskripsi">Deskripsi/Informasi lainnya</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Kost nyaman, lokasi strategis, cocok untuk mahasiswa"></textarea>
            </div>

            <!-- FOTO KOST -->
            <div class="form-group">
                <label>Foto Kost</label>
                <div class="upload-box">
                    <div class="upload-icon">🖼️</div>
                    <div class="upload-text">Pilih gambar atau drag & drop<br>(Max 5 MB)</div>
                    <input type="file" name="foto_kost" accept="image/*">
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="action-buttons">
                <a href="index.php?page=data_kost" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>

        </form>
    </div>

</body>

</html>