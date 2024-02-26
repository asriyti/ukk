<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

// Menghubungkan ke database menggunakan MySQLi
$conn = mysqli_connect('localhost', 'root', '', 'asri_library');

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data
$queryTotalPeminjaman = "SELECT COUNT(*) AS total_peminjaman FROM peminjaman";
$queryPalingBanyakMeminjam = "SELECT u.nama_lengkap, COUNT(*) AS jumlah_peminjaman FROM peminjaman p
                            JOIN user u ON p.user_id = u.id
                            GROUP BY p.user_id
                            ORDER BY jumlah_peminjaman DESC
                            LIMIT 1";
$queryBukuPalingBanyakDipinjam = "SELECT b.judul, COUNT(*) AS jumlah_peminjaman FROM peminjaman p
                                JOIN buku b ON p.buku_id = b.id
                                GROUP BY p.buku_id
                                ORDER BY jumlah_peminjaman DESC
                                LIMIT 1";
$queryJumlahBuku = "SELECT COUNT(*) AS jumlah_buku FROM buku";
$queryJumlahKategori = "SELECT COUNT(*) AS jumlah_kategori FROM kategori";
$queryJumlahPengguna = "SELECT COUNT(*) AS jumlah_pengguna FROM user";
$queryDaftarBuku = "SELECT 
                        b.id, 
                        b.judul, 
                        b.penulis, 
                        b.tahun_terbit, 
                        b.penerbit, 
                        K.nama_kategori, 
                        COUNT(p.id) AS jumlah_dipinjam
                    FROM 
                        buku b
                    LEFT JOIN 
                        kategori_buku_relasi kb ON b.id = kb.buku_id
                    LEFT JOIN 
                        Kategori K ON kb.kategori_id = K.id
                    LEFT JOIN 
                        peminjaman p ON b.id = p.buku_id
                    GROUP BY 
                        b.id";

$queryDaftarPengguna = "SELECT * FROM user";

// Eksekusi query
$resultTotalPeminjaman = mysqli_query($conn, $queryTotalPeminjaman);
$resultPalingBanyakMeminjam = mysqli_query($conn, $queryPalingBanyakMeminjam);
$resultBukuPalingBanyakDipinjam = mysqli_query($conn, $queryBukuPalingBanyakDipinjam);
$resultJumlahBuku = mysqli_query($conn, $queryJumlahBuku);
$resultJumlahKategori = mysqli_query($conn, $queryJumlahKategori);
$resultJumlahPengguna = mysqli_query($conn, $queryJumlahPengguna);
$resultDaftarBuku = mysqli_query($conn, $queryDaftarBuku);
$resultDaftarPengguna = mysqli_query($conn, $queryDaftarPengguna);

