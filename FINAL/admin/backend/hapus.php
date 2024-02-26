<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'asri_library');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus relasi di tabel kategori_buku_relasi
    $query_delete_relasi = "DELETE FROM kategori_buku_relasi WHERE buku_id = '$id'";
    mysqli_query($conn, $query_delete_relasi);

    // Hapus relasi di tabel ulasan_buku
    $query_delete_relasi = "DELETE FROM ulasan_buku WHERE buku_id = '$id'";
    mysqli_query($conn, $query_delete_relasi);

    // Hapus data buku
    $query_delete_buku = "DELETE FROM buku WHERE id = '$id'";
    if (mysqli_query($conn, $query_delete_buku)) {
        // Redirect ke halaman pendataan setelah berhasil dihapus
        header("Location: ../pendataan-barang.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid ID";
}

mysqli_close($conn);
?>