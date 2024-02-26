<?php
// Include file konfigurasi database
include 'config.php';

// Variabel untuk menyimpan pesan
$message = "";

// Periksa apakah parameter id diterima dari URL
if(isset($_GET['id'])) {
    // Ambil nilai id dari URL
    $id_peminjaman = $_GET['id'];

    // Query untuk memperbarui status peminjaman menjadi "sudah dikembalikan"
    $update_query = "UPDATE peminjaman SET status_peminjaman = 'sudah dikembalikan' WHERE id = $id_peminjaman";

    // Eksekusi query untuk memperbarui status peminjaman
    if(mysqli_query($conn, $update_query)) {
        // Jika query berhasil dieksekusi, atur pesan berhasil
        $message = "Status peminjaman berhasil diperbarui!";
    } else {
        // Jika terjadi kesalahan saat menjalankan query, atur pesan error
        $message = "Terjadi kesalahan saat memperbarui status peminjaman: " . mysqli_error($conn);
    }
}

// Tutup koneksi database
mysqli_close($conn);

// Redirect kembali ke halaman daftar_pinjaman.php dengan menyertakan pesan dalam parameter query
header("Location: ../daftar-pinjaman.php?message=" . urlencode($message));
exit();
?>
