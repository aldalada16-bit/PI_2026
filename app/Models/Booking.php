<?php

require_once __DIR__ . '/../../config/database.php';

class Booking
{
    private $conn;

    public function __construct()
    {
        global $conn;

        if ($conn instanceof mysqli && !$conn->connect_error) {
            $this->conn = $conn;
        } else {
            $this->conn = new mysqli("localhost", "root", "", "db_booking_kost");
            if (!$this->conn->connect_error) {
                $this->conn->set_charset("utf8mb4");
            }
        }
    }

    public function countBookingProses()
    {
        if (!$this->conn) return 0;

        // Cek apakah tabel booking ada di database
        $checkTable = $this->conn->query("SHOW TABLES LIKE 'booking'");
        if (!$checkTable || $checkTable->num_rows == 0) {
            return 0;
        }

        // Cek apakah kolom 'status' ada di tabel booking
        $checkColumn = $this->conn->query("SHOW COLUMNS FROM booking LIKE 'status'");

        if ($checkColumn && $checkColumn->num_rows > 0) {
            $query = "SELECT COUNT(*) as total FROM booking WHERE status = 'Menunggu Konfirmasi' OR status = 'Dalam Proses'";
        } else {
            // Jika kolom status belum ada, hitung seluruh data booking yang ada
            $query = "SELECT COUNT(*) as total FROM booking";
        }

        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'] ?? 0;
        }

        return 0;
    }

    public function getBookingTerbaru()
    {
        if (!$this->conn) return [];

        $checkTable = $this->conn->query("SHOW TABLES LIKE 'booking'");
        if (!$checkTable || $checkTable->num_rows == 0) {
            return [];
        }

        $query = "SELECT * FROM booking LIMIT 5";
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }
}
?>