<?php

require_once __DIR__ . '/../../config/database.php';

class Kamar
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

    public function getAllKamar()
    {
        if (!$this->conn) return [];

        $query = "SELECT * FROM kamar";
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }

    public function countTotalKamar()
    {
        if (!$this->conn) return 0;

        $query = "SELECT COUNT(*) as total FROM kamar";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'] ?? 0;
        }

        return 0;
    }
}
?>