<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'petugas') {
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
                    <a href="../index.php" class="btn text-light">Logout</a>
                </div>
            </div>
        </div>

        <div class="content-mt-3" style="margin-top: 20px; ">
            <div class="card">
                <div class="card-body">
                    <?php
                    if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == "tambah") {
                            echo "<div class = 'alert' style ='background-color :#dfceed' >Data Berhasil Ditambahkan</div>";
                        }
                    }
                    if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == "update") {
                            echo "<div class = 'alert' style ='background-color :#dfceed' >Data Berhasil Diupdate</div>";
                        }
                    }
                    if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == "hapus") {
                            echo "<div class = 'alert' style ='background-color :#dfceed' >Data Berhasil Dihapus</div>";
                        }
                    }
                    if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == "duplikat") {
                            echo "<div class = 'alert' style ='background-color :#dfceed' >Data sudah ada</div>";
                        }
                    }
                    ?>
                    <a href="tambah_kategori.php" class="btn btn-sm mt-2"
                        style="background-color: rgb(175, 131, 185) ;">Tambah Data</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query_kategori = mysqli_query($conn, "SELECT * FROM kategori");
                            while ($kategori = mysqli_fetch_assoc($query_kategori)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $no++; ?>
                                    </td>
                                    <td>
                                        <?php echo $kategori['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $kategori['nama_kategori']; ?>
                                    </td>
                                    <?php $jumlah_buku = isset($jumlah_buku_per_kategori[$kategori['id']]) ? $jumlah_buku_per_kategori[$kategori['id']] : 0; ?>
                                    <td>
                                        <?php echo $jumlah_buku ?>
                                    </td>
                                    <td>

                                        <a href="edit_kategori.php?id=<?php echo $kategori['id']; ?>"
                                            class="btn btn-dark btn-sm mb-3">Edit</a>
                                        <a href="hapus.php?id=<?php echo $kategori['id']; ?>"
                                            class="btn btn-danger btn-sm mb-3">Hapus</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Tambah Data -->
        <div class="modal fade" id="#TambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/maxtext.js"></script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>