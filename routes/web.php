<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard/pemilik', function () {
    if (session('role') !== 'Pemilik Kost') {
        return redirect('/login');
    }
    return view('dashboard_pemilik');
})->name('dashboard.pemilik');

// Route Kelola Data Kost & Kamar
Route::get('/kelola-kost-kamar', function () {
    return view('kelola_kost_kamar');
});

Route::get('/kelola-kost', function () {
    return view('kelola_data_kost');
});

Route::get('/kelola-kost/tambah', function () {
    return view('tambah_data_kost');
});

Route::get('/kelola-kamar', function () {
    if (session('role') !== 'Pemilik Kost') {
        return redirect('/login');
    }
    return view('kelola_kamar');
});