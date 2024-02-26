<?php
require_once('backend/config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'peminjam') {
    header("Location:../index.php");
    exit();
}

function getDaftarKategori($conn)
{
    $query = "SELECT DISTINCT kategori.* FROM kategori
              JOIN kategori_buku_relasi ON kategori.id = kategori_buku_relasi.kategori_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

function getDaftarBukuByKategori($conn, $kategoriId)
{
    $query = "SELECT buku.*, IFNULL(ulasan.rating, 0) AS rating, GROUP_CONCAT(kategori.nama_kategori SEPARATOR ', ') AS kategori_nama
              FROM buku
              LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
              LEFT JOIN kategori ON kategori.id = kategori_buku_relasi.kategori_id
              LEFT JOIN ulasan_buku ulasan ON buku.id = ulasan.buku_id";

    if ($kategoriId) {
        $query .= " WHERE kategori.id = '$kategoriId'";
    }

    $query .= " GROUP BY buku.id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

function getAllBukuByKategori($conn, $kategoriId)
{
    $query = "SELECT buku.*, IFNULL(ulasan.rating, 0) AS rating, GROUP_CONCAT(kategori.nama_kategori SEPARATOR ', ') AS kategori_nama
              FROM buku
              LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
              LEFT JOIN kategori ON kategori.id = kategori_buku_relasi.kategori_id
              LEFT JOIN ulasan_buku ulasan ON buku.id = ulasan.buku_id
              WHERE kategori.id = '$kategoriId'
              GROUP BY buku.id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

function searchBooks($conn, $query)
{
    $query = mysqli_real_escape_string($conn, $query);
    $query = "SELECT buku.*, IFNULL(ulasan.rating, 0) AS rating, GROUP_CONCAT(kategori.nama_kategori SEPARATOR ', ') AS kategori_nama
              FROM buku
              LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
              LEFT JOIN kategori ON kategori.id = kategori_buku_relasi.kategori_id
              LEFT JOIN ulasan_buku ulasan ON buku.id = ulasan.buku_id
              WHERE buku.judul LIKE '%$query%' 
                OR buku.penulis LIKE '%$query%'
                OR kategori.nama_kategori LIKE '%$query%'
              GROUP BY buku.id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}


$daftarKategori = getDaftarKategori($conn);

$selectedKategori = isset($_GET['selected_kategori']) ? $_GET['selected_kategori'] : '';
$query = isset($_GET['query']) ? $_GET['query'] : '';



function getTopRatedBuku($conn, $limit = 7)
{
    // Ambil 7 buku dengan rating tertinggi
    $query = "SELECT buku.id, buku.judul, buku.gambar, IFNULL(ulasan.rating, 0) AS rating
              FROM buku
              LEFT JOIN ulasan_buku ulasan ON buku.id = ulasan.buku_id
              GROUP BY buku.id
              ORDER BY rating DESC
              LIMIT $limit";

    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return false;
    }
}

// Ambil 7 buku top rated
$daftarTopRatedBuku = getTopRatedBuku($conn, 7);
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <script src="css/script.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            margin: 0;
        }

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
            background-color: rgb(126, 80, 136);
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
            margin-left: 52%;
            border-radius: 5px;
            border: none;
            padding-left: 10px;
        }

        .nav-search::placeholder {
            margin-left: 10px;
        }

        .nav-search-button {
            height: 38px;
            margin-top: 17px;
            width: 50px;
            text-align: center;
            border-radius: 7px;
            border: none;
        }

        .kategori-container {
            width: 100%;
            height: 70px;
            background-color: rgb(126, 80, 136);
            display: flex;
            margin-top: 20px;

        }

        .kategori-container p {
            font-size: 28px;
            font-family: 'Aclonica',sans-serif;
            width: auto;
            height: 100%;
            margin-top: 0;
            color: white;
            margin-left: 5px;
            margin-top: 8px;
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
                    style="font-size: 22px; margin-left: 20px; margin-top: 26px; color: white;">Koleksi</a>
                <a href="daftar-pinjaman.php" class="nav-pinjaman-container"
                    style="font-size: 22px; margin-left: 50px; margin-top: 26px; color: white;">Pinjaman</a>
                <a href="../index.php" class="nav-logout-container"
                    style="font-size: 22px; margin-left: 70px; margin-top: 26px; color: white;">Logout</a>

                <div class="dropdown-container">
                    <div class="dropdown" id="dropdownMenu">
                        <a href="koleksi.php" class="">Koleksi</a>
                        <a href="daftar-pinjaman.php" class="">Pinjaman</a>
                        <a href="../index.php" class="">Logout</a>
                    </div>
                </div>
            </div>
            <div class="nav-search-container" style="background-color: black;">
                <form method="get" action="home.php">
                    <input type="search" name="query" placeholder="Cari..." class="nav-search"
                        value="<?php echo $query; ?>">
                    <button type="submit" class="nav-search-button">Cari</button>
                </form>
            </div>
        </div>


    </nav>

    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/img/homepage1.jpeg" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="/img/homepage2.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="/img/homepage3.jpeg" class="d-block w-100" alt="...">
            </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>

        </button>
    </div>
    <span class="placeholder col-12 bg-dark" style="margin-bottom:40px"></span>
    <section>
        <h1
            style="margin-left: 500px; color: rgb(84, 52, 92); padding-bottom: 10px; font-family: Georgia, 'Times New Roman', Times, serif ; font-size: 49px; margin-bottom: 30px;">
            Rating Terbanyak</h1>
        <span class="placeholder col-12 bg-dark" style="margin-bottom:20px"></span>
        <div class="unggulan-container">
            <?php if ($daftarTopRatedBuku): ?>
                <?php foreach ($daftarTopRatedBuku as $buku): ?>
                    <a class="card" href="detail-buku.php?id=<?php echo $buku['id']; ?>"
                        style="background-image: url('<?php echo "../admin/gambar/" . $buku['gambar']; ?>');">
                        <p class="unggulan-judul">
                            <?php echo (strlen($buku['judul']) > 23) ? substr($buku['judul'], 0, 20) . '...' : $buku['judul']; ?>
                        </p>
                        <p class="card-rating">
                            <?php echo $buku['rating']; ?>/10
                        </p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada buku top rated saat ini.</p>
            <?php endif; ?>
        </div>

        <!--menu kategori khusus-->
        <div class="buku-kategori">
            <?php
            $daftarBuku = [];

            if ($query != '') {
                $daftarBuku = searchBooks($conn, $query);
            } elseif ($selectedKategori != '') {
                $daftarBuku = getDaftarBukuByKategori($conn, $selectedKategori);
            } else {
                $daftarBuku = getAllBukuByKategori($conn, '');
            }

            if ($daftarBuku):
                foreach ($daftarBuku as $buku):
                    $judulBuku = (strlen($buku['judul']) > 24) ? substr($buku['judul'], 0, 21) . '...' : $buku['judul'];
                    ?>
                    <!--Card-->
                    <a href="detail-buku.php?id=<?php echo $buku['id']; ?>" class="card-container"
                        style="background-image: url('<?php echo "../admin/gambar/" . $buku['gambar']; ?>');">
                        <div class="card-container-atas">
                            <p class="card-judul">
                                <?php echo $judulBuku; ?>
                            </p>
                            <p class="card-rating">
                                <?php echo $buku['rating']; ?>/10
                            </p>
                        </div>
                        <div class="card-container-bawah">
                            <p class="card-kategori">Kategori:
                                <?php echo $buku['kategori_nama']; ?>
                            </p>
                            <p class="card-penulis">
                                <?php echo (strlen($buku['penulis']) > 20) ? substr($buku['penulis'], 0, 17) . '...' : $buku['penulis']; ?>
                            </p>
                            <p class="card-tahun">Tahun:
                                <?php echo $buku['tahun_terbit']; ?>
                            </p>
                        </div>
                    </a>
                    <?php
                endforeach;
            else:
                ?>
            <?php endif; ?>
        </div>


        <!--menu khusus-->
        <div class="menu-khusus">
            <?php
            foreach ($daftarKategori as $kategori):
                ?>
                <div class="kategori-container">
                    <p>
                        <?php echo $kategori['nama_kategori']; ?>
                    </p>
                </div>

                <div class="container-bawah">
                    <?php
                    $kategoriId = $kategori['id'];
                    $daftarBuku = ($selectedKategori == $kategoriId) ? getDaftarBukuByKategori($conn, $kategoriId) : getAllBukuByKategori($conn, $kategoriId);

                    if ($daftarBuku):
                        foreach ($daftarBuku as $buku):
                            $judulBuku = (strlen($buku['judul']) > 24) ? substr($buku['judul'], 0, 21) . '...' : $buku['judul'];
                            ?>
                            <!--Card-->
                            <a href="detail-buku.php?id=<?php echo $buku['id']; ?>" class="card-container"
                                style="background-image: url('<?php echo "../admin/gambar/" . $buku['gambar']; ?>');">
                                <div class="card-container-atas">
                                    <p class="card-judul">
                                        <?php echo $judulBuku; ?>
                                    </p>
                                    <p class="card-rating">
                                        <?php echo $buku['rating']; ?>/10
                                    </p>
                                </div>
                                <div class="card-container-bawah">
                                    <p class="card-kategori">Kategori:
                                        <?php echo $buku['kategori_nama']; ?>
                                    </p>
                                    <p class="card-penulis">
                                        <?php echo (strlen($buku['penulis']) > 20) ? substr($buku['penulis'], 0, 17) . '...' : $buku['penulis']; ?>
                                    </p>
                                    <p class="card-tahun">Tahun:
                                        <?php echo $buku['tahun_terbit']; ?>
                                    </p>
                                </div>
                            </a>
                            <?php
                        endforeach;
                    else:
                        ?>
                        <p>Tidak ada buku untuk kategori ini.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
</body>

</html>