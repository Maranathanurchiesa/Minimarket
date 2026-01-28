<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
include "database.php";


// Cek apakah ada id barang
if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // Hapus barang dari database
    $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        // Redirect kembali ke daftar barang dengan pesan sukses
        header("Location: barang.php?msg=Barang berhasil dihapus");
        exit;
    } else {
        // Jika gagal
        header("Location: barang.php?msg=Gagal menghapus barang");
        exit;
    }
} else {
    header("Location: barang.php");
    exit;
}
?>