// Fetch hasil query
$totalPeminjaman = mysqli_fetch_assoc($resultTotalPeminjaman);
$palingBanyakMeminjam = mysqli_fetch_assoc($resultPalingBanyakMeminjam);
$bukuPalingBanyakDipinjam = mysqli_fetch_assoc($resultBukuPalingBanyakDipinjam);
$jumlahBuku = mysqli_fetch_assoc($resultJumlahBuku);
$jumlahKategori = mysqli_fetch_assoc($resultJumlahKategori);
$jumlahPengguna = mysqli_fetch_assoc($resultJumlahPengguna);
$daftarBuku = mysqli_fetch_all($resultDaftarBuku, MYSQLI_ASSOC);
$daftarPengguna = mysqli_fetch_all($resultDaftarPengguna, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/laporan.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/active.css">
    <title>Laporan</title>
    <style>
        /* Gaya tabel yang berbeda */
        .table-1 {
            background-color: #e6ccff;
            /* Warna merah yang lebih lembut */
        }

        .table-2 {
            background-color: #e6ccff;
            /* Warna hijau yang lebih lembut */
        }

        .table-3 {
            background-color: rgb(254, 235, 254);
            /* Warna biru yang lebih lembut */
        }

        .table-4 {
            background-color: #e6ccff;
            /* Warna ungu yang lebih lembut */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            /* Garis bawah setiap baris */
        }

        th {
            background-color: rgb(126, 80, 136);
            /* Warna latar belakang untuk sel header */
        }

        .container {
            width: 96%;
            margin: 0 auto;
            /* Pusatkan konten di tengah */
            padding: 20px;
            /* Berikan sedikit ruang di sekitar konten */
            background-color: #fff;
            /* Latar belakang konten */
            border-radius: 10px;
            /* Sudut elemen yang lebih halus */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Efek bayangan yang halus */
        }
    </style>

</head>

<body style="background-color: rgb(254, 235, 254);">

    <nav class="navbar-atas">
        <div class="logo">
            <img src="gambar/logo.png ">
            <p>Asri Library</p>
        </div>
    </nav>
    <nav class="navbar-bawah">
        <button class="home" style="background-color:rgb(126, 80, 136); margin-top: 10px;">
            <a href="home.php" class="btn" style="font-size: 30px;  ">
                <img src="gambar/kembali.png" style="width: 70px;">
            </a>
        </button>
    </nav>

    <div class="container">
        <div class="cetak-laporan"><button onclick="window.print()"
                style="width: 150px; height: 60px; font-size: 20px; background-color:grey; color: white;">Cetak
                Laporan</button></div>
        <h1 style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Data Peminjaman Asri
            Library</h1>

        <table border="1" class="table-1">
            <thead>
                <tr style="color: white;">
                    <th>Total Dipinjam</th>
                    <th>Paling Banyak Meminjam</th>
                    <th>Buku Paling Banyak Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $totalPeminjaman['total_peminjaman']; ?> Kali Dipinjam
                    </td>
                    <td>
                        <?php echo $palingBanyakMeminjam['nama_lengkap'] . " (" . $palingBanyakMeminjam['jumlah_peminjaman'] . "x)"; ?>
                    </td>
                    <td>
                        <?php echo $bukuPalingBanyakDipinjam['judul'] . " (" . $bukuPalingBanyakDipinjam['jumlah_peminjaman'] . "x)"; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <table border="1" class="table-2">
            <thead>
                <tr style="color: white;">
                    <th>Jumlah Buku</th>
                    <th>Jumlah Kategori</th>
                    <th>Jumlah Pengguna</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $jumlahBuku['jumlah_buku']; ?> Buku
                    </td>
                    <td>
                        <?php echo $jumlahKategori['jumlah_kategori']; ?> Kategori
                    </td>
                    <td>
                        <?php echo $jumlahPengguna['jumlah_pengguna']; ?> Pengguna
                    </td>
                </tr>
            </tbody>
        </table>

        <h1 style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Daftar Buku</h1>
        <table border="1" class="table-3">
            <thead>
                <tr style="color:white">
                    <th>Id</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Penerbit</th>
                    <th>Kategori</th>
                    <th>Jumlah dipinjam</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daftarBuku as $buku): ?>
                    <tr>
                        <td>
                            <?php echo $buku['id']; ?>
                        </td>
                        <td>
                            <?php echo $buku['judul']; ?>
                        </td>
                        <td>
                            <?php echo $buku['penulis']; ?>
                        </td>
                        <td>
                            <?php echo $buku['tahun_terbit']; ?>
                        </td>
                        <td>
                            <?php echo $buku['penerbit']; ?>
                        </td>
                        <td>
                            <?php echo $buku['nama_kategori']; ?>
                        </td>
                        <td>
                            <?php echo $buku['jumlah_dipinjam']; ?> (X)
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h1 style=" font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Daftar Pengguna</h1>
        <table border="1" class="table-4">
            <thead>
                <tr style="color: white;">
                    <th>Id</th>
                    <th>Nama Lengkap</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Kata Sandi</th>
                    <th>Hak Akses</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daftarPengguna as $pengguna): ?>
                    <tr>
                        <td>
                            <?php echo $pengguna['id']; ?>
                        </td>
                        <td>
                            <?php echo $pengguna['nama_lengkap']; ?>
                        </td>
                        <td>
                            <?php echo $pengguna['username']; ?>
                        </td>
                        <td>
                            <?php echo $pengguna['email']; ?>
                        </td>
                        <td>
                            <?php echo $pengguna['alamat']; ?>
                        </td>
                        <td>
                            <?php echo $pengguna['password']; ?>
                        </td>
                        <td>
                            <?php echo $pengguna['role']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



    <script src="js/maxtext.js"></script>
</body>

</html>