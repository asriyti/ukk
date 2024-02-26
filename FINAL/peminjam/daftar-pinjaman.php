<?php
// Sertakan file konfigurasi database
require_once('backend/config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../masuk.html");
    exit();
} elseif ($_SESSION['role'] !== 'peminjam') {
    header("Location:../masuk.html");
    exit();
}

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi variabel pencarian
$query = "";
if (isset($_GET['query'])) {
    $query = $_GET['query'];
}

// Query untuk mengambil informasi buku, peminjaman, dan user berdasarkan user ID dan query pencarian
$user_id = $_SESSION['user_id']; // Menggunakan user ID dari sesi
$sql = "SELECT buku.judul AS judul_buku, buku.gambar AS gambar_buku, peminjaman.id AS id_peminjaman, peminjaman.tanggal_peminjaman, peminjaman.tanggal_pengembalian, peminjaman.status_peminjaman
FROM peminjaman
INNER JOIN buku ON peminjaman.buku_id = buku.id
INNER JOIN user ON peminjaman.user_id = user.id
WHERE user.id = $user_id";

// Tambahkan kondisi pencarian jika query tidak kosong
if (!empty($query)) {
    $sql .= " AND (buku.judul LIKE '%$query%' OR buku.penulis LIKE '%$query%' OR buku.penerbit LIKE '%$query%')";
}

$result = $conn->query($sql);
?>

<!-- ... (HTML code) ... -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>daftar-pinjaman</title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <script src="css/script.js" defer></script>

    <style>
        .navbar-atas {
            width: 100%;
            height: 50px;
        }

        .logo {
            height: 100%;
            margin: 0;
            width: 100%;
            display: flex;
            background-color: rgb(126, 80, 136);
        }

        .logo p {
            color: rgb(255, 255, 255);
            font-size: 30px;
            font-family: Inter;
            font-weight: 200;
            word-wrap: break-word;
            margin-left: 10px;
            margin-top: 8px;
            font-style: normal;
        }

        .nav-bawah-container {
            width: 100%;
            height: 80px;
            display: flex;
            background-color: black;
        }

        .nav-search-container {
            width: 70%;
            height: 100%;
            margin-left: auto;

        }

        .nav-bawah-kiri {
            width: 70%;
            height: 100%;
            display: flex;
            font-size: 25px;
            margin-left: 20px;
        }

        .nav-kategori-container {
            width: 150px;
            height: 100%;
            text-decoration: none;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            margin: 2px;
        }

        .nav-search {
            height: 38px;
            margin-top: 9px;
            width: 38%;
            border-radius: 5px;
            padding-left: 10px;
        }



        .nav-search-button {
            height: 38px;
            margin-top: 17px;
            width: 50px;
            text-align: center;
            border-radius: 7px;
            border: none;
        }

        body {
            margin: 0;
        }

        .card-container {
            width: 100%;
            background-color: rgb(231, 221, 233);
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            /* Menambahkan properti flex-wrap */
        }

        .card {
            width: 220px;
            height: 430px;
            background-color: rgb(231, 221, 233);
            margin-top: 10px;
        }

        .card-top {
            width: 100%;
            height: 300px;
            background-color: blue;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card-bottom {
            width: 100%;
            height: 90px;
            background-color: white;

        }

        .card-title {
            background-color: rgb(126, 80, 136);
            color: white;
            width: 100%;
            margin-top: 0;
            height: 43px;
            font-size: 20px;

        }

        .card-bottom p {
            margin: 0;
            padding-top: 10px;
        }

        
    </style>
</head>

<body style="background-color:rgb(231, 221, 233) ;">
    <nav class="nav-container">
        <div class="nav-atas-container">
            <div class="logo">
                <img src="gambar/logo.png ">
                <p class="nav-logo-title" style="font-family: Inter;">Asri Library</p>

            </div>
        </div>
        <div class="nav-bawah-container">
            <div class="nav-bawah-kiri">
                <a href="home.php" class="nav-home-container active" style="color: white;">Home</a>
                <div class="nav-kategori-container">
                    <a href="kategori.php" class="nav-kategori-container active"
                        style="color: white; margin-left: 25px;">Kategori</a>
                </div>

                <a href="koleksi.php" class="nav-koleksi-container"
                    style="font-size: 22px; margin-left: 20px; margin-top: 31px; color: white;">Koleksi</a>
                <a href="daftar-pinjaman.php" class="nav-pinjaman-container"
                    style="font-size: 22px; margin-left: 50px; margin-top: 31px; color: white;">Pinjaman</a>
                <a href="../index.php" class="nav-logout-container"
                    style="font-size: 22px; margin-left: 70px; margin-top: 31px; color: white;">Logout</a>

                <div class="dropdown-container">
                    <div class="dropdown" id="dropdownMenu">
                        <a href="koleksi.php" class="">Koleksi</a>
                        <a href="daftar-pinjaman.php" class="">Pinjaman</a>
                        <a href="../index.php" class="">Logout</a>
                    </div>
                </div>
            </div>
            <div class="nav-search-container">
                <form id="formCari" method="get" action="">
                    <input type="search" id="inputCari" name="query" placeholder="cari..." class="nav-search"
                        value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" style="margin-left: 315px;">
                    <button type="submit" class="nav-search-button">Cari</button>
                </form>
            </div>
        </div>

    </nav>

    <div class="card-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php foreach ($result as $buku): ?>
                <div class="card">
                    <div class="card-top"
                        style="background-image: url('<?php echo "../admin/gambar/" . $buku['gambar_buku']; ?>');">
                        <p class="card-title">
                            <?php echo (strlen($buku['judul_buku']) > 30) ? substr($buku['judul_buku'], 0, 27) . '...' : $buku['judul_buku']; ?>
                        </p>
                    </div>

                    <div class="card-bottom">
                        <p>Tanggal:
                            <?php echo $buku['tanggal_peminjaman']; ?>
                        </p>
                        <p>Batas Waktu:
                            <?php echo $buku['tanggal_pengembalian']; ?>
                        </p>
                        <p>Status:
                            <?php echo $buku['status_peminjaman']; ?>
                        </p>

                    </div>
                 
                </div>

            <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
    </div>
</body>

</html>