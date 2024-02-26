<?php
require_once("config.php");
session_start();
$user_id = $_SESSION["user_id"];
$buku_id = $_GET['buku_id'];

$cek = mysqli_query($conn, "SELECT * FROM koleksi WHERE user_id='$user_id' AND buku_id='$buku_id'");
if (mysqli_num_rows($cek) >= 1) {
    $pesan = "Buku ini telah ada dalam koleksi Anda.";
    $_SESSION['pesan'] = $pesan;
} else {
    $insert_query = mysqli_query($conn, "INSERT INTO koleksi (user_id, buku_id) VALUES ('$user_id', '$buku_id')");
    if ($insert_query) {
        $pesan = "Buku berhasil ditambahkan ke koleksi Anda.";
        $_SESSION['pesan'] = $pesan;
    } else {
        $pesan = "Gagal menambahkan buku ke koleksi.";
        $_SESSION['pesan'] = $pesan;
    }
}

header("Location: ../detail-buku.php?id=$buku_id");
exit();
?>
