<?php
require_once('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../masuk.html");
    exit();
}

$user_id = $_SESSION["user_id"];

// Periksa apakah parameter id tersedia di URL
if (isset($_GET['id'])) {
    $buku_id_to_remove = $_GET['id'];

    // Gunakan prepared statement untuk mencegah SQL injection
    $delete_query = mysqli_prepare($conn, "DELETE FROM koleksi WHERE user_id = ? AND buku_id = ?");
    mysqli_stmt_bind_param($delete_query, "ii", $user_id, $buku_id_to_remove);

    if (mysqli_stmt_execute($delete_query)) {
        // Hapus berhasil
        $pesan = "Buku berhasil dihapus dari koleksi.";
        $_SESSION['pesan'] = $pesan;
    } else {
        // Gagal menghapus
        $pesan = "Gagal menghapus buku dari koleksi. Silakan coba lagi.";
        $_SESSION['pesan'] = $pesan;
    }

    // Tutup prepared statement
    mysqli_stmt_close($delete_query);
} else {
    // Parameter id tidak tersedia
    $pesan = "ID buku tidak valid.";
    $_SESSION['pesan'] = $pesan;
}

// Redirect kembali ke halaman koleksi
header("Location: ../koleksi.php");
exit();
?>