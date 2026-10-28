<?php
$nama = htmlspecialchars($pengguna->nama ?? 'Pengguna', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($pengguna->email ?? '', ENT_QUOTES, 'UTF-8');
$role = htmlspecialchars($pengguna->role ?? '', ENT_QUOTES, 'UTF-8');
$noHp = htmlspecialchars($pengguna->no_hp ?? '', ENT_QUOTES, 'UTF-8');
$jenisKelamin = $pengguna->jenis_kelamin ?? '';
$fotoProfil = $pengguna->foto_profil ?? '';

switch ($pengguna->role ?? '') {
    case 'Pencari Kost':
        $dashboardUrl = '/dashboard/pencari';
        break;
    case 'Pemilik Kost':
        $dashboardUrl = '/dashboard/pemilik';
        break;
    case 'Admin':
        $dashboardUrl = '/dashboard/admin';
        break;
    default:
        $dashboardUrl = '/';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | KostKu</title>

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
            inset: 0 auto 0 0;
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
            margin: 7px 0 38px;
        }

        
        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 5px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: #f8eee5;
            padding: 15px 16px;
            border-radius: 10px;
            margin-bottom: 0;
            font-size: 14px;
            line-height: 1.5;
            transition: background 0.2s ease;
        }

        .menu a:hover,
        .menu a.active {
            background: #9b7656;
        }

        .menu-icon {
            width: 24px;
            min-width: 24px;
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
            margin-bottom: 28px;
        }

        .topbar h1 {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .muted {
            color: #8c7b6d;
            font-size: 14px;
        }

        .user {
            background: white;
            border-radius: 10px;
            padding: 13px 18px;
            font-size: 14px;
        }

        .welcome {
            background: #e9d9c8;
            border-radius: 16px;
            padding: 27px;
            margin-bottom: 28px;
        }

        .welcome h2 {
            font-size: 23px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #725b48;
            font-size: 14px;
            line-height: 1.7;
        }

        .profile-layout {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            gap: 24px;
            align-items: start;
        }

        .profile-card,
        .form-card {
            background: white;
            padding: 28px;
            border-radius: 15px;
            box-shadow: 0 3px 14px #00000008;
        }

        .profile-card {
            text-align: center;
        }

        
        .avatar {
            width: 130px;
            height: 130px;
            background: #e9d9c8;
            border-radius: 50%;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: visible;
            font-size: 48px;
            color: #765238;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        .avatar-upload {
            position: absolute;
            right: 2px;
            bottom: 2px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #765238;
            color: white;
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 17px;
            z-index: 2;
        }

        .avatar-upload:hover {
            background: #5c3c29;
        }

        .avatar-upload input {
            display: none;
        }


        .profile-card h2 {
            font-size: 20px;
            margin-bottom: 10px;
            overflow-wrap: anywhere;
        }

        .role {
            display: inline-block;
            background: #f3e9df;
            color: #765238;
            border-radius: 20px;
            padding: 7px 13px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .profile-note {
            border-top: 1px solid #eee5dd;
            padding-top: 17px;
            color: #8c7b6d;
            font-size: 13px;
            line-height: 1.7;
        }

        .form-card h2 {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .form-description {
            color: #8c7b6d;
            font-size: 13px;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #ded2c7;
            border-radius: 9px;
            font-size: 14px;
            background: white;
            outline-color: #9b7656;
        }

        .form-group input[type="file"] {
            background: #f7f3ef;
        }

        .help-text {
            display: block;
            color: #8c7b6d;
            font-size: 12px;
            margin-top: 7px;
        }

        .button-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            padding: 13px 18px;
            border: none;
            border-radius: 9px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: #765238;
            color: white;
        }

        .btn-primary:hover {
            background: #5c3c29;
        }

        .btn-secondary {
            background: #eee5dd;
            color: #765238;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert-success {
            background: #e5f4e8;
            color: #28663a;
        }

        .alert-error {
            background: #fbe8e5;
            color: #9b3024;
        }

        @media (max-width: 950px) {
            .profile-layout {
                grid-template-columns: 1fr;
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
        }
    </style>
</head>

<body>

<aside class="sidebar">
    <div class="logo">KostKu</div>
    <div class="tagline">Temukan tempat tinggalmu</div>

    
<nav class="menu">
    <a href="<?= htmlspecialchars($dashboardUrl, ENT_QUOTES, 'UTF-8') ?>">
        <span class="menu-icon">🏠</span>
        <span>Dashboard</span>
    </a>

    <a href="/cari-kost">
        <span class="menu-icon">🔍</span>
        <span>Cari Kost</span>
    </a>

    <a href="/profil" class="active">
        <span class="menu-icon">👤</span>
        <span>Profil</span>
    </a>

    <a href="/riwayat-booking">
        <span class="menu-icon">📋</span>
        <span>Riwayat Booking</span>
    </a>
</nav>


    <form class="logout" action="/logout" method="POST">
        <?= csrf_field() ?>
        <button type="submit">🚪 Logout </button>
    </form>
</aside>

<main class="main">

    <header class="topbar">
        <div>
            <h1>Profil Saya</h1>
            <p class="muted">Kelola informasi akun KostKu kamu.</p>
        </div>

        <div class="user">
            👋 Hai, <strong><?= $nama ?></strong>
        </div>
    </header>

    <section class="welcome">
        <h2>👤 Profil Pengguna</h2>
        <p>
            Halo, <?= $nama ?>! Perbarui informasi profilmu
            agar data akun KostKu tetap sesuai.
        </p>
    </section>

    <?php if (session('success')): ?>
        <div class="alert alert-success">
            ✅ <?= htmlspecialchars(session('success'), ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-error">
            ⚠️ <?= htmlspecialchars(session('error'), ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="profile-layout">

        <section class="profile-card">
            
        <div class="avatar">
            <img
                id="previewFoto"
                src="<?= $fotoProfil
                    ? htmlspecialchars(asset('storage/' . $fotoProfil), ENT_QUOTES, 'UTF-8')
                    : '' ?>"
                alt="Foto profil"
                style="<?= $fotoProfil ? '' : 'display:none;' ?>"
            >

            <span
                id="ikonDefault"
                style="<?= $fotoProfil ? 'display:none;' : '' ?>"
            >👤</span>

            <label class="avatar-upload" for="foto_profil" title="Ganti foto profil">
                📷
                <input
                    type="file"
                    id="foto_profil"
                    name="foto_profil"
                    accept="image/jpeg,image/png,image/webp"
                >
            </label>
        </div>


            <h2><?= $nama ?></h2>
            <span class="role"><?= $role ?></span>

            <div class="profile-note">
                Selamat menggunakan KostKu!<br>
                Kelola informasi akunmu dengan mudah.
            </div>
        </section>

        <section class="form-card">
            <h2>📝 Informasi Akun</h2>
            <p class="form-description">
                Ubah nama, email, nomor HP, jenis kelamin,
                atau foto profil akunmu.
            </p>

            <form action="/profil" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="<?= $nama ?>"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= $email ?>"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP</label>
                    <input
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        value="<?= $noHp ?>"
                        maxlength="20"
                        placeholder="Contoh: 081234567890"
                    >
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">-- Pilih jenis kelamin --</option>
                        <option value="Laki-laki"
                            <?= $jenisKelamin === 'Laki-laki' ? 'selected' : '' ?>>
                            Laki-laki
                        </option>
                        <option value="Perempuan"
                            <?= $jenisKelamin === 'Perempuan' ? 'selected' : '' ?>>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Role Akun</label>
                    <input
                        type="text"
                        id="role"
                        value="<?= $role ?>"
                        readonly
                    >
                    <span class="help-text">
                        Role tidak dapat diubah melalui halaman profil.
                    </span>
                </div>

                <div class="button-row">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Perubahan
                    </button>

                    <a
                        href="<?= htmlspecialchars($dashboardUrl, ENT_QUOTES, 'UTF-8') ?>"
                        class="btn btn-secondary"
                    >
                        Kembali
                    </a>
                </div>
            </form>
        </section>

    </div>

</main>


<script>
document.getElementById('foto_profil').addEventListener('change', function () {
    const file = this.files[0];

    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('Pilih file gambar yang valid.');
        this.value = '';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran foto maksimal 2 MB.');
        this.value = '';
        return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {
        document.getElementById('previewFoto').src = event.target.result;
        document.getElementById('previewFoto').style.display = 'block';
        document.getElementById('ikonDefault').style.display = 'none';
    };

    reader.readAsDataURL(file);
});
</script>

</body>
</html>
