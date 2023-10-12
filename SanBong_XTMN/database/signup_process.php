<?php
session_start();
include("phpMyAdmin.php");

// Xử lý đăng ký khi người dùng gửi mẫu đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password == $confirm_password) {
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    
        $query = "INSERT INTO TaiKhoan (tenDangNhap, soDienThoai, matKhau) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $phone, $password);
    
        $query2 = "INSERT INTO taikhoan_quyen (tenDangNhap, IDquyen) VALUES (?, 3)"; // Sửa câu lệnh INSERT
        $stmt1 = $conn->prepare($query2);
        $stmt1->bind_param("s", $username); // Sửa bind_param
    
        if ($stmt->execute() && $stmt1->execute()) {
            echo "Đăng ký thành công!";
            header("Location: ../views/log_in.php"); // Redirect to the home page
            exit();
        } else {
            echo "Lỗi khi thực hiện đăng ký: " . $stmt->error;
        }
    } else {
        echo "Mật khẩu không khớp. Vui lòng thử lại.";
    }
    
}
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>