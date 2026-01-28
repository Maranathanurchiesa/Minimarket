<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
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

$msg = "";
if(isset($_POST['submit'])){
    $nama = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];

    if(!empty($nama) && !empty($jumlah)){
        $stmt = $conn->prepare("UPDATE barang SET nama_barang = ?, jumlah = ? WHERE id = ?");
        $stmt->bind_param("sii", $nama, $jumlah, $id);
        if($stmt->execute()){
            $msg = "Barang berhasil diupdate!";
            // Refresh data
            $barang['nama_barang'] = $nama;
            $barang['jumlah'] = $jumlah;
        } else {
            $msg = "Terjadi kesalahan, coba lagi.";
        }
    } else {
        $msg = "Semua field wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang - Mini Market</title>
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

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #5c4033;
        }

        form input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form input:focus {
            outline: none;
            border-color: #d2691e;
            box-shadow: 0 0 5px rgba(210,105,30,0.5);
        }

        form button {
            width: 100%;
            padding: 15px;
            border-radius: 15px;
            border: none;
            background: linear-gradient(135deg, #d2691e, #a0522d);
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.3s, transform 0.2s;
        }

        form button:hover {
            background: linear-gradient(135deg, #8b4513, #5c2d1f);
            transform: scale(1.03);
        }

        .msg {
            text-align: center;
            margin-bottom: 20px;
            color: #a0522d;
            font-weight: 600;
        }

        @media(max-width:500px){
            .card { width: 90%; padding: 35px 25px; }
            .card h3 { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2><i class="fas fa-edit"></i> Edit Barang</h2>
        <div class="nav-links">
            <a href="detail_barang.php?id=<?= $barang['id'] ?>"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <?php if($msg != ""){ echo "<div class='msg'><i class='fas fa-info-circle'></i> $msg</div>"; } ?>
            <form method="post">
                <label for="nama_barang"><i class="fas fa-box"></i> Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" value="<?= htmlspecialchars($barang['nama_barang']) ?>">

                <label for="jumlah"><i class="fas fa-layer-group"></i> Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" value="<?= $barang['jumlah'] ?>">

                <button type="submit" name="submit"><i class="fas fa-save"></i> Update Barang</button>
            </form>
        </div>
    </div>
</body>
</html>
