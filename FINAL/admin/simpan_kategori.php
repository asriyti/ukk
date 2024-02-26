<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'asri_library');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memproses data yang dikirim dari formulir
    if (isset($_POST['nama_kategori'])) {
        $kategori = $_POST['nama_kategori'];

        // Menyimpan data kategori ke database
        $check_query = mysqli_query($conn, "SELECT * FROM kategori WHERE nama_kategori='$kategori'");

        // Memeriksa apakah kategori sudah ada sebelumnya
        if (mysqli_num_rows($check_query) > 0) {
            header("location: tambah-kategori.php?pesan=duplikat");
            exit();
        } else {
            $insert_query = "INSERT INTO kategori (nama_kategori) VALUES ('$kategori')";
            if (mysqli_query($conn, $insert_query)) {
                header("location: tambah-kategori.php?pesan=tambah");
                exit();
            } else {
                echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
            }
        }
    } else {
        echo "Nama kategori tidak ditemukan dalam data yang dikirim.";
    }
}

mysqli_close($conn);
?>