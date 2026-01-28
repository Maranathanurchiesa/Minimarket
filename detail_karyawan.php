<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}
$user = $_SESSION['user'];
include "database.php";

if(!isset($_GET['id'])){
    header("Location: karyawan.php");
    exit;
}

$id = $_GET['id'];

// Ambil data karyawan
$stmt = $conn->prepare("SELECT * FROM karyawan WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$karyawan = $result->fetch_assoc();
if(!$karyawan){
    header("Location: karyawan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Karyawan - Mini Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f5f0, #e6e2d3);
        }

        .header {
            background: #a0522d;
            color: #fff;
            padding: 25px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Playfair Display', serif;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .header h2 {
            font-size: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s, transform 0.2s;
        }

        .header a:hover {
            background: #8b4513;
            transform: scale(1.05);
        }

        .container {
            padding: 60px 50px;
            display: flex;
            justify-content: center;
        }

        .card {
            background: #fff;
            border-radius: 25px;
            padding: 50px 40px;
            width: 700px;
            max-width: 95%;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -40%;
            left: -40%;
            width: 180%;
            height: 180%;
            background: rgba(210,105,30,0.05);
            transform: rotate(25deg);
            z-index: 0;
        }

        .card-content {
            position: relative;
            z-index: 1;
        }

        .card h3 {
            font-family: 'Playfair Display', serif;
            color: #8b4513;
            font-size: 28px;
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 30px;
        }

        .info div {
            display: flex;
            flex-direction: column;
        }

        .info label {
            font-weight: 600;
            color: #5c4033;
            margin-bottom: 8px;
        }

        .info span {
            padding: 12px 15px;
            background: #f5f0e1;
            border-radius: 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4d2e1e;
        }

        .full-width { grid-column: 1 / 3; }

        .buttons {
            margin-top: 35px;
            display: flex;
            gap: 20px;
        }

        .buttons a {
            padding: 15px 25px;
            background: linear-gradient(135deg, #d2691e, #a0522d);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s, transform 0.2s;
        }

        .buttons a:hover {
            background: linear-gradient(135deg, #8b4513, #5c2d1f);
            transform: scale(1.05);
        }

        @media(max-width:768px){
            .container { padding: 40px 20px; }
            .info { grid-template-columns: 1fr; }
            .full-width { grid-column: 1; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2><i class="fas fa-user"></i> Detail Karyawan</h2>
        <a href="karyawan.php"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-content">
                <h3><i class="fas fa-id-badge"></i> Informasi Karyawan</h3>
                <div class="info">
                    <div>
                        <label><i class="fas fa-user"></i> Nama</label>
                        <span><?php echo htmlspecialchars($karyawan['nama']); ?></span>
                    </div>
                    <div>
                        <label><i class="fas fa-user-tag"></i> Role</label>
                        <span><?php echo $karyawan['role']; ?></span>
                    </div>
                    <div>
                        <label><i class="fas fa-phone"></i> No. Telepon</label>
                        <span><?php echo htmlspecialchars($karyawan['no_telp']); ?></span>
                    </div>
                    <div class="full-width">
                        <label><i class="fas fa-map-marker-alt"></i> Alamat</label>
                        <span><?php echo htmlspecialchars($karyawan['alamat']); ?></span>
                    </div>
                </div>

                <div class="buttons">
                    <a href="edit_karyawan.php?id=<?php echo $karyawan['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                    <a href="hapus_karyawan.php?id=<?php echo $karyawan['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');"><i class="fas fa-trash-alt"></i> Hapus</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
