<?php
require_once('backend/config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../masuk.html");
    exit();
} elseif ($_SESSION['role'] !== 'peminjam') {
    header("Location:../masuk.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$buku_id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM buku WHERE id='$buku_id'");
$row = mysqli_fetch_assoc($query);

// Ambil rating dan jumlah ulasan dari database
$rating_query = mysqli_query($conn, "SELECT IFNULL(AVG(rating), 0) AS average_rating, COUNT(id) AS jumlah_ulasan FROM ulasan_buku WHERE buku_id='$buku_id'");
$rating_data = mysqli_fetch_assoc($rating_query);
$average_rating = number_format($rating_data['average_rating'], 1);

// Handle penambahan ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ulasan = mysqli_real_escape_string($conn, $_POST['ulasan']);
    $rating = min(10, max(1, (int) $_POST['rating'])); // Batasi rating antara 1 dan 10

    $insert_query = "INSERT INTO ulasan_buku (buku_id, user_id, ulasan, rating) VALUES ('$buku_id', '$user_id', '$ulasan', $rating)";
    mysqli_query($conn, $insert_query);

    // Redirect untuk menghindari pengiriman ulasan ganda saat merefresh halaman
    header("Location: detail-buku.php?id=$buku_id");
    exit();
}

// Ambil pesan dari session jika ada
$pesan = isset($_SESSION['pesan']) ? $_SESSION['pesan'] : '';
unset($_SESSION['pesan']); // Hapus pesan dari session setelah ditampilkan

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <style>
        .rating-container {
            display: inline-block;
            font-size: 50px;
            margin-left: 55px;
        }

        .rating-stars {
            color: #ccc;
            cursor: pointer;
        }

        .star {
            display: inline-block;
            transition: color 0.2s;
        }

        .star.active {
            color: orange;
        }

        .isi-ulasan {
            width: 88%;
            margin-left: 6%;
            background-color: white;
            border-radius: 10px;
        }

        .detail-info {
            display: flex;
        }

        .detail-info .col {
            margin-right: 92px;
            /* Memberikan jarak antara kolom-kolom */
            font-size: 18px;

        }

        body {
            margin: 0;
        }

        .konfirmasi-container {
            background-color: rgb(97, 71, 102);
            width: 350px;
            height: 200px;
            border-radius: 10px;
            margin-left: 10px;
            display: none;
            color: white;

        }

        .pinjam-batalkan {
            width: 120px;
            height: 30px;
            background-color: white;
            border: none;
            border-radius: 6px;
            margin-left: 120px;
            margin-top: 10px;
            
        }

        .pinjam-batalkan:hover {
            background-color: grey;
        }

        .pinjam-submit {
            width: 120px;
            height: 30px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 6px;
            margin-left: 120px;
            margin-top: 10px;
            
        }

        .pinjam-submit:hover {
            background-color: grey;
        }

        .pinjam-date {
            width: 345px;
            height: 30px;
        }

        .form-pinjam {
            width: 100%;
        }

        .pinjam-sampai {
            text-align: center;
        }

        .konfirmasi-pinjaman {
            font-size: 20px;
            text-align: center;
        }

        .back-container {
            width: 100%;
            margin-top: 15px;
        }

        .back-logo {
            width: 30px;
            height: 30px;
            margin-left: 20px;
        }

        .judul {
            color: black;
            font-size: 40px;
            font-family: Inter;
            font-weight: 700;
            word-wrap: break-word;
            text-align: center;
            margin-top: 0;
        }

        .container {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .container-atas {
            width: 100%;
            height: 350px;
            display: flex;
        }

        .gambar {
            width: 25%;
            height: 100%;
        }

        .container-atas-tengah {
            width: 60%;
            height: 100%;
        }

        .container-atas-tengah p {
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 10px;
            color: black;
            font-size: 25px;
            font-family: Inter;
            font-weight: 400;
            word-wrap: break-word;
            padding: 25px;
        }

        .container-atas-kanan {
            width: 15%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .rating-containerr,
        .komentar-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 30px;
            background-color: yellow;
            border-radius: 6px;
            margin-left: 10px;
            margin-bottom: 10px;
            margin-top: 5px;
            border: none;
        }

        .komentar-logo {
            width: 30px;
            height: 30px;

        }

        .container-tengah {
            width: 100%;
            height: 400px;
            display: flex;
        }

        .container-tengah-kiri {
            width: 25%;
            height: 100%;
        }

        .button-pinjam {
            margin-left: 0;
            border: none;
            background-color: rgb(97, 71, 102);
            border-radius: 5px;
            color: white;
            width: 188px;
            font-size: 23px;
            height: 48px;
            font-family: 'Times New Roman', Times, serif;
        }

        .button-pinjam:hover {
            background-color: black;
        }

        .button-pinjam a {
            text-decoration: none;

        }

        .button-tambah-favorit {
            margin-left: auto;
            border: none;
            background-color: rgb(254, 235, 254);

        }


        .button-tambah-favorit a {

            text-decoration: none;
            width: 20px;
        }

        .container-tengah-kanan {
            width: 75%;
            height: 100%;
        }

        .container-tengah-kiri-konten {
            display: flex;
            width: 100%;
            height: 40px;
            margin-top: 10px;
        }

        .ulasan {
            width: 117%;
            height: 150px;
            margin-left: 8%;
            margin-top: 10px;
            font-size: 18px;
            background-color: white;
            font-family: 'Times New Roman', Times, serif;

        }

        .rating-text,
        .rating {
            width: 90%;
            margin-left: 8%;
            font-size: 23px;
            margin-bottom: 2px;
        }

        .kirim-ulasan {
            width: 350px;
            height: 45px;
            margin-left: 40%;
            margin-top: 10px;
            background-color: rgb(97, 71, 102);
            border: none;
            border-radius: 2px;
            font-size: 23px;
            font-family: 'Times New Roman', Times, serif;
            color: white;
        }

        .kirim-ulasan:hover {
            width: 350px;
            height: 45px;
            background-color: black;
            border: none;
        }



        .ulasan-username {
            font-size: 25px;
            margin-left: 20px;
        }

        .ulasan-text {
            font-size: 20px;
            padding: 10px;
        }

        @media screen and (max-width: 600px) {
            .container-atas {
                width: 100%;
                height: 490px;
                display: flex;
                flex-direction: column;
            }

            .gambar {
                width: 50%;
                margin-left: 5%;
                height: 250px;
                border-radius: 10px;
            }

            .container-atas-tengah {
                width: 100%;
                height: 150px;
            }

            .container-atas-tengah p {
                margin-top: 0;
                margin-bottom: 0;
                margin-left: 20px;
                color: black;
                font-size: 20px;
                font-family: Inter;
                font-weight: 400;
                word-wrap: break-word;
                padding: 5px;
            }

            .container-atas-kanan {
                width: 100%;
                height: 80px;
                display: flex;
                flex-direction: column;
            }

            .rating-container,
            .komentar-container {
                width: 70px;
            }

            .judul {
                color: black;
                font-size: 30px;
                font-family: Inter;
                font-weight: 700;
                word-wrap: break-word;
                text-align: center;
                margin-top: 0;
            }

            .container-tengah {
                width: 100%;
                height: 400px;
                display: flex;
                flex-direction: column;
            }

            .container-tengah-kiri {
                width: 100%;
                height: 50px;
            }

            .container-tengah-kiri-konten {
                display: flex;
                width: 100%;
                height: 40px;
                margin-top: 0;
            }



            .container-tengah-kanan {
                width: 100%;
            }

            .sinopsis-container {
                width: 96%;
                height: auto;
                background-color: #D9D9D9;
                margin-left: 2%;
                border-radius: 10px;
            }

            .sinopsis-container p {
                color: black;
                font-size: 18px;
                font-family: Inter;
                font-weight: 200;
                word-wrap: break-word;
                padding: 15px;
            }

            .ulasan {
                width: 96%;
                height: 80px;
                margin-left: 2%;
                margin-top: 10px;
                border-radius: 10px;
                font-size: 18px;
                background-color: #D9D9D9;
            }

            .rating-text,
            .rating {
                width: 96%;
                margin-left: 2%;
                font-size: 18px;
                margin-bottom: 2px;
            }

            .kirim-ulasan {
                width: 60px;
                height: 25px;
                margin-left: 45%;
                margin-top: 10px;
                background-color: #D9D9D9;
                border: none;
                border-radius: 2px;
            }

            .kirim-ulasan:hover {
                width: 62px;
                height: 27px;
                background-color: rgba(115, 114, 114, 0.418);
                border: none;
            }

            .isi-ulasan-container {
                width: 98%;
                background-color: #D9D9D9;
                margin-left: 8%;
                margin-top: 100px;
            }
        }

        @media screen and (min-width: 600px) and (max-width: 1195px) {
            .sinopsis-container {
                height: auto;
            }

            .container-tengah {
                height: auto;
            }
        }
    </style>

</head>

<body style="background-color:rgb(254, 235, 254);">
    <a href="kategori.php" class="back-container">
        <img src="../back.png" class="back-logo">
    </a>

    <div class="konfirmasi-container">
        <p class="konfirmasi-pinjaman">Konfirmasi Peminjaman</p>
        <p class="pinjam-sampai">pinjam sampai tanggal:
        <form class="form-pinjam" method="post" action="backend/pinjam.php?buku_id=<?php echo $buku_id; ?>">
            <input type="date" class="pinjam-date" name="pengembalian" required>
            <input type="submit" value="submit" class="pinjam-submit">
        </form>
        <button class="pinjam-batalkan" onclick="hideDisplay()">Batalkan</button>
    </div>


    <p class="judul">
        <?php echo $row['judul']; ?>
    </p>

    <div class="container">
        <!--Container atas-->
        <div class="container-atas">
            <img class="gambar" src="../admin/gambar/<?php echo $row['gambar']; ?>"
                style="width: 250px; height: 400px; margin-left: 40px;">
            <div class="container-atas-tengah" style="margin-left: 90px;">
                <h2 style="margin-left: 35px; ">Description</h2>
                <p id="myText" style="font-size: 18px;">
                    <?php echo $row['sinopsis']; ?>
                </p>

                <h2 style="margin-left: 35px;">Detail Buku</h2>
                <div class="detail-info">
                    <div class="col" style="margin-left: 40px;">Penulis <br>
                        <?php echo $row['penulis']; ?>
                    </div>
                    <div class="col">Penerbit <br>
                        <?php echo $row['penerbit']; ?>
                    </div>
                    <div class="col">Tahun Terbit <br>
                        <?php echo $row['tahun_terbit']; ?>
                    </div>
                </div>
                <br>
                <h2 style="margin-left: 35px;">ID Buku</h2>
                <div class="col" style="margin-left: 40px; font-size: 22px;">
                    <?php echo $row['id']; ?>
                </div>

                <br><br>

                <h1 style="margin-left: 35px; font-size: 25px;">Ulasan</h1>
            </div>
            <div class="container-atas-kanan">
                <div class="rating-containerr">
                    <p>
                        <?php echo $average_rating; ?>/10
                    </p>
                    <!--Rating-->
                </div>
                <button class="komentar-container" onclick="scrollToSection()">
                    <img class="komentar-logo" src="../comment.png">
                    <p>
                        <?php echo $rating_data['jumlah_ulasan']; ?>
                    </p>
                    <!--Jumlah Ulasan-->
                </button>
            </div>
        </div>
        <!--Container Tengah-->
        <div class="container-tengah">
            <div class="container-tengah-kiri">
                <div class="container-tengah-kiri-konten" style="margin-top: 60px; margin-left: 20px;">
                    <button class="button-pinjam" onclick="toggleDisplay()" style="margin-left: 20px;">
                        Pinjam
                    </button>

                    <button class="button-tambah-favorit" style="margin-right: 67px;">
                        <a href="backend/tambah-favorit.php?buku_id=<?php echo $buku_id; ?>">
                            <img src="gambar/simpan.png" style="width: 60px; height: 55px;" alt="">
                        </a>
                    </button>
                </div>

                <h2 style="margin-left: 40px;">Kategori :
                    <?php
                    $kategori_query = mysqli_query($conn, "SELECT kategori.nama_kategori FROM kategori_buku_relasi
                    JOIN kategori ON kategori.id = kategori_buku_relasi.kategori_id
                    WHERE kategori_buku_relasi.buku_id = '$buku_id'");
                    while ($kategori = mysqli_fetch_assoc($kategori_query)) {
                        echo $kategori['nama_kategori'];
                    }
                    ?>
                </h2>
            </div>


            <section class="isi-ulasan-container" id="ulasan"
                style="margin-top: 200px; width:1000px; margin-right: 30px;">
                <?php
                $ulasan_query = mysqli_query($conn, "SELECT ulasan_buku.ulasan, ulasan_buku.rating, user.username FROM ulasan_buku
JOIN user ON ulasan_buku.user_id = user.id
WHERE buku_id='$buku_id' AND (ulasan_buku.ulasan IS NOT NULL OR ulasan_buku.rating IS NOT NULL)"); // Ambil data dengan ulasan atau rating tidak null
                while ($ulasan = mysqli_fetch_assoc($ulasan_query)) {
                    echo '<div class="isi-ulasan">';
                    echo '<h5 class="ulasan-username" style="font-size:21px;">' . $ulasan['username'] . '</h5>';

                    // Tampilkan ulasan jika ada
                    if (!empty($ulasan['ulasan'])) {
                        echo '<p class="ulasan-text" style="font-size:19px; color: grey;">' . $ulasan['ulasan'] . '</p>';
                    }

                    // Tampilkan rating jika ada
                    if (!empty($ulasan['rating'])) {
                        echo '<p class="ulasan-rating" style="color:#808000;">' . $ulasan['rating'] . '/10</p>';
                    }

                    echo '</div>';
                }
                ?>

                <div class="container-tengah-kanan" style="margin-top: 60px;">
                    <h1 style="margin-left: 60px; margin-top: 40px; font-size: 25px;">Tambah Ulasan/Rating</h1>
                    <!-- Tampilkan pesan dalam bentuk alert -->
                    <?php if (!empty($pesan)): ?>
                        <script>
                            alert('<?php echo $pesan; ?>');
                        </script>
                    <?php endif; ?>


                    <form method="post">
                        <div class="rating-container" id="rating-container">
                            <div class="rating-stars">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                                <span class="star" data-value="6">&#9733;</span>
                                <span class="star" data-value="7">&#9733;</span>
                                <span class="star" data-value="8">&#9733;</span>
                                <span class="star" data-value="9">&#9733;</span>
                                <span class="star" data-value="10">&#9733;</span>
                            </div>
                        </div>
                        <input type="hidden" id="rating-input" name="rating">
                        <textarea class="ulasan" placeholder="Tambah Komentar" name="ulasan"></textarea>
                        <input type="submit" value="Kirim" class="kirim-ulasan">
                    </form>
                </div>
            </section>


        </div>

    </div>
    <script>
        // Ambil elemen-elemen yang diperlukan
        const ratingContainer = document.getElementById('rating-container');
        const ratingInput = document.getElementById('rating-input');
        const stars = ratingContainer.querySelectorAll('.star');

        // Tambahkan event listener untuk setiap bintang
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const ratingValue = parseInt(star.getAttribute('data-value'));

                // Ubah tampilan bintang sesuai rating yang diberikan
                stars.forEach((s, index) => {
                    if (index < ratingValue) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });

                // Set nilai rating pada input tersembunyi
                ratingInput.value = ratingValue;
            });
        });
    </script>


    <script>
        function scrollToSection() {
            var ulasanSection = document.getElementById("ulasan");
            ulasanSection.scrollIntoView({ behavior: "smooth" });
        }

        function toggleDisplay() {
            var div = document.querySelector(".konfirmasi-container");
            div.style.display = "block";
        }

        function hideDisplay() {
            var div = document.querySelector(".konfirmasi-container");
            div.style.display = "none";
        }

    </script>
</body>

</html>