<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/Pengguna.php";

class RegistrasiController
{
    private $pengguna;

    public function __construct($conn)
    {
        $this->pengguna = new Pengguna($conn);
    }

    public function registrasi()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nama = trim($_POST["nama"]);
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            $role = $_POST["role"];

            // Validasi sederhana
            if (empty($nama) || empty($email) || empty($password) || empty($role)) {
                return "Semua data wajib diisi.";
            }

            // Cek email
            if ($this->pengguna->cekEmail($email)) {
                return "Email sudah terdaftar.";
            }

            // Password di-hash
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Simpan pengguna
            if ($this->pengguna->registrasi(
                $nama,
                $email,
                $passwordHash,
                $role
            )) {
                header("Location: index.php?page=login");
                exit;
            }

            return "Registrasi gagal.";
        }

        return null;
    }
}
?>