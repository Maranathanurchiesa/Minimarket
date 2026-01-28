<?php
session_start();
session_destroy(); // Hapus semua session
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Logout - Mini Market</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f5f0, #d2b48c);
}

.logout-container {
    background: #fff8f0;
    padding: 50px 60px;
    border-radius: 25px;
    text-align: center;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    animation: fadeIn 1s ease-in-out;
}

.logout-container h2 {
    font-family: 'Playfair Display', serif;
    color: #a0522d;
    font-size: 32px;
    margin-bottom: 20px;
}

.logout-container p {
    font-size: 18px;
    color: #5c4033;
    margin-bottom: 30px;
}

.logout-container i {
    font-size: 50px;
    color: #d2691e;
    margin-bottom: 20px;
    animation: bounce 1.5s infinite;
}

.logout-container a {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: linear-gradient(135deg, #d2691e, #a0522d);
    color: #fff;
    font-weight: 600;
    border-radius: 15px;
    text-decoration: none;
    font-size: 18px;
    transition: background 0.3s, transform 0.2s;
}

.logout-container a:hover {
    background: linear-gradient(135deg, #8b4513, #5c2d1f);
    transform: scale(1.05);
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9);}
    to { opacity: 1; transform: scale(1);}
}

@media(max-width:500px){
    .logout-container { padding: 30px 20px; }
    .logout-container h2 { font-size: 26px; }
    .logout-container p { font-size: 16px; }
    .logout-container a { font-size: 16px; padding: 12px 25px; }
    .logout-container i { font-size: 40px; }
}
</style>
</head>
<body>
<div class="logout-container">
    <i class="fas fa-door-open"></i>
    <h2>Anda telah keluar!</h2>
    <p>Terima kasih telah menggunakan sistem Mini Market. Sampai jumpa lagi!</p>
    <a href="index.php"><i class="fas fa-sign-in-alt"></i> Login Kembali</a>
</div>
</body>
</html>
