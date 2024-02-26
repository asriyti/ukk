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
    <link rel="stylesheet" type="text/css" href="css/pinjaman.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/maxtext.css">
    <link rel="stylesheet" type="text/css" href="css/active.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <title>Pinjaman</title>
    <style>
        .title {
            color: black;
            font-size: 50px;
            font-family: Inter;
            font-weight: 200;
            word-wrap: break-word;
            text-align: center;
        }

        .content-container {
            display: flex;
            flex-wrap: wrap;
            /* Memungkinkan elemen-elemen untuk turun ke bawah jika tidak cukup tempat */
            justify-content: space-between;
            width: 100%;
            margin-top: 40px;
        }

        .content {
            width: 33%;
            height: 100%;
            background-color: white;
            box-sizing: border-box;
            padding: 10px;
            margin-bottom: 10px;
            /* Menambahkan margin bottom untuk memberi jarak antar elemen */
            border-radius: 10px;
            border: 1px solid purple;
        }

        .gambar {
            width: 40%;
            margin-left: auto;
            
        }

        .id {

            color: black;
            font-size: 30px;
            font-family: Inter;
            font-weight: 700;
            word-wrap: break-word;
        }

        #id {
            display: flex;
            width: 100%;
        }

        .button {
            margin-left: auto;
            border-radius: 10px;
            border: none;
            height: 50px;
            background-color: black;
            color: white;
            margin-bottom: 20px;
        }

        .button:hover {
            height: 55px;
            background-color: black;
            color: black;
        }

        .media-content {
            width: 100%;
            display: flex;
        }

        .gambar {
            width: 40%;
            margin-left: 10px;
        }

        .gambar img {
            width: 100%;
        }

        .text {
            width: 50%;
            margin-left: 20px;
        }

        @media screen and (max-width: 600px) {
            .title {
                font-size: 30px;
            }

            .id {
                font-size: 25px;
            }

            .content-container {
                flex-direction: column;
            }

            .content {
                width: 100%;
                margin-bottom: 10px;
            }
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
    <nav class="navbar-bawah">
        <button class="home" style="background-color:rgb(126, 80, 136); margin-top: 10px;">
            <a href="home.php" style="font-size: 30px;  ">
                <img src="gambar/kembali.png" style="width: 70px;">
            </a>
        </button>
    </nav>
    <div class="content-container">
        <?php
        // Include file konfigurasi database
        include 'backend/config.php';

        // Query untuk mengambil data peminjaman dengan status "belum dikembalikan"
        $query = "SELECT
            p.id AS id_peminjaman,
            b.judul AS judul_buku,
            u.nama_lengkap AS nama_peminjam,
            p.tanggal_peminjaman,
            p.tanggal_pengembalian,
            p.status_peminjaman,
            b.gambar
        FROM
            peminjaman p
        JOIN
            buku b ON p.buku_id = b.id
        JOIN
            user u ON p.user_id = u.id
        WHERE
            p.status_peminjaman = 'belum dikembalikan'";

        $result = mysqli_query($conn, $query);

        // Loop untuk menampilkan data dalam format HTML
        while ($row = mysqli_fetch_assoc($result)) {
            // Tampilkan data dalam format HTML
            echo '<div class="content">';
            echo '    <div id="' . $row['id_peminjaman'] . '">';
            echo '        <p class="id">ID Buku :    ' . $row['id_peminjaman'] . '</p>';
            echo '      <form action="backend/pengembalian.php" method="GET">';
            echo '       <input type="hidden" name="id" value="' . $row['id_peminjaman'] . '">';
            echo '        <button type="submit" class="button" style="background-color: rgb(126, 80, 136); color: white;">Sudah Dikembalikan</button>';
            echo '          </form>';
            echo '    </div>';

            echo '    <div class="media-content">';
            echo '        <div class="gambar">';
            echo '            <img src="gambar/' . $row['gambar'] . '">';
            echo '        </div>';

            echo '        <div class="text">';
            echo '            <p class="judul">Judul Buku: ' . $row['judul_buku'] . '</p>';
            echo '            <p class="judul">Nama Peminjam: ' . $row['nama_peminjam'] . '</p>';
            echo '            <p class="judul">Tanggal Dipinjam: ' . $row['tanggal_peminjaman'] . '</p>';
            echo '            <p class="judul">Batas Waktu: ' . $row['tanggal_pengembalian'] . '</p>';
            echo '            <p class="judul">Status: ' . $row['status_peminjaman'] . '</p>';
            echo '        </div>';

            echo '    </div>';
            echo '</div>';
        }

        // Tutup koneksi database
        mysqli_close($conn);
        ?>





    </div>
    </div>
    <script>document.addEventListener('DOMContentLoaded', function () {
            var elements = document.querySelectorAll('.judul');

            elements.forEach(function (element) {
                var originalText = element.textContent;

                if (originalText.length > 35) {
                    var shortenedText = originalText.substring(0, 35) + '...';
                    element.textContent = shortenedText;
                }
            });
        });
    </script>

    <script>
        // Periksa apakah ada pesan dalam parameter query
        <?php if (isset($_GET['message'])): ?>
            // Tampilkan pesan menggunakan alert
            alert("<?php echo $_GET['message']; ?>");
        <?php endif; ?>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>