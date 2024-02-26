<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
elseif($_SESSION['role']!=='admin'){
    header("Location: ../../masuk.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/data.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/maxtext.css">
    <link rel="stylesheet" type="text/css" href="css/active.css">
    <title>Pendataan Barang</title>
</head>

<body>
    <nav class="navbar-atas">
        <div class="logo">
            <p>Z-LIB</p>
        </div>
    </nav>
    <nav class="navbar-bawah">
        <div class="home">
            <a href="home.php" class="">Home</a>
        </div>
        <div class="home">
            <a href="pendataan-barang.php" class="active">Pendataan</a>
        </div>
        <div class="home">
            <a href="home.html" class="disabled">tambah</a>
        </div>
    </nav>

    <div class="container-atas">
        <a class="tambah-barang" href="tambah-barang.php">Tambah Barang</a>
    </div>
    <div class="container-bawah">

        <?php
        require_once('backend/config.php');
        $query_buku = mysqli_query($conn, "SELECT buku.*, GROUP_CONCAT(kategori.nama_kategori SEPARATOR ', ') AS kategori_nama
                                            FROM buku
                                            LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                                            LEFT JOIN kategori ON kategori.id = kategori_buku_relasi.kategori_id
                                            GROUP BY buku.id");

        while ($row = mysqli_fetch_assoc($query_buku)) {
            $id = $row['id'];
            $judul = $row['judul'];
            $gambar = $row['gambar'];
            $penerbit = $row['penerbit'];
            $kategori_nama = $row['kategori_nama'];
            ?>
            <!--Card-->
            <div class="card-container" style="background-image: url('<?php echo "gambar/" . $gambar; ?>');">
                <div class="card-content">
                    <div class="div-isi">
                        <p class="judul" id="myText">
                            <?php
                            echo strlen($judul) > 30 ? substr($judul, 0, 27) . "..." : $judul;
                            ?>
                        </p>
                        <p class="judul" id="myText">
                            Penerbit: <?php echo $penerbit; ?>
                        </p>
                        <p class="judul" id="myText">
                            Kategori: <?php echo $kategori_nama; ?>
                        </p>
                    </div>

                    <div class="div-button">
                        <button class="hapus" onclick="konfirmasiHapus(<?php echo $id; ?>)">Hapus</button>
                        <button class="edit"><a href="edit.php?id=<?php echo $id; ?>">Edit</a></button>
                    </div>
                </div>

            </div>
            <?php
        }
        mysqli_close($conn);
        ?>

    </div>
    <script>
        function konfirmasiHapus(id) {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus?");
            if (konfirmasi) {
                window.location.href = "backend/hapus.php?id=" + id;
            }
        }
    </script>

</body>

</html>
