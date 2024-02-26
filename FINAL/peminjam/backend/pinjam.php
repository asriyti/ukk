<?php
require_once("config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../masuk.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$buku_id = $_GET['buku_id'];
$pengembalian = $_POST['pengembalian'];
$status = "belum dikembalikan";

// Cek apakah buku sudah dipinjam dan belum dikembalikan
$cek_peminjaman_query = mysqli_query($conn, "SELECT * FROM peminjaman WHERE user_id='$user_id' AND buku_id='$buku_id' AND status_peminjaman='belum dikembalikan'");

if (mysqli_num_rows($cek_peminjaman_query) > 0) {
    // Buku sudah dipinjam dan belum dikembalikan
    $pesan = "Maaf, buku ini sudah Anda pinjam dan belum dikembalikan. Anda tidak dapat melakukan peminjaman lagi.";
    $_SESSION['pesan'] = $pesan;
    header("Location: ../detail-buku.php?id=$buku_id");
    exit();
}

// Jika belum dipinjam, lakukan proses peminjaman
$tanggal_peminjaman = date("Y-m-d");

$insert_query = "INSERT INTO peminjaman (user_id, buku_id, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman) VALUES ('$user_id', '$buku_id', '$tanggal_peminjaman', '$pengembalian', '$status')";

if (mysqli_query($conn, $insert_query)) {
    // Peminjaman berhasil
    $pesan = "Buku berhasil dipinjam. Terima kasih!";
    $_SESSION['pesan'] = $pesan;
    header("Location: ../detail-buku.php?id=$buku_id");
} else {
    // Peminjaman gagal
    $pesan = "Gagal melakukan peminjaman. Silakan coba lagi.";
    $_SESSION['pesan'] = $pesan;
    header("Location: ../detail-buku.php?id=$buku_id");
}

exit();
?>
