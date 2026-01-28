<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'ADMIN'){
    header("Location: index.php");
    exit;
}
$user = $_SESSION['user'];
include "database.php";

$msg = "";
if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $role = $_POST['role'];

    if(!empty($nama) && !empty($password) && !empty($role)){
        $hashed = md5($password);
        $stmt = $conn->prepare("INSERT INTO karyawan (nama, password, no_telp, alamat, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $hashed, $no_telp, $alamat, $role);
        if($stmt->execute()){
            // Redirect otomatis ke daftar karyawan
            header("Location: karyawan.php");
            exit;
        } else {
            $msg = "Terjadi kesalahan, coba lagi.";
        }
    } else {
        $msg = "Nama, Password, dan Role wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karyawan - Mini Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #f5f5f0, #e6e2d3);
            min-height: 100vh;
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

        /* PENTING: beri z-index agar input bisa diklik */
        .card::before {
            content: '';
            position: absolute;
            top: -40%;
            left: -40%;
            width: 180%;
            height: 180%;
            background: rgba(210,105,30,0.05);
            transform: rotate(25deg);
            z-index: 0; /* <- input tidak akan tertutup */
        }

        .card-content {
            position: relative;
            z-index: 1; /* form di atas dekorasi */
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

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 30px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #5c4033;
            font-size: 15px;
        }

        form input, form select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form input:focus, form select:focus {
            outline: none;
            border-color: #d2691e;
            box-shadow: 0 0 5px rgba(210,105,30,0.5);
        }

        .full-width {
            grid-column: 1 / 3;
        }

        form button {
            grid-column: 1 / 3;
            width: 100%;
            padding: 18px;
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
            gap: 12px;
            transition: background 0.3s, transform 0.2s;
        }

        form button:hover {
            background: linear-gradient(135deg, #8b4513, #5c2d1f);
            transform: scale(1.03);
        }

        .msg {
            text-align: center;
            margin-bottom: 25px;
            color: #a0522d;
            font-weight: 600;
            font-size: 16px;
        }

        @media(max-width:768px){
            .container { padding: 40px 20px; }
            form { grid-template-columns: 1fr; }
            .full-width { grid-column: 1; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2><i class="fas fa-user-plus"></i> Tambah Karyawan</h2>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-content">
                <?php if($msg != ""){ echo "<div class='msg'><i class='fas fa-info-circle'></i> $msg</div>"; } ?>
                <form method="post">
                    <div>
                        <label for="nama"><i class="fas fa-user"></i> Nama</label>
                        <input type="text" name="nama" id="nama" placeholder="Masukkan nama karyawan">
                    </div>

                    <div>
                        <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                        <select name="role" id="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="ADMIN">ADMIN</option>
                            <option value="KARYAWAN">KARYAWAN</option>
                        </select>
                    </div>

                    <div>
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan password">
                    </div>

                    <div>
                        <label for="no_telp"><i class="fas fa-phone"></i> No. Telepon</label>
                        <input type="text" name="no_telp" id="no_telp" placeholder="Masukkan nomor telepon">
                    </div>

                    <div class="full-width">
                        <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                        <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat">
                    </div>

                    <button type="submit" name="submit"><i class="fas fa-plus"></i> Tambah Karyawan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
