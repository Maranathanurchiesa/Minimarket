<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}

include "database.php";

// Cek apakah user admin
if($_SESSION['user']['role'] !== 'ADMIN'){
    header("Location: karyawan.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: karyawan.php");
    exit;
}

$id = intval($_GET['id']);

// Jangan hapus admin utama (opsional)
$stmt_check = $conn->prepare("SELECT * FROM karyawan WHERE id=?");
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$karyawan = $result_check->fetch_assoc();
if(!$karyawan){
    header("Location: karyawan.php");
    exit;
}

// Eksekusi hapus
$stmt = $conn->prepare("DELETE FROM karyawan WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: karyawan.php?msg=Karyawan berhasil dihapus");
    exit;
}else{
    header("Location: karyawan.php?msg=Terjadi kesalahan saat menghapus");
    exit;
}
?>
