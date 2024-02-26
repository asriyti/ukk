<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'petugas') {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/tambah-barang.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/maxtext.css">
    <link rel="stylesheet" type="text/css" href="css/active.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Edit Barang</title>
    <style>
        .gambar-saat-ini {
            max-width: 100%;
            height: auto;
            max-height: 200px;
            /* Atur tinggi maksimum sesuai kebutuhan */
            margin-top: 10px;
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
                    <a href="../index.php" class="btn text-light">Logout</a>
                </div>
            </div>
        </div>
        <div class="form-container">
            <?php
            require_once('backend/config.php');

            if (isset($_SESSION['error_message'])) {
                echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
                unset($_SESSION['error_message']);
            }
            ?>

            <?php
            // Mendapatkan ID barang yang akan diedit
            $edit_id = $_GET['id'];

            // Query untuk mendapatkan data barang berdasarkan ID
            $query_get_barang = mysqli_query($conn, "SELECT * FROM buku WHERE id = '$edit_id'");
            $data_barang = mysqli_fetch_assoc($query_get_barang);
            ?>

            <form method="post" action="backend/edit.php" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">

                <div class="form">
                    <input type="text" name="judul" placeholder="Masukkan Judul" class="form-control" required
                        value="<?php echo $data_barang['judul']; ?>">
                </div>
                <div class="form">
                    <input type="text" name="penulis" placeholder="Masukkan Nama Penulis" class="form-control" required
                        value="<?php echo $data_barang['penulis']; ?>">
                </div>
                <div class="form">
                    <input type="text" name="penerbit" placeholder="Masukkan Nama Penerbit" class="form-control"
                        required value="<?php echo $data_barang['penerbit']; ?>">
                </div>
                <div class="form">
                    <input type="date" name="tahun-terbit" placeholder="Masukkan Tahun Terbit" class="form-control"
                        required value="<?php echo $data_barang['tahun_terbit']; ?>">
                </div>
                <div class="form">
                    <!-- Ambil data kategori dari tabel kategori -->
                    <?php
                    $query_kategori = mysqli_query($conn, "SELECT * FROM kategori");
                    ?>
                    <select class="form-control" name="kategori" required>
                        <option disabled>Pilih Kategori</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($query_kategori)) {
                            $selected = ($row['id'] == $data_barang['kategori_id']) ? 'selected' : '';
                            echo "<option value='{$row['id']}' {$selected}>{$row['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form">
                    <textarea required class="form-control" name="sinopsis" rows="4" cols="50"
                        placeholder="Masukkan Sinopsis"><?php echo $data_barang['sinopsis']; ?></textarea>
                </div>

                <div class="form">
                    <label>Gambar Buku Saat Ini:</label><br>
                    <img src="<?php echo "gambar/" . $data_barang['gambar']; ?>" alt="Gambar Buku"
                        class="gambar-saat-ini">
                </div>

                <div class="form">
                    <label>Pilih Gambar Buku Baru:</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <div class="form">
                    <label>Biarkan kosong jika tidak ingin mengganti gambar.</label>
                </div>

                <input type="submit" value="Simpan Perubahan" class="form-control btn-sm mt-3"
                    style="background-color:rgb(175, 131, 185) ;">
            </form>
        </div>
        <script src="js/maxtext.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
</body>

</html>