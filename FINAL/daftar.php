<?php

require("config.php");

class UserManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function registerUser($nama_lengkap, $nama_pengguna, $email, $kata_sandi, $alamat)
    {
        $default_role = 'peminjam';
        $hashed_password = password_hash($kata_sandi, PASSWORD_DEFAULT);

        $check_query = mysqli_query($this->conn, "SELECT * FROM user WHERE username='$nama_pengguna' OR email='$email'");
        if (mysqli_num_rows($check_query) > 0) {
            return "Username or email already exists. Please choose a different one.";
        } else {
            $register_query = mysqli_query($this->conn, "INSERT INTO user (nama_lengkap, username, email, password, alamat, role) VALUES ('$nama_lengkap', '$nama_pengguna', '$email', '$hashed_password', '$alamat', '$default_role')");

            if ($register_query) {
                return "Registration Successful!";
            } else {
                return "Registration failed. Please try again.";
            }
        }
    }
}

// Gunakan kelas UserManager untuk menangani registrasi pengguna
$userManager = new UserManager($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama-lengkap'];
    $nama_pengguna = $_POST['nama-pengguna'];
    $email = $_POST['email'];
    $kata_sandi = $_POST['kata-sandi'];
    $alamat = $_POST['alamat'];

    // Panggil method registerUser untuk melakukan registrasi
    $registration_result = $userManager->registerUser($nama_lengkap, $nama_pengguna, $email, $kata_sandi, $alamat);
    echo "<script>alert('$registration_result'); window.location.href='daftar.html';</script>";
}

?>