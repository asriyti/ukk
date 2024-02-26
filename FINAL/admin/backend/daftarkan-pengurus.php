<?php
require("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_lengkap = $_POST['nama-lengkap'];
    $nama_pengguna = $_POST['nama-pengguna'];
    $email = $_POST['email'];
    $kata_sandi = password_hash($_POST['kata-sandi'], PASSWORD_DEFAULT);
    $alamat = $_POST['alamat'];
    $default_role = 'petugas';

    $check_query = mysqli_query($conn, "SELECT * FROM user WHERE username='$nama_pengguna' OR email='$email'");
    if (mysqli_num_rows($check_query) > 0) {
        echo "<script>alert('Username or email already exists. Please choose a different one.'); window.location.href='../home.html';</script>";
        exit();
    } else {
        $register_query = mysqli_query($conn, "INSERT INTO user (nama_lengkap, username, email, password, alamat, role) VALUES ('$nama_lengkap', '$nama_pengguna', '$email', '$kata_sandi', '$alamat', '$default_role')");

        if ($register_query) {
            echo "<script>alert('Regristation suscesful.'); window.location.href='../buat-akun-petugas.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.'); window.location.href='../buat-akun-petugas.php';</script>";
            exit();
        }
    }
}
?>
