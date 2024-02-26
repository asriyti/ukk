<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'asri_library');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}
// Tangkap data yang dikirim dari form
$id = $_POST['id'];
$nama_kategori = $_POST['nama_kategori'];

// Update data ke database
$query = "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    // Redirect kembali ke halaman kategori.php jika update berhasil
    header("location: tambah-kategori.php?pesan=update");
} else {
    // Tampilkan pesan kesalahan jika terjadi masalah dalam eksekusi query
    echo "Error updating record: " . mysqli_error($conn);
}

// Tutup koneksi database
mysqli_close($conn);

?>