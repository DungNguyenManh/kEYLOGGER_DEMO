<?php
$host = "localhost";
$user = "root"; // Tài khoản mặc định của XAMPP
$pass = "";
$dbname = "keylogger_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
