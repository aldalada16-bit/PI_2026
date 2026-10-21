<?php

use App\Models\kost;

require_once __DIR__ . '/../Models/Kost.php';

class DashboardController
{
    public function tampilkan()
    {
        if (!isset($_SESSION["id_pengguna"])) {
            header("Location: index.php?page=login");
            exit;
        }

        $role = $_SESSION["role"] ?? '';                               

        if ($role == "Pencari Kost") {

            $kostModel = new Kost();
            $daftarKost = $kostModel->getAllKost();

            // Memastikan path file view dipanggil secara presisi dari lokasi controller ini
            require __DIR__ . '/../views/dashboard_pencari.php';

        } elseif ($role == "Pemilik Kost") {

            require_once __DIR__ . '/../models/Kamar.php';
            require_once __DIR__ . '/../models/Booking.php';
            require_once __DIR__ . '/../models/Kost.php';

            $id_pengguna = $_SESSION['id_pengguna'] ?? 0;

            $kamarModel = new Kamar();
            $bookingModel = new Booking();
            $kostModel = new Kost();

            // Mengambil data kost khusus pemilik yang sedang login
            $daftarKost = $kostModel->getKostByPengguna($id_pengguna);

            $totalKamar = $kamarModel->countTotalKamar();
            $daftarKamar = $kamarModel->getAllKamar();

            $totalBooking = $bookingModel->countBookingProses();
            $daftarBooking = $bookingModel->getBookingTerbaru();

            require __DIR__ . '/../views/dashboard_pemilik.php';


        } elseif ($role == "Admin") {

            require __DIR__ . '/../views/dashboard_admin.php';

        } else {

            echo "Role tidak dikenali.";
        }
    }
}