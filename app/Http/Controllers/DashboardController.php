<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Kamar;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function tampilkan()
    {
        // Memastikan pengguna sudah login
        if (!session()->has('id_pengguna')) {
            return redirect()->route('login');
        }

        $role = session('role', '');

        // DASHBOARD PENCARI KOST
        if ($role === 'Pencari Kost') {

            $nama = session('nama', 'Pencari Kost');

            // Sementara daftar kost kosong jika model belum tersedia
            $daftarKost = [];

            if (class_exists(Kost::class)) {
                $kostModel = new Kost();
                $daftarKost = $kostModel->getAllKost();
            }

            return view('dashboard_pencari', compact(
                'nama',
                'daftarKost'
            ));

        // DASHBOARD PEMILIK KOST
        } elseif ($role === 'Pemilik Kost') {

            $id_pengguna = session('id_pengguna');

            $kostModel = new Kost();
            $kamarModel = new Kamar();
            $bookingModel = new Booking();

            // Mengambil data kost milik pengguna yang login
            $daftarKost = $kostModel->getKostByPengguna(
                $id_pengguna
            );

            $totalKamar = $kamarModel->countTotalKamar();
            $daftarKamar = $kamarModel->getAllKamar();

            $totalBooking = $bookingModel->countBookingProses();
            $daftarBooking = $bookingModel->getBookingTerbaru();

            $nama = session('nama', 'Pemilik Kost');

            return view('dashboard_pemilik', compact(
                'nama',
                'daftarKost',
                'totalKamar',
                'daftarKamar',
                'totalBooking',
                'daftarBooking'
            ));

        // DASHBOARD ADMIN
        } elseif ($role === 'Admin') {

            $nama = session('nama', 'Admin');

            return view('dashboard_admin', compact('nama'));

        } else {

            abort(403, 'Role tidak dikenali.');
        }
    }
}