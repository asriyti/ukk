<?php
require_once('backend/config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../masuk.html");
    exit();
}

$user_id = $_SESSION["user_id"];

// Proses pencarian
if (isset($_GET['q'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['q']);
    $query = mysqli_query($conn, "SELECT buku.id, buku.judul, COALESCE(AVG(ulasan.rating), 0) AS rating, buku.gambar 
        FROM koleksi
        JOIN buku ON koleksi.buku_id = buku.id
        LEFT JOIN ulasan_buku AS ulasan ON buku.id = ulasan.buku_id
        WHERE koleksi.user_id='$user_id' AND buku.judul LIKE '%$keyword%'
        GROUP BY buku.id");
} else {
    // Jika tidak ada keyword pencarian
    $query = mysqli_query($conn, "SELECT buku.id, buku.judul, COALESCE(AVG(ulasan.rating), 0) AS rating, buku.gambar 
        FROM koleksi
        JOIN buku ON koleksi.buku_id = buku.id
        LEFT JOIN ulasan_buku AS ulasan ON buku.id = ulasan.buku_id
        WHERE koleksi.user_id='$user_id'
        GROUP BY buku.id");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi</title>
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

        /*aaaaaaaaaaaaaaaaa*/

        .container-bawah {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        /*aaaaaaaaaaaaaaaaa*/

        .card-container {
            box-sizing: border-box;
            width: calc(14.2857% - 10px);
            height: 280px;
            border-radius: 10px;
            margin-left: 10px;
            margin-top: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            text-decoration: none;
            background-size: cover;
            /* Atau gunakan 'contain' sesuai kebutuhan */
            background-position: center;
            /* Opsional: atur posisi background image */
            background-repeat: no-repeat;
        }

        .card-container-atas {
            height: 60px;
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-judul {
            background-color: rgba(0, 0, 255, 0.267);
            margin-top: 5px;
            color: white;
            margin-bottom: 0;
        }

        .card-rating {
            color: black;
            background-color: yellow;
            width: 40px;
            text-align: center;
            margin-top: 2px;
        }

        .card-container-bawah {
            height: 55px;
            width: 100%;
            margin-top: auto;
            display: flex;
            flex-direction: column;
        }

        .card-link:hover {
            background-color: blue;
        }

        .hapus {
            margin-top: auto;
            text-decoration: none;
            margin-left: 5px;
            background-color: rgb(255, 0, 0);
            width: 50px;
            margin-bottom: 5px;
            color: white;
        }

        .lihat {
            width: 50px;
            margin-bottom: 5px;
            text-decoration: none;
            margin-left: 5px;
            background-color: yellow;
            color: black;

        }

        @media (max-width: 1200px) {
            .card-container {
                width: calc(16.666% - 10px);
                /* 6 cards per row for smaller screens */
            }
        }

        @media (max-width: 992px) {
            .card-container {
                width: calc(20% - 10px);
                /* 5 cards per row for even smaller screens */
            }
        }

        @media (max-width: 768px) {
            .card-container {
                width: calc(25% - 10px);
                /* 4 cards per row for small screens */
            }
        }

        @media (max-width: 576px) {
            .card-container {
                width: calc(33.333% - 10px);
                /* 3 cards per row for extra small screens */
            }
        }

        @media (max-width: 480px) {
            .card-container {
                width: calc(50% - 10px);
                /* 2 cards per row for even smaller screens */
            }
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
                        <input type="search" id="inputCari" name="q" placeholder="cari..." class="nav-search"
                            value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>" style="margin-left: 317px;">
                        <button type="submit" class="nav-search-button">Cari</button>
                    </form>
                </div>
            </div>

    </nav>

    <div class="container-bawah">
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <div class="card-container" style="background-image: url('../admin/gambar/<?php echo $row['gambar']; ?>');">
                <div class="card-container-atas">
                    <p class="card-judul">
                        <?php echo $row['judul']; ?>
                    </p>
                    <p class="card-rating">
                        <?php echo intval($row['rating']); ?>/10
                    </p>
                </div>
                <div class="card-container-bawah">
                    <a href="#" class="hapus" onclick="konfirmasiHapus(<?php echo $row['id']; ?>)">Hapus</a>
                    <a href="detail-buku.php?id=<?php echo $row['id']; ?>" class="lihat">Lihat</a>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Tampilkan pesan jika ada -->
        <?php if (!empty($_SESSION['pesan'])): ?>
            <script>
                alert('<?php echo $_SESSION['pesan']; ?>');
            </script>
            <?php unset($_SESSION['pesan']); ?>
        <?php endif; ?>
    </div>

    <script>
        function konfirmasiHapus(bukuId) {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus buku ini dari koleksi?");
            if (konfirmasi) {
                window.location.href = "backend/hapus.php?id=" + bukuId;
            }
        }

        document.getElementById('formCari').addEventListener('submit', function (event) {
            event.preventDefault(); // Menghentikan pengiriman form
            var keyword = document.getElementById('inputCari').value;
            window.location.href = 'koleksi.php?q=' + keyword;
        });
    </script>
</body>

</html>