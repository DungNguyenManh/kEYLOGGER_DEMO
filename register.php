<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu

    // Kiểm tra nếu tài khoản đã tồn tại
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username=?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo "Tài khoản đã tồn tại! <a href='register.php'>Thử lại</a>";
    } else {
        // Lưu vào database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo "Đăng ký thành công! <a href='login.php'>Đăng nhập</a>";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head><title>Đăng ký</title></head>
<body>
    <h2>Đăng ký tài khoản</h2>
    <form method="POST">
        Tên đăng nhập: <input type="text" name="username" required><br>
        Mật khẩu: <input type="password" name="password" required><br>
        <input type="submit" value="Đăng ký">
    </form>
</body>
</html>
