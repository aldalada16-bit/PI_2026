<?php
$errors = session('errors');
$old = old();

$errorMessages = [];

if ($errors && $errors->any()) {
    $errorMessages = $errors->all();
}

function escapeRegistrasi($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KostKu</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f7f2ec;
            color: #704f39;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
        }

        .card {
            background: #fbf7f2;
            border: 1px solid #dfd0c2;
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 3px 12px #704f3910;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .logo span {
            display: block;
            font-size: 48px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        input, select {
            width: 100%;
            padding: 13px;
            border: 1px solid #bda795;
            border-radius: 6px;
            background: white;
            font-size: 14px;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #704f39;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background: #704f39;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 12px;
        }

        button:hover {
            background: #573b29;
        }

        a {
            color: #8b6a51;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 35px;
            font-size: 13px;
            line-height: 1.8;
        }

        .footer strong {
            color: #222;
        }

        .message {
            background: #f5e5df;
            color: #9b3025;
            padding: 10px;
            border-radius: 5px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: left;
        }
    </style>
</head>

<body>

<div class="card">

    <div class="logo">
        <span>⌂</span>
        KostKu
    </div>

    <h2>Daftar Akun</h2>

    <?php if (!empty($errorMessages)): ?>
        <div class="message">
            <?php foreach ($errorMessages as $error): ?>
                <div><?= escapeRegistrasi($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form
        method="POST"
        action="<?= escapeRegistrasi(route('registrasi.store')) ?>"
    >

        <input
            type="hidden"
            name="_token"
            value="<?= escapeRegistrasi(csrf_token()) ?>"
        >

        <div class="form-group">
            <input
                type="text"
                name="nama"
                placeholder="Nama Lengkap"
                value="<?= escapeRegistrasi($old['nama'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <input
                type="email"
                name="email"
                placeholder="Email"
                value="<?= escapeRegistrasi($old['email'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >
        </div>

        <div class="form-group">
            <select name="role" required>
                <option value="">-- Pilih Role --</option>

                <option
                    value="Pencari Kost"
                    <?= ($old['role'] ?? '') === 'Pencari Kost' ? 'selected' : '' ?>
                >
                    Pencari Kost
                </option>

                <option
                    value="Pemilik Kost"
                    <?= ($old['role'] ?? '') === 'Pemilik Kost' ? 'selected' : '' ?>
                >
                    Pemilik Kost
                </option>
            </select>
        </div>

        <button type="submit">Daftar</button>

    </form>

    <div class="footer">
        <strong>Sudah punya akun?</strong><br>

        <a href="<?= escapeRegistrasi(route('login')) ?>">
            Login
        </a>
    </div>

</div>

</body>
</html>