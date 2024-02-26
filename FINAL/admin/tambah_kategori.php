<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location: ../../masuk.html");
    exit();
}

require_once('backend/config.php');

$query_kategori = mysqli_query($conn, "SELECT * FROM kategori");

$jumlah_buku_per_kategori = array();

while ($kategori = mysqli_fetch_assoc($query_kategori)) {
    $query_jumlah = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM kategori_buku_relasi WHERE kategori_id = {$kategori['id']}");
    $result_jumlah = mysqli_fetch_assoc($query_jumlah);

    $jumlah_buku_per_kategori[$kategori['id']] = $result_jumlah['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/tambah-kategori.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <title>Kategori</title>
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
        <div class="content mt-3" >
            <div class="card">
                <div class="card-body">
                    <form method="post" action="simpan_kategori.php">
                        <div class="from-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_kategori">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn-sm mt-3" style="background-color:rgb(175, 131, 185) ;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>
</html>