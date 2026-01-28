<?php
session_start();
include 'database.php';

$error = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    // hash sederhana untuk cek
    $password = md5($password_input);

    $stmt = $conn->prepare("SELECT * FROM karyawan WHERE nama=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - Mini Market</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f5f0, #d2b48c); /* sama dengan logout */
}

.login-box {
    background: #fff8f0;
    padding: 50px 60px;
    border-radius: 25px;
    text-align: center;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    position: relative;
    overflow: hidden;
    animation: fadeIn 1s ease-in-out;
    width: 380px;
}

.login-box h2 {
    font-family: 'Playfair Display', serif;
    color: #a0522d;
    font-size: 32px;
    margin-bottom: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.login-box h2 i { font-size: 36px; }

.input-group {
    position: relative;
    margin-bottom: 25px;
}

.input-group i {
    position: absolute;
    top: 12px;
    left: 15px;
    color: #d2691e;
    font-size: 18px;
    cursor: pointer;
}

.login-box input {
    width: 100%;
    padding: 12px 15px 12px 40px;
    border-radius: 12px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.login-box input:focus {
    border-color: #d2691e;
    box-shadow: 0 0 8px rgba(210,105,30,0.4);
    outline: none;
}

.login-box button {
    width: 100%;
    padding: 16px;
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
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: background 0.3s, transform 0.2s;
}

.login-box button:hover {
    background: linear-gradient(135deg, #8b4513, #5c2d1f);
    transform: scale(1.03);
}

.login-box .error {
    color: red;
    margin-bottom: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9);}
    to { opacity: 1; transform: scale(1);}
}

@media(max-width:420px){
    .login-box { width: 90%; padding: 40px 25px; }
    .login-box h2 { font-size: 26px; }
    .login-box button { font-size: 16px; padding: 14px; }
}
</style>
</head>
<body>
<div class="login-box">
    <h2><i class="fas fa-store"></i> Mini Market Login</h2>
    <?php if($error) echo "<p class='error'><i class='fas fa-exclamation-circle'></i> $error</p>"; ?>
    <form method="POST">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group">
            <i class="fas fa-eye" id="togglePassword"></i>
            <input type="password" name="password" placeholder="Password" id="password" required>
        </div>
        <button name="login"><i class="fas fa-right-to-bracket"></i> Login</button>
    </form>
</div>

<script>
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    this.classList.toggle("fa-eye-slash");
});
</script>
</body>
</html>
