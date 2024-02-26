<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'asri_library');


if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
//query untuk mengambil data
$queryJumlahPengguna = "SELECT COUNT(*) AS jumlah_pengguna FROM user";
$queryJumlahBuku = "SELECT COUNT(*) AS jumlah_buku FROM buku";
$queryJumlahKategori = "SELECT COUNT(*) AS jumlah_kategori FROM kategori";
$queryTotalPeminjaman = "SELECT COUNT(*) AS total_peminjaman FROM peminjaman";
//eksekusi querry
$resultJumlahPengguna = mysqli_query($conn, $queryJumlahPengguna);
$resultJumlahBuku = mysqli_query($conn, $queryJumlahBuku);
$resultJumlahKategori = mysqli_query($conn, $queryJumlahKategori);
$resultTotalPeminjaman = mysqli_query($conn, $queryTotalPeminjaman);

//fetch hasil query
$jumlahBuku = mysqli_fetch_assoc($resultJumlahBuku);
$jumlahPengguna = mysqli_fetch_assoc($resultJumlahPengguna);
$jumlahKategori = mysqli_fetch_assoc($resultJumlahKategori);
$totalPeminjaman = mysqli_fetch_assoc($resultTotalPeminjaman);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style="background-color:rgb(254, 235, 254);">
    <nav class="navbar-atas">
        <div class="logo">
            <img src="gambar/logo.png ">
            <p>Asri Library</p>
        </div>
    </nav>
    <div class="container">
        <div class="content mt-3">
            <div class="card" style="background-color: black;">
                <div class="card-body">
                    <a href="home.php" class="btn text-light">Dashboard</a>
                    <a href="tambah-kategori.php" class="btn text-light">Kategori Buku</a>
                    <a href="pendataan-barang.php" class="btn text-light">Buku</a>
                    <a href="daftar-pinjaman.php" class="btn text-light">Peminjaman</a>
                    <a href="laporan.php" class="btn text-light">Laporan Peminjaman</a>
                    <a href="buat-akun-petugas.php" class="btn text-light">Buat Akun Petugas</a>
                    <a href="../index.php" class="btn text-light">Logout</a>
                </div>
            </div>
        </div>
        <div class="mt-0 p-2">
            <?php
            // Mendapatkan tanggal dan waktu saat ini
            $date = date('Y-m-d H:i:s'); // Format tanggal dan waktu default (tahun-bulan-tanggal jam:menit:detik)
            // Mendapatkan hari dalam format teks (e.g., Senin, Selasa, ...)
            $day = date('l');
            // Mendapatkan tanggal dalam format 1 hingga 31
            $dayOfMonth = date('d');
            // Mendapatkan bulan dalam format teks (e.g., Januari, Februari, ...)
            $month = date('F');
            // Mendapatkan tahun dalam format 4 digit (e.g., 2023)
            $year = date('Y');
            ?>
            <h1 class="mt-5 fw-bold">Dashboard - <span class="fs-4 text-secondary">
                    <?php echo $day . " " . $dayOfMonth . " " . " " . $month . " " . $year; ?>
                </span></h1>
            <div class="alert" style="background-color: white; border-color: purple;" role="alert">Selamat Datang Admin
                Di Asri Library <span class="fw-bold text-capitalize">

            </div>
            <div class="content mt-4 ">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body text-center" style="background-color: rgb(175, 131, 185); ">
                                <h4>Pengguna</h4>
                                <h2>
                                    <?php echo $jumlahPengguna['jumlah_pengguna']; ?>
                                </h2>
                                <hr>
                                <a href="#" class="btn btn-dark btn-sm">Lihat Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body text-center" style="background-color: rgb(221, 214, 214);">
                                <h4>Total Buku</h4>
                                <h2>
                                    <?php echo $jumlahBuku['jumlah_buku']; ?>
                                </h2>
                                <hr>
                                <a href="#" class="btn btn-dark btn-sm">Lihat Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body text-center" style="background-color:rgb(238, 203, 248);">
                                <h4>Total Kategori</h4>
                                <h2>
                                    <?php echo $jumlahKategori['jumlah_kategori']; ?>
                                </h2>
                                <hr>
                                <a href="#" class="btn btn-dark btn-sm">Lihat Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body text-center" style="background-color:  rgb(122, 117, 123);">
                                <h4>Total Peminjaman</h4>
                                <h2>
                                    <?php echo $totalPeminjaman['total_peminjaman']; ?>
                                </h2>
                                <hr>
                                <a href="daftar-pinjaman.php" class="btn btn-dark btn-sm">Lihat Data</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mt-5 p-4">
                <?php
                // Mendapatkan tanggal dan waktu saat ini
                $date = date('Y-m-d H:i:s'); // Format tanggal dan waktu default (tahun-bulan-tanggal jam:menit:detik)
                // Mendapatkan hari dalam format teks (e.g., Senin, Selasa, ...)
                $day = date('l');
                // Mendapatkan tanggal dalam format 1 hingga 31
                $dayOfMonth = date('d');
                // Mendapatkan bulan dalam format teks (e.g., Januari, Februari, ...)
                $month = date('F');
                // Mendapatkan tahun dalam format 4 digit (e.g., 2023)
                $year = date('Y');
                ?>
                <div class="content mt-3">
                    <p class="text-center text-primary">@2024 Asri Library By.Asriyati Purnami</p>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
</body>


</html>