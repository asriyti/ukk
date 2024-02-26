<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/pendataan-barang.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/maxtext.css">
    <link rel="stylesheet" type="text/css" href="css/active.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Pendataan Barang</title>
    <style>
        .tambah-barang {
            font-size: 18px;
            width: 130px;
            height: 40px;
            background-color: rgb(126, 80, 136);
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
            margin-left: 10px;
            color: white;
            border: 1px solid black;
        }

        .tambah-barang:hover {
            background-color: black;
            color: white;
        }

        .search-submit {
            width: 70px;
            height: 40px;
            margin-top: 15px;
            border-radius: 7px;
            border: none;
            margin-left: 10px;
            background-color: rgb(126, 80, 136);
            color: white;
        }

        .search-submit:hover {
            background-color: black;

        }

        body {
            background-color: white;

        }

        .card-container {
            height: 290px;
            margin-top: 15px;
            border-radius: 10px;
            background-size: cover;
            background-color: purple;

        }

        .search {
            height: 40px;
            width: 300px;
            margin-left: 100px;
            margin-top: 15px;
            border-radius: 7px;
            border: none;
            border: 1px solid black;

        }

        .div-isi {
            margin-top: auto;
            height: 52%;
            width: 100%;

        }

        .judul {
            font-size: 15px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;

        }

        .hapus {
            background-color: red;
            border: none;
            margin-left: 2px;
            border-radius: 7px;


        }

        .edit {
            background-color: yellow;
            border: none;
            margin-left: auto;
            margin-right: 2px;
            border-radius: 5px;
            text-decoration: none;

        }
    </style>
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
        <div class="container-atas">
            <a class="tambah-barang" href="tambah-barang.php">Tambah Barang</a>
            <form method="get" action="pendataan-barang.php" class="search-form">
                <input type="search" name="search" placeholder="Cari.." class="search"
                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <input type="submit" class="search-submit" value="Cari">
            </form>
        </div>

        <div class="container-bawah" style="background-color:rgb(254, 235, 254);">
            <?php
            require_once('backend/config.php');

            // Handle search query
            $search_query = isset($_GET['search']) ? $_GET['search'] : '';
            $search_condition = !empty($search_query) ? "AND (buku.judul LIKE '%$search_query%'
                                                            OR buku.penulis LIKE '%$search_query%'
                                                            OR buku.penerbit LIKE '%$search_query%'
                                                            OR buku.tahun_terbit LIKE '%$search_query%'
                                                            OR kategori.nama_kategori LIKE '%$search_query%'
                                                            OR buku.sinopsis LIKE '%$search_query%'
                                                            OR buku.id IN (
                                                                SELECT buku_id FROM kategori_buku_relasi
                                                                LEFT JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id
                                                                WHERE kategori.nama_kategori LIKE '%$search_query%'
                                                            ))" : '';

            $query_buku = mysqli_query($conn, "SELECT buku.*, GROUP_CONCAT(kategori.nama_kategori SEPARATOR ', ') AS kategori_nama
                                            FROM buku
                                            LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                                            LEFT JOIN kategori ON kategori.id = kategori_buku_relasi.kategori_id
                                            WHERE 1 $search_condition
                                            GROUP BY buku.id");

            while ($row = mysqli_fetch_assoc($query_buku)) {
                $id = $row['id'];
                $judul = $row['judul'];
                $gambar = $row['gambar'];
                $kategori_nama = $row['kategori_nama'];
                $penulis = $row['penulis'];
                $penerbit = $row['penerbit'];
                ?>
                <!--Card-->
                <div class="card-container"
                    style="background-image: url('<?php echo "gambar/" . $gambar; ?>'); border: 2px solid rgb(126, 80, 136);">
                    <div class="card-content">
                        <div class="div-isi">
                            <p class="judull" id="myText"
                                style="font-size: 20px; background-color: white; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:black; ">
                                <?php
                                echo strlen($judul) > 30 ? substr($judul, 0, 27) . "..." : $judul;
                                ?>
                            </p>
                            <p class="judul" id="myText">
                                Kategori :
                                <?php echo $kategori_nama; ?>
                            </p>
                            <p class="judul" id="myText">
                                Penulis :
                                <?php echo $penulis; ?>
                            </p>
                            <p class="judul" id="myText">
                                Penerbit :
                                <?php echo $penerbit; ?>
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

        <script >
            function konfirmasiHapus(id) {
                var konfirmasi = confirm("Apakah Anda yakin ingin menghapus?");
                if (konfirmasi) {
                    window.location.href = "backend/hapus.php?id=" + id;
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

</body>

</html>