<?php
$conn = mysqli_connect('localhost', 'root', '', 'asri_library');

// Menangkap data id yang dikirim dari URL
$id = $_GET['id'];

// Menghapus data terkait dari tabel kategori_buku_relasi
mysqli_query($conn, "DELETE FROM kategori_buku_relasi WHERE kategori_id='$id'");

// Menghapus data dari tabel kategori
mysqli_query($conn, "DELETE FROM kategori WHERE id='$id'");

// Mengalihkan halaman kembali ke tambah_kategori.php dengan pesan hapus
header("location: tambah-kategori.php?pesan=hapus");
?>