<?php
session_start();
include("phpMyAdmin.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]) ? $_POST["remember"] : false;

    $sql = "SELECT * FROM TaiKhoan WHERE tenDangNhap = '$username' AND matKhau = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION["username"] = $username;

        if ($remember) {
            // Nếu người dùng chọn tùy chọn "Lưu Mật Khẩu," lưu mật khẩu vào một cookie
            setcookie("remembered_password", $password, time() + 86400 * 30, "/"); // Lưu trong 30 ngày
        } else {
            // Nếu không chọn tùy chọn "Lưu Mật Khẩu," xóa cookie nếu có
            if (isset($_COOKIE["remembered_password"])) {
                setcookie("remembered_password", "", time() - 3600, "/");
            }
        }

        header("Location: ../views/home_page.php"); // Redirect to the home page
        exit();
    } else {
        // Login failed
        echo "Invalid username or password";
    }
}

// Close the database connection
$conn->close();
?>
