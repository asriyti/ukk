<?php
session_start();

$conn=mysqli_connect('localhost','root','','asri_library');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'petugas') {
    header("Location: ../../index.php");
    exit();
}

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
                    <a href="../index.php" class="btn text-light">Logout</a>
                </div>
            </div>
        </div>
        <?php

        // Periksa apakah parameter $_GET['kategori_id'] ada
        if (isset($_GET['id'])) {
            // Ambil nilai dari parameter URL tanpa tanda '$'
            $id = $_GET['id'];

            // Query untuk mengambil data kategori berdasarkan kategori_id
            $data = mysqli_query($conn, "SELECT * FROM kategori WHERE id='$id'");

            // Periksa apakah ada data yang ditemukan
            if (mysqli_num_rows($data) > 0) {
                // Tampilkan data dalam bentuk form
                while ($d = mysqli_fetch_array($data)) {
                    ?>
                    <div class="content mt-3">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="update_kategori.php">
                                    <div class="form-group">
                                        <label>Nama Kategori</label>
                                        <!-- Hilangkan spasi sebelum tanda kurung siku -->
                                        <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                        <input type="text" class="form-control" value="<?php echo $d['nama_kategori']; ?>"
                                            name="nama_kategori">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn-sm mt-3"
                                            style="background-color:rgb(175, 131, 185) ;">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                } // Tutup while loop
            } else {
                // Tampilkan pesan jika tidak ada data yang ditemukan
                echo "Data kategori tidak ditemukan.";
            }
        } else {
            // Tampilkan pesan jika parameter kategori_id tidak tersedia
            echo "Parameter kategori_id tidak tersedia.";
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
</body>

</html>