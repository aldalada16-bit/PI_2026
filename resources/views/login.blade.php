<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - KostKu</title>
</head>

<body>

    <h2>Login</h2>

    <!-- Pesan Error Global / Session -->
    @if (session('error'))
        <p style="color:red;">
            {{ session('error') }}
        </p>
    @endif

    <form method="POST" action="/login">
        @csrf

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required>
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit">Login</button>

        @if ($errors->any())
            <p style="color:red;">
                {{ $errors->first() }}
            </p>
        @endif
    </form>

    <p>
        Belum punya akun?
        <a href="/registrasi">Registrasi</a>
    </p>

</body>

</html>