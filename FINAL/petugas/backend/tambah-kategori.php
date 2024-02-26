<?php
require_once('config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $kategori=$_POST['kategori'];
    $check_query = mysqli_query($conn, "SELECT * FROM kategori WHERE nama_kategori='$kategori'");
    if (mysqli_num_rows($check_query) > 0) {
        echo "<script>alert('Kategori Tersebut telah ada. Silahkan buat yang lain.'); window.location.href='../tambah-kategori.php';</script>";
        exit();
    }
    else {
        $insert_query = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ( '$kategori')");

        if ($insert_query) {
            echo "<script>alert('Kategori Berhasil Ditambahkan.'); window.location.href='../tambah-kategori.php';</script>";
        } else {
            echo "<script>alert('Gagal. Coba lagi'); window.location.href='../tambah-kategori.php';</script>";
            exit();
        }
    }

}
?>