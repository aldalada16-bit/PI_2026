<?php

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\DashboardController;

// Halaman awal
Route::get('/', function () {
    return redirect()->route('login');
});

// REGISTRASI
Route::get('/registrasi', function () {
    return view('registrasi');
})->name('registrasi');

Route::post('/registrasi', [LoginController::class, 'registrasi'])
    ->name('registrasi.store');

// LOGIN
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

    
Route::get('/profil', function () {
    if (!session()->has('id_pengguna')) {
        return redirect('/login');
    }

    $pengguna = Pengguna::find(session('id_pengguna'));

    if (!$pengguna) {
        return redirect('/login');
    }

    ob_start();
    require resource_path('views/profil.php');

    return response(ob_get_clean());
});

Route::post('/profil', function (Request $request) {
    if (!session()->has('id_pengguna')) {
        return redirect('/login');
    }

    $pengguna = Pengguna::find(session('id_pengguna'));

    if (!$pengguna) {
        return redirect('/login');
    }

    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:100',
        'email' => [
            'required',
            'email',
            'max:150',
            'unique:pengguna,email,' .
                $pengguna->id_pengguna . ',id_pengguna',
        ],
        'no_hp' => 'nullable|string|max:20',
        'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect('/profil')->with(
            'error',
            'Data tidak valid. Periksa kembali email, nomor HP, jenis kelamin, dan foto profil (maksimal 2 MB).'
        );
    }

    $pengguna->nama = $request->input('nama');
    $pengguna->email = $request->input('email');
    $pengguna->no_hp = $request->input('no_hp');
    $pengguna->jenis_kelamin = $request->input('jenis_kelamin');

    if ($request->hasFile('foto_profil')) {
        $fotoBaru = $request->file('foto_profil')->store('profil', 'public');

        if (!$fotoBaru) {
            return redirect('/profil')->with(
                'error',
                'Foto profil gagal diunggah. Silakan coba lagi.'
            );
        }

        if ($pengguna->foto_profil) {
            Storage::disk('public')->delete($pengguna->foto_profil);
        }

        $pengguna->foto_profil = $fotoBaru;
    }

    $pengguna->save();

    session()->put([
        'nama' => $pengguna->nama,
        'email' => $pengguna->email,
    ]);

    return redirect('/profil')->with(
        'success',
        'Profil berhasil diperbarui!'
    );
});

// Dashboard semua role
Route::get('/dashboard', [DashboardController::class, 'tampilkan'])
    ->name('dashboard');



Route::get('/dashboard/pencari', function () {

    if (!session()->has('id_pengguna')) {
        return redirect('/login');
    }

    if (session('role') !== 'Pencari Kost') {
        abort(403, 'Akun ini bukan Pencari Kost.');
    }

    $daftarKost = \Illuminate\Support\Facades\DB::table('kost')
        ->where('nama_kost', 'like', '%YS Kost Putri%')
        ->orderBy('id_kost', 'desc')
        ->get();

    foreach ($daftarKost as $kost) {
        $kost->daftar_kamar = \Illuminate\Support\Facades\DB::table('kamar')
            ->where('id_kost', $kost->id_kost)
            ->orderBy('harga')
            ->get();

    $daftarKamar = $kost->daftar_kamar;

    }

    ob_start();
    require resource_path('views/dashboard_pencari.php');
    return response(ob_get_clean());

})->name('dashboard.pencari');




Route::get('/cari-kost', function () {
    if (!session()->has('id_pengguna')) {
        return redirect('/login');
    }

    if (session('role') !== 'Pencari Kost') {
        abort(403, 'Akun ini bukan Pencari Kost.');
    }

   
    $query = \Illuminate\Support\Facades\DB::table('kost')
        ->select(
            'kost.id_kost',
            'kost.nama_kost',
            'kost.alamat',
            'kost.deskripsi',
            'kost.foto_kost'
        );

if (request('q')) {
    $kataKunci = request('q');

    $query->where(function ($q) use ($kataKunci) {
        $q->where('kost.nama_kost', 'like', "%{$kataKunci}%")
          ->orWhere('kost.alamat', 'like', "%{$kataKunci}%");
    });
}

if (request('tipe')) {
    $query->whereExists(function ($subquery) {
        $subquery->selectRaw('1')
            ->from('kamar')
            ->whereColumn('kamar.id_kost', 'kost.id_kost')
            ->where('kamar.tipe_kamar', request('tipe'));
    });
}

if (request('harga_min') !== null && request('harga_min') !== '') {
    $query->whereExists(function ($subquery) {
        $subquery->selectRaw('1')
            ->from('kamar')
            ->whereColumn('kamar.id_kost', 'kost.id_kost')
            ->where('kamar.harga', '>=', (float) request('harga_min'));
    });
}

if (request('harga_max') !== null && request('harga_max') !== '') {
    $query->whereExists(function ($subquery) {
        $subquery->selectRaw('1')
            ->from('kamar')
            ->whereColumn('kamar.id_kost', 'kost.id_kost')
            ->where('kamar.harga', '<=', (float) request('harga_max'));
    });
}

if (request('fasilitas')) {
    foreach ((array) request('fasilitas') as $fasilitas) {
        $query->whereExists(function ($subquery) use ($fasilitas) {
            $subquery->selectRaw('1')
                ->from('kamar')
                ->whereColumn('kamar.id_kost', 'kost.id_kost')
                ->where('kamar.fasilitas', 'like', '%' . $fasilitas . '%');
        });
    }
}

$daftarKost = $query->orderBy('kost.nama_kost')->get();

foreach ($daftarKost as $kost) {
    $kost->daftar_kamar = \Illuminate\Support\Facades\DB::table('kamar')
        ->where('id_kost', $kost->id_kost)
        ->orderBy('harga')
        ->get();
}


    ob_start();
    require resource_path('views/cari_kost.php');
    return response(ob_get_clean());
})->name('cari.kost');


