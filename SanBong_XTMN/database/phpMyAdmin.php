<?php
$servername = "localhost"; // Địa chỉ máy chủ MySQL
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$dbname = "QuanLySanBong_XTMN"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến CSDL thất bại: " . $conn->connect_error);
}
?>

