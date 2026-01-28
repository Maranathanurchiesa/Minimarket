<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Mini Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f5f0, #e6e2d3);
        }

        /* HEADER */
        .header {
            background: #a0522d;
            color: #fff;
            padding: 25px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            font-family: 'Playfair Display', serif;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header h2 { font-size: 32px; }

        .nav-links span {
            font-weight: 500;
            margin-right: 15px;
            font-size: 16px;
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

        /* CONTAINER */
        .container {
            padding: 60px 50px;
        }

        .welcome {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 50px;
            color: #5c4033;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 50px;
        }

        /* CARD */
        .card {
            background: #fff;
            border-radius: 25px;
            padding: 45px 35px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            transition: transform 0.4s, box-shadow 0.4s, background 0.4s;
            position: relative;
            overflow: hidden;
        }

        /* overlay ringan tapi tidak menutupi tombol */
        .card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(210,105,30,0.05);
            transform: rotate(25deg);
            pointer-events: none; /* penting agar tombol bisa diklik */
        }

        .card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            background: #fff8f0;
        }

        /* ICON CARD */
        .card-icon {
            font-size: 50px;
            color: #d2691e;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        /* JUDUL CARD */
        .card h3 {
            font-family: 'Playfair Display', serif;
            color: #8b4513;
            margin-bottom: 30px;
            font-size: 26px;
            text-align: center; /* teks di tengah di bawah ikon */
        }

        /* TOMBOL DALAM CARD */
        .dashboard-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .dashboard-buttons a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg, #d2691e, #a0522d);
            color: #fff;
            padding: 40px 0;
            border-radius: 18px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: background 0.4s, transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-buttons a i {
            font-size: 36px;
        }

        .dashboard-buttons a:hover {
            background: linear-gradient(135deg, #8b4513, #5c2d1f);
            transform: scale(1.08);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        /* RESPONSIVE */
        @media(max-width:768px){
            .container { padding: 40px 20px; }
            .card h3 { font-size: 22px; }
            .dashboard-buttons {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .dashboard-buttons a { font-size: 16px; padding: 30px 0; }
            .dashboard-buttons a i { font-size: 32px; }
        }

    </style>
</head>
<body>
    <div class="header">
        <h2>Mini Market Dashboard</h2>
        <div class="nav-links">
            <span><?php echo $user['nama']; ?> (<?php echo $user['role']; ?>)</span>
            <a href="logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <i class="fas fa-store"></i> Selamat datang di sistem Mini Market! Gunakan menu di bawah untuk mengelola data barang dan karyawan.
        </div>

        <div class="grid">
            <!-- CARD BARANG -->
            <div class="card">
                <div class="card-icon"><i class="fas fa-box"></i></div>
                <h3>Manajemen Barang</h3>
                <div class="dashboard-buttons">
                    <a href="barang.php"><i class="fas fa-list"></i> Daftar Barang</a>
                    <a href="tambah_barang.php"><i class="fas fa-plus"></i> Tambah Barang</a>
                </div>
            </div>

            <!-- CARD KARYAWAN -->
            <div class="card">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <h3>Manajemen Karyawan</h3>
                <div class="dashboard-buttons">
                    <a href="karyawan.php"><i class="fas fa-list"></i> Daftar Karyawan</a>
                    <?php if($user['role'] === 'ADMIN'){ ?>
                    <a href="tambah_karyawan.php"><i class="fas fa-user-plus"></i> Tambah Karyawan</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
