<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
$user = $_SESSION['user'];
include "database.php";

// Ambil ID barang dari URL
if(!isset($_GET['id'])){
    header("Location: barang.php");
    exit;
}
$id = $_GET['id'];

// Ambil data barang
$stmt = $conn->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$barang = $result->fetch_assoc();

if(!$barang){
    echo "Barang tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Barang - Mini Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(145deg, #f5f5f0, #e6e2d3);
            min-height: 100vh;
        }

        .header {
            background: #a0522d;
            color: #fff;
            padding: 25px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Playfair Display', serif;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .header h2 {
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s, transform 0.2s;
        }

        .nav-links a:hover {
            background: #8b4513;
            transform: scale(1.05);
        }

        .container {
            padding: 60px 20px;
            display: flex;
            justify-content: center;
        }

        .card {
            background: #fff;
            border-radius: 25px;
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(210,105,30,0.05);
            transform: rotate(25deg);
            pointer-events: none;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            background: #fff8f0;
        }

        .card h3 {
            font-family: 'Playfair Display', serif;
            color: #8b4513;
            font-size: 26px;
            margin-bottom: 35px;
            text-align: center;
        }

        .card h3 i {
            color: #d2691e;
        }

        .details {
            font-size: 18px;
            color: #5c4033;
            margin-bottom: 25px;
        }

        .details i {
            color: #d2691e;
            margin-right: 10px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
        }

        .buttons a {
            flex: 1;
            text-align: center;
            padding: 14px 0;
            border-radius: 12px;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.3s, transform 0.2s, box-shadow 0.2s;
        }

        .buttons a.edit {
            background: linear-gradient(135deg, #d2691e, #a0522d);
        }

        .buttons a.edit:hover {
            background: linear-gradient(135deg, #8b4513, #5c2d1f);
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .buttons a.delete {
            background: #b91c1c;
        }

        .buttons a.delete:hover {
            background: #7f1d1d;
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        @media(max-width:500px){
            .card { padding: 35px 25px; }
            .card h3 { font-size: 22px; }
            .details { font-size: 16px; }
            .buttons a { font-size: 14px; padding: 12px 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2><i class="fas fa-box"></i> Detail Barang</h2>
        <div class="nav-links">
            <a href="barang.php"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h3><i class="fas fa-box-open"></i> <?= htmlspecialchars($barang['nama_barang']) ?></h3>

            <div class="details"><i class="fas fa-hashtag"></i> ID Barang: <?= $barang['id'] ?></div>
            <div class="details"><i class="fas fa-boxes"></i> Jumlah: <?= $barang['jumlah'] ?></div>

            <div class="buttons">
                <a class="edit" href="edit_barang.php?id=<?= $barang['id'] ?>"><i class="fas fa-edit"></i> Edit</a>
                <a class="delete" href="hapus_barang.php?id=<?= $barang['id'] ?>" onclick="return confirm('Apakah yakin ingin menghapus barang ini?');"><i class="fas fa-trash-alt"></i> Hapus</a>
            </div>
        </div>
    </div>
</body>
</html>
