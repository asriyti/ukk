<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'asri_library');

// Fungsi untuk melakukan pencarian buku
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


// Proses pencarian jika form dikirimkan
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $buku_perpus = searchBooks($conn, $keyword);
} else {
    // Jika tidak ada pencarian, tampilkan semua buku
    $buku_perpus = mysqli_query($conn, "SELECT * FROM buku");
    // Jika tombol kategori diklik, sesuaikan query SQL untuk mengambil buku berdasarkan kategori
    if (isset($_POST['novel'])) {
        $buku_perpus = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori FROM buku 
                                        JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id 
                                        JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id 
                                        WHERE kategori.nama_kategori = 'Novel'");
    } elseif (isset($_POST['kamus'])) {
        $buku_perpus = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori FROM buku 
                                        JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id 
                                        JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id 
                                        WHERE kategori.nama_kategori = 'Kamus'");
    } elseif (isset($_POST['dongeng'])) {
        $buku_perpus = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori FROM buku 
                                        JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id 
                                        JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id 
                                        WHERE kategori.nama_kategori = 'Dongeng'");
    } elseif (isset($_POST['komik'])) {
        $buku_perpus = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori FROM buku 
                                        JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id 
                                        JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id 
                                        WHERE kategori.nama_kategori = 'Komik'");
    } elseif (isset($_POST['ilmupengetahuan'])) {
        $buku_perpus = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori FROM buku 
                                        JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id 
                                        JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id 
                                        WHERE kategori.nama_kategori = 'Ilmu Pengetahuan'");
    } else {
        // Jika tidak ada tombol kategori yang diklik, tampilkan semua buku
        $buku_perpus = mysqli_query($conn, "SELECT buku.*, GROUP_CONCAT(kategori.nama_kategori SEPARATOR ', ') AS kategori_nama 
                                        FROM buku 
                                        LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id 
                                        LEFT JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id 
                                        GROUP BY buku.id");
    }

    // Pastikan untuk menyesuaikan query dengan nama kategori yang sesuai dengan data di database Anda

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>kategori</title>
    <style>
        .navbar-atas {
            width: 100%;
            height: 69px;
        }

        .logo {
            height: 100%;
            margin: 0;
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
        }

        form [type="submit"] {
            background-color: white;
            color: rgb(0, 0, 0);
            height: 35px;
            margin-top: 4px;


        }

        form [type="submit"]:hover {
            background-color: rgb(175, 131, 185);

        }

        form [type="search"] {

            color: rgb(0, 0, 0);
            margin-left: 450px;
            background-color: white;
            height: 35px;
            margin-bottom: 40px;
            margin-top: 3px;
            width: 300px;
        }


        form [type="search"]:hover {
            background-color: white;
        }


        img {
            width: 30px;
        }

        .card {
            width: 300px;
        }

        .card img {
            width: 160px;
            margin-left: 60px;
            padding-top: 10px;
            height: 230px
        }

        .card-title {
            margin-left: 70px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .card-text {
            font-size: 12px;
            font-family: 'Times New Roman';

        }

        .penulis {
            font-family: 'Franklin Gothic Medium', 'Times New Roman';
            font-size: 15px;
            margin-top: 20px;
        }

        .penerbit {
            font-family: 'Franklin Gothic Medium', 'Times New Roman';
            font-size: 15px;

        }

        .selengkapnya {
            font-size: 13px;
            margin-left: 140px;
            margin-top: 25px;
        }

        .selengkapnya2 {
            font-size: 13px;
            margin-left: 140px;



        }

        .row {


            gap: 0.4rem;
        }

        .layout-card-custom {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            height: 70px;
        }
    </style>
</head>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style="background-color:rgb(254, 235, 254);">
    <nav class="navbar-atas">
        <div class="logo">
            <img src="gambar/logo.png " style=" width: 7%;">
            <p>Asri Library</p>
        </div>
    </nav>



    <nav class="navbar-bawah">
        <button class="home" style="background-color:rgb(126, 80, 136); margin-top: 10px; ">
            <a href="home.php" class="btn" style="font-size: 30px;  ">
                <img src="gambar/kembali.png" style="width: 70px; height: 50px;">
            </a>
        </button>
    </nav>


    <form class="d-flex" role="search" action="" method="post">
        <input class="form-control me-2" type="search" placeholder="Cari.." name="keyword" id="keyword"
            style="border: 1px solid black;">
        <button class="btn btn-outline-success" type="submit" name="search" style="border: 1px solid black;  "><img
                src="/img/pencarian.png" alt=""></button>
    </form>



    <!--Btn filter data kategori buku-->
    <div class="d-flex gap-2 mt-4 justify-content-center">
        <form action="" method="post">
            <div class="layout-card-custom">
                <button class="btn btn-dark" type="submit">Semua</button>
                <button type="submit" name="novel" class="btn btn-outline-dark"
                    style="width: 180px; height: 40px;">Novel</button>
                <button type="submit" name="kamus" class="btn btn-outline-dark"
                    style="width: 180px; height: 40px;">Kamus</button>
                <button type="submit" name="dongeng" class="btn btn-outline-dark"
                    style="width: 180px; height: 40px;">Dongeng</button>
                <button type="submit" name="komik" class="btn btn-outline-dark"
                    style="width: 180px; height: 40px;">Komik</button>
                <button type="submit" name="ilmupengetahuan" class="btn btn-outline-dark"
                    style="width: 180px; height: 40px;">Ilmu Pengetahuan</button>
            </div>
        </form>
    </div> <br>
    <div class="row ">

        <?php foreach ($buku_perpus as $d): ?>
            <div class="card" style="width: 19rem;">
                <img src="../admin/gambar/<?= $d["gambar"]; ?>" class="card-img-top" alt="" height="210px;">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= $d["judul"]; ?>
                    </h5>
                </div>
                <ul class="list-group list-group-flush" style="font-size: 14px;">

                    <li class="list-group-item">Penulis :
                        <?= $d["penulis"]; ?>
                    </li>
                    <li class="list-group-item">Penerbit :
                        <?= $d["penerbit"]; ?>
                    </li>

                </ul>


                <div class="card-body">
                    <a class="btn" style="background-color:  rgb(183, 139, 190); color: white; margin-left: 45px;"
                        href="detail-buku.php?id=<?php echo $d['id']; ?>">Lihat Selengkapnya</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>