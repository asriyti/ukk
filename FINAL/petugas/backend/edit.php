<?php
require_once('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edit_id = $_POST['edit_id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun-terbit'];
    $kategori_id = $_POST['kategori'];
    $sinopsis = $_POST['sinopsis'];

    $gambar_nama = null;

    if ($_FILES["gambar"]["name"]) {
        $nama_file = strtolower(str_replace(' ', '_', $judul));
        $kode_unik = uniqid();
        $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $gambar_nama = $nama_file . '_' . $kode_unik . '.' . $ext;
        $gambar_tmp = $_FILES["gambar"]["tmp_name"];
        $gambar_destinasi = "C:/xampp/htdocs/admin/gambar/" . $gambar_nama;
        move_uploaded_file($gambar_tmp, $gambar_destinasi);
    } else {
        $query_get_gambar = mysqli_query($conn, "SELECT gambar FROM buku WHERE id = '$edit_id'");
        $gambar_lama = mysqli_fetch_assoc($query_get_gambar)['gambar'];
        $gambar_nama = $gambar_lama;
    }

    try {
        $stmt = $conn->prepare("UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, gambar=?, sinopsis=? WHERE id=?");
        $stmt->bind_param("ssssssi", $judul, $penulis, $penerbit, $tahun_terbit, $gambar_nama, $sinopsis, $edit_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Data berhasil diperbarui.";
            header("Location: ../pendataan-barang.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Error updating data: " . $stmt->error;
            header("Location: ../edit.php?id=" . $edit_id);
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: ../edit.php?id=" . $edit_id);
        exit;
    } finally {
        $stmt->close();
        mysqli_close($conn);
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../pendataan-barang.php");
    exit;
}
?>
