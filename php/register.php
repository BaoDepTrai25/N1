<?php
include "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST["username"]);
    $pass = trim($_POST["password"]);

    if (empty($user) || empty($pass)) {
        $message = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Kiểm tra username đã tồn tại chưa
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $user);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $message = "Tên đăng nhập đã tồn tại!";
        } else {
            // Hash mật khẩu trước khi lưu
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ss", $user, $hashed_password);

            if ($stmt_insert->execute()) {
                $message = "Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a>";
            } else {
                $message = "Đăng ký thất bại!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Ký</h2>

        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Tên đăng nhập:</label>
            <input type="text" name="username" required>

            <label>Mật khẩu:</label>
            <input type="password" name="password" required>

            <button type="submit">Đăng ký</button>
        </form>

        <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </div>
</body>
</html>