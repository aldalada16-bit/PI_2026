<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Kost & Kamar - KostKu</title>

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
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background-color: #765238;
            color: white;
            padding: 22px 15px;
            display: flex;
            flex-direction: column;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 30px;
            padding-left: 5px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.2;
        }

        .menu a:hover,
        .menu a.active {
            background-color: #d9a17e;
        }

        .menu-icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .logout {
            margin-top: auto;
        }

        .logout a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            font-size: 14px;
            font-weight: bold;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 25px 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .header h1 {
            font-size: 24px;
            color: #111;
            font-weight: bold;
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #333;
            font-size: 18px;
        }

        /* CARDS GRID */
        .card-selection-grid {
            display: flex;
            gap: 25px;
        }

        .selection-card {
            background-color: white;
            border: 1px solid #d5d0cc;
            border-radius: 4px;
            padding: 25px 20px;
            width: 320px;
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .selection-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-icon {
            font-size: 32px;
            color: #765238;
            margin-bottom: 15px;
        }

        .card-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .card-title {
            font-size: 15px;
            font-weight: bold;
            color: #111;
        }

        .card-arrow {
            font-size: 16px;
            font-weight: bold;
            color: #111;
        }

        .card-desc {
            font-size: 12px;
            color: #888;
            line-height: 1.4;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="logo">
                <span>⌂</span>
                <span>KostKu</span>
            </div>

            <nav class="menu">

                <a href="{{ url('/dashboard') }}">
                    <span class="menu-icon">⌂</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ url('/kelola-kost-kamar') }}" class="active">
                    <span class="menu-icon">▤</span>
                    <span>Kelola Data Kost & Kamar</span>
                </a>

                <a href="{{ url('/memproses-booking') }}">
                    <span class="menu-icon">📅</span>
                    <span>Memproses Booking</span>
                </a>

                <a href="{{ url('/pembayaran') }}">
                    <span class="menu-icon">💳</span>
                    <span>Pembayaran</span>
                </a>

                <a href="{{ url('/profil-kost') }}">
                    <span class="menu-icon">👤</span>
                    <span>Profil Kost</span>
                </a>

            </nav>

            <div class="logout">
                <a href="{{ url('/logout') }}">
                    <span class="menu-icon">↪</span>
                    <span>Logout</span>
                </a>
            </div>

        </aside>


        <!-- CONTENT -->
        <main class="content">

            <!-- HEADER -->
            <div class="header">
                <h1>Kelola Data Kost & Kamar</h1>

                <div class="header-icons">
                    <span>🔔</span>
                    <span>👤</span>
                </div>
            </div>


            <!-- CARD SELECTION -->
            <div class="card-selection-grid">

                <!-- CARD 1: KELOLA DATA KOST -->
                <a href="{{ url('/kelola-kost') }}" class="selection-card">
                    <div class="card-icon">⌂</div>
                    <div class="card-title-row">
                        <span class="card-title">Kelola Data Kost</span>
                        <span class="card-arrow">›</span>
                    </div>
                    <p class="card-desc">
                        Tambah, ubah, atau hapus data kost yang anda kelola
                    </p>
                </a>

                <!-- CARD 2: KELOLA DATA KAMAR -->
                <a href="{{ url('/kelola-kamar') }}" class="selection-card">
                    <div class="card-icon">⌂</div>
                    <div class="card-title-row">
                        <span class="card-title">Kelola Data Kamar</span>
                        <span class="card-arrow">›</span>
                    </div>
                    <p class="card-desc">
                        Atur infromasi kamar, tipe, harga, dan ketersediaan
                    </p>
                </a>

            </div>

        </main>

    </div>

</body>

</html>