<?php
$errors = session('errors');
$errorMessage = '';

if ($errors && $errors->any()) {
    $errorMessage = $errors->first();
}

$success = session('success');
$oldEmail = old('email', '');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KostKu</title>

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
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 60px;
            padding: 30px;
            width: 100%;
            max-width: 1000px;
        }

        .card {
            background: #fbf7f2;
            border: 1px solid #dfd0c2;
            border-radius: 12px;
            padding: 40px;
            width: 380px;
            text-align: center;
            box-shadow: 0 3px 12px #704f3910;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 35px;
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
            margin-top: 5px;
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

        .forgot {
            margin-top: 20px;
            font-size: 13px;
        }

        .footer {
            margin-top: 55px;
            padding-top: 25px;
            border-top: 1px solid #bda795;
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
        }

        @media (max-width: 850px) {
            .container {
                flex-direction: column;
                align-items: center;
                gap: 25px;
            }

            .card {
                width: 100%;
                max-width: 380px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">
        <div class="logo">
            <span>⌂</span>
            KostKu
        </div>

        <h2>Login</h2>

        <?php if ($errorMessage !== ''): ?>
            <div class="message">
                <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color: green">
                <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="<?= htmlspecialchars(url('/login'), ENT_QUOTES, 'UTF-8') ?>">
            <input
                type="hidden"
                name="_token"
                value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>"
            >

            <div class="form-group">
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value="<?= htmlspecialchars($oldEmail, ENT_QUOTES, 'UTF-8') ?>"
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

            <button type="submit">Masuk</button>
        </form>

        <div class="forgot">
            <a href="#">Lupa password?</a>
        </div>

        <div class="footer">
            <strong>Belum punya akun?</strong><br>
            <a href="<?= htmlspecialchars(route('registrasi'), ENT_QUOTES, 'UTF-8') ?>">
                Registrasi
            </a>
        </div>
    </div>

</div>

</body>
</html>