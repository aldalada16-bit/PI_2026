<?php

class Pengguna
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Mengecek apakah email sudah terdaftar
    public function cekEmail($email)
    {
        $sql = "SELECT * FROM pengguna WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Menambahkan pengguna baru
    public function registrasi($nama, $email, $password, $role)
    {
        $sql = "INSERT INTO pengguna (nama, email, password, role)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $email, $password, $role);

        return $stmt->execute();
    }

    // Mencari pengguna berdasarkan email
    public function login($email)
    {
        $sql = "SELECT * FROM pengguna WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}
?>