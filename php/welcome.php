<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng nhập thành công!</h2>
        <p>Xin chào, <b><?php echo $_SESSION["username"]; ?></b></p>
        <p><a href="logout.php">Đăng xuất</a></p>
    </div>
</body>
</html>