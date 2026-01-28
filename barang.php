<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
require 'database.php';
$user = $_SESSION['user'];

// Ambil data barang
$result = $conn->query("SELECT * FROM barang ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang - Mini Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f0;
            min-height: 100vh;
        }

        .header {
            background: #a0522d; /* coklat hangat */
            color: #fff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            font-family: 'Playfair Display', serif;
        }

        .header h2 { font-size: 28px; }
        .nav-links span { font-weight: 500; margin-right: 15px; font-size: 15px; }
        .nav-links a {
            color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 8px;
            font-weight: 500; transition: background 0.3s, transform 0.2s;
        }
        .nav-links a:hover { background: #8b4513; transform: scale(1.05); }

        .container { padding: 40px; }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #d2691e;
            color: #fff;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-add i { font-size: 18px; }
        .btn-add:hover { background: #8b4513; transform: scale(1.05); }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        table th, table td {
            padding: 15px 20px;
            text-align: left;
        }

        table th {
            background: #d2691e;
            color: #fff;
            font-family: 'Playfair Display', serif;
        }

        table tr:nth-child(even) { background: #f8f8f5; }

        table tr:hover { background: #ffe8d6; }

        .action-buttons a {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #a0522d;
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s, transform 0.2s;
        }

        .action-buttons a:hover { background: #8b4513; transform: scale(1.05); }

        @media(max-width:768px){
            .container { padding: 20px; }
            table th, table td { padding: 12px 10px; font-size: 14px; }
            .btn-add { padding: 10px 16px; font-size: 14px; }
            .action-buttons a { padding: 5px 10px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Daftar Barang</h2>
        <div class="nav-links">
            <span><?php echo $user['nama']; ?> (<?php echo $user['role']; ?>)</span>
            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <div class="container">
        <a href="tambah_barang.php" class="btn-add"><i class="fas fa-plus"></i> Tambah Barang</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
            <?php while($row = $result->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td><?php echo $row['jumlah']; ?></td>
                <td class="action-buttons">
                    <a href="detail_barang.php?id=<?php echo $row['id']; ?>"><i class="fas fa-eye"></i> Detail</a>
                    <a href="edit_barang.php?id=<?php echo $row['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                    <a href="hapus_barang.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
