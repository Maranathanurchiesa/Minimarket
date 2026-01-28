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

$id = intval($_GET['id']);
$msg = "";

// Ambil data karyawan
$stmt = $conn->prepare("SELECT * FROM karyawan WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 0){
    header("Location: karyawan.php");
    exit;
}
$karyawan = $result->fetch_assoc();

// Proses update
if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $role = $_POST['role'];

    if(!empty($nama) && !empty($role)){
        $stmt = $conn->prepare("UPDATE karyawan SET nama=?, no_telp=?, alamat=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama, $no_telp, $alamat, $role, $id);

        if($stmt->execute()){
            header("Location: karyawan.php?msg=Karyawan berhasil diperbarui");
            exit;
        } else {
            $msg = "Terjadi kesalahan, coba lagi.";
        }
    } else {
        $msg = "Nama dan Role wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Karyawan - Mini Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display:flex;
            flex-direction:column;
            background: linear-gradient(135deg, #f5f5f0, #d2b48c);
            position: relative;
        }
        body::before{
            content:'';
            position:absolute;
            top:0;left:0;width:100%;height:100%;
            background-image:url('https://www.transparenttextures.com/patterns/pw-maze-white.png');
            opacity:0.05;
            z-index:0;
        }
        .header{
            background:#a0522d;color:#fff;
            padding:25px 50px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            font-family:'Playfair Display', serif;
            box-shadow:0 5px 20px rgba(0,0,0,0.15);
            border-bottom-left-radius:15px;
            border-bottom-right-radius:15px;
            z-index:1;
            position:relative;
        }
        .header h2{font-size:28px;display:flex;align-items:center;gap:12px;}
        .header a{
            background: linear-gradient(135deg, #d2691e, #a0522d);
            padding:10px 18px;border-radius:12px;color:#fff;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:8px;
            transition: background 0.3s, transform 0.2s;
        }
        .header a:hover{
            background: linear-gradient(135deg, #8b4513, #5c2d1f);
            transform: scale(1.05);
        }
        .container{
            flex:1;display:flex;justify-content:center;align-items:center;
            padding:60px 20px;z-index:1;position:relative;
        }
        .card{
            background:#fff8f0;
            border-radius:25px;
            padding:50px 40px;
            width:100%;
            max-width:500px;
            box-shadow:0 15px 30px rgba(0,0,0,0.15);
            position:relative;
            overflow:hidden;
            transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
        }
        .card:hover{
            transform: translateY(-8px);
            box-shadow:0 20px 40px rgba(0,0,0,0.25);
            background:#fffaf0;
        }
        .card h3{
            font-family:'Playfair Display', serif;color:#8b4513;font-size:28px;margin-bottom:35px;text-align:center;
        }
        form label{
            display:flex;align-items:center;gap:8px;margin-bottom:8px;font-weight:600;color:#5c4033;
        }
        form input, form select{
            width:100%;padding:14px 15px;margin-bottom:25px;border-radius:12px;border:1px solid #ccc;font-size:16px;
            transition:border-color 0.3s,box-shadow 0.3s;
        }
        form input:focus, form select:focus{
            outline:none;border-color:#d2691e;box-shadow:0 0 10px rgba(210,105,30,0.5);
        }
        form button{
            width:100%;padding:16px;border-radius:15px;border:none;
            background: linear-gradient(135deg,#d2691e,#a0522d);
            color:#fff;font-size:18px;font-weight:600;cursor:pointer;
            display:flex;align-items:center;justify-content:center;gap:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.2);transition:background 0.3s,transform 0.2s,box-shadow 0.3s;
        }
        form button:hover{
            background: linear-gradient(135deg,#8b4513,#5c2d1f);transform:scale(1.03);box-shadow:0 10px 25px rgba(0,0,0,0.3);
        }
        .msg{
            text-align:center;margin-bottom:25px;color:#a0522d;font-weight:600;display:flex;align-items:center;justify-content:center;gap:8px;
        }
        @media(max-width:500px){
            .card{padding:35px 25px;}
            .card h3{font-size:24px;}
            form input, form select{padding:12px 12px;}
            form button{font-size:16px;padding:14px;}
        }
    </style>
</head>
<body>
    <div class="header">
        <h2><i class="fas fa-user-edit"></i> Edit Karyawan</h2>
        <a href="karyawan.php"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="container">
        <div class="card">
            <?php if($msg != "") echo "<div class='msg'><i class='fas fa-info-circle'></i> $msg</div>"; ?>
            <form method="post">
                <label for="nama"><i class="fas fa-user"></i> Nama</label>
                <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($karyawan['nama']) ?>" required>

                <label for="no_telp"><i class="fas fa-phone"></i> No. Telepon</label>
                <input type="text" name="no_telp" id="no_telp" value="<?= htmlspecialchars($karyawan['no_telp']) ?>">

                <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($karyawan['alamat']) ?>">

                <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                <select name="role" id="role" required>
                    <option value="ADMIN" <?= $karyawan['role']=='ADMIN'?'selected':'' ?>>ADMIN</option>
                    <option value="KARYAWAN" <?= $karyawan['role']=='KARYAWAN'?'selected':'' ?>>KARYAWAN</option>
                </select>

                <button type="submit" name="submit"><i class="fas fa-save"></i> Update Karyawan</button>
            </form>
        </div>
    </div>
</body>
</html>