/* PILIHAN TIPE KAMAR */

/* PILIHAN TIPE KAMAR */
Route::get('/kost/{id_kost}/tipe-kamar', function ($id_kost) {
    if (!session()->has('id_pengguna')) {
        return redirect('/login');
    }

    if (session('role') !== 'Pencari Kost') {
        abort(403, 'Akun ini bukan Pencari Kost.');
    }

    $kost = \Illuminate\Support\Facades\DB::table('kost')
        ->where('id_kost', $id_kost)
        ->first();

    if (!$kost) {
        abort(404, 'Data kost tidak ditemukan.');
    }

    $daftarKamar = \Illuminate\Support\Facades\DB::table('kamar')
        ->where('id_kost', $id_kost)
        ->orderBy('harga')
        ->get();

    $kost->daftar_kamar = $daftarKamar;
    $daftarKost = collect([$kost]);
    $modeTipeKamar = true;

    ob_start();
    require resource_path('views/cari_kost.php');

    return response(ob_get_clean())
        ->header('Content-Type', 'text/html; charset=UTF-8');
})->name('kost.tipe-kamar');



Route::get('/riwayat-booking', function () {
    if (!session()->has('id_pengguna')) {
        return redirect('/login');
    }

    if (session('role') !== 'Pencari Kost') {
        abort(403, 'Akun ini bukan Pencari Kost.');
    }

    ob_start();
    require resource_path('views/riwayat_booking.php');

    return response(ob_get_clean());
})->name('riwayat.booking');


// Dashboard Pemilik Kost
Route::get('/dashboard/pemilik', function () {
    if (session('role') !== 'Pemilik Kost') {
        return redirect()->route('login');
    }

    return app(DashboardController::class)->tampilkan();
})->name('dashboard.pemilik');

// Dashboard Admin
Route::get('/dashboard/admin', function () {
    if (session('role') !== 'Admin') {
        return redirect()->route('login');
    }

    return app(DashboardController::class)->tampilkan();
})->name('dashboard.admin');

// Kelola Data Kost & Kamar
Route::get('/kelola-kost-kamar', function () {
    if (session('role') !== 'Pemilik Kost') {
        return redirect()->route('login');
    }

    return view('kelola_kost_kamar');
})->name('kelola.kost.kamar');

Route::get('/kelola-kost', function () {
    if (session('role') !== 'Pemilik Kost') {
        return redirect()->route('login');
    }

    return view('kelola_data_kost');
})->name('kelola.kost');

Route::get('/kelola-kost/tambah', function () {
    if (session('role') !== 'Pemilik Kost') {
        return redirect()->route('login');
    }

    return view('tambah_data_kost');
})->name('kelola.kost.tambah');

Route::get('/kelola-kamar', function () {
    if (session('role') !== 'Pemilik Kost') {
        return redirect()->route('login');
    }

    return view('kelola_kamar');
})->name('kelola.kamar');


/* DETAIL KAMAR */
Route::get('/kamar/{id_kamar}', function ($id_kamar) {

    if (!session()->has('id_pengguna')) {
        return redirect('/login');
    }

    if (session('role') !== 'Pencari Kost') {
        abort(403, 'Akun ini bukan Pencari Kost.');
    }

    $detailKamar = DB::table('kamar')
        ->join('kost', 'kamar.id_kost', '=', 'kost.id_kost')
        ->select(
            'kamar.*',
            'kost.nama_kost',
            'kost.alamat as alamat_kost',
            'kost.deskripsi as deskripsi_kost',
            'kost.foto_kost'
        )
        ->where('kamar.id_kamar', $id_kamar)
        ->first();

    if (!$detailKamar) {
        abort(404, 'Kamar tidak ditemukan.');
    }

    ob_start();

    require resource_path('views/detail_kamar.php');

    return response(ob_get_clean())
        ->header('Content-Type', 'text/html; charset=UTF-8');

})->name('kamar.detail');
