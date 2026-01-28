<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}
$user = $_SESSION['user'];
include "database.php";

// Ambil semua karyawan dari database
$sql = "SELECT * FROM karyawan ORDER BY id ASC";
$result = $conn->query($sql);
$karyawan_list = [];
if($result){
    while($row = $result->fetch_assoc()){
        $karyawan_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Karyawan - Mini Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f5f0, #e6e2d3);
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
            gap: 10px;
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
            padding: 50px;
        }
        .welcome {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 30px;
            color: #5c4033;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff8f0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background: #d2691e;
            color: #fff;
            font-weight: 600;
            font-family: 'Playfair Display', serif;
        }
        table tr:hover {
            background: #fff0e0;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 500;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-detail { background: #34d399; }
        .btn-detail:hover { background: #059669; transform: scale(1.05); }
        .btn-add { background: #d2691e; margin-right: 10px; }
        .btn-add:hover { background: #8b4513; transform: scale(1.05); }
        @media(max-width:768px){
            .container { padding: 30px 15px; }
            table th, table td { padding: 12px; font-size: 14px; }
            .btn { font-size: 14px; padding: 6px 12px; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2><i class="fas fa-users"></i> Daftar Karyawan</h2>
        <div class="nav-links">
            <?php if(isset($user['role']) && $user['role'] === 'ADMIN'): ?>
                <a href="tambah_karyawan.php" class="btn btn-add"><i class="fas fa-user-plus"></i> Tambah Karyawan</a>
            <?php endif; ?>
            <a href="dashboard.php" class="btn"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <i class="fas fa-address-book"></i> Berikut daftar karyawan yang terdaftar di sistem.
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($karyawan_list) > 0): ?>
                    <?php foreach($karyawan_list as $karyawan): ?>
                        <tr>
                            <td><?= htmlspecialchars($karyawan['id']) ?></td>
                            <td><?= htmlspecialchars($karyawan['nama']) ?></td>
                            <td><?= htmlspecialchars($karyawan['no_telp'] ?: '-') ?></td>
                            <td><?= htmlspecialchars($karyawan['alamat'] ?: '-') ?></td>
                            <td><?= htmlspecialchars($karyawan['role']) ?></td>
                            <td>
                                <a href="detail_karyawan.php?id=<?= $karyawan['id'] ?>" class="btn btn-detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center; padding:20px;">Belum ada karyawan terdaftar.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
