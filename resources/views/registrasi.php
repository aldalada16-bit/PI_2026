<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
</head>

<body>

<h2>Registrasi Akun</h2>

<?php if (!empty($error)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST" action="">

    <label>Nama</label><br>
    <input type="text" name="nama" required>
    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" required>
    <br><br>

    <label>Password</label><br>
    <input type="password" name="password" required>
    <br><br>

    <label>Daftar sebagai</label><br>

    <select name="role" required>
        <option value="">-- Pilih Role --</option>
        <option value="Pencari Kost">Pencari Kost</option>
        <option value="Pemilik Kost">Pemilik Kost</option>
    </select>

    <br><br>

    <button type="submit">Daftar</button>

</form>

<p>
    Sudah punya akun?
    <a href="index.php?page=login">Login</a>
</p>

</body>
</html>