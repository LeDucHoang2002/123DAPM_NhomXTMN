<?php
session_start();
include("phpMyAdmin.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]) ? $_POST["remember"] : false;

    // Thực hiện truy vấn SQL để lấy thông tin về quyền của người dùng
    $sql = "SELECT TaiKhoan.tenDangNhap, Quyen.tenQuyen FROM TaiKhoan
            INNER JOIN TaiKhoan_Quyen ON TaiKhoan.tenDangNhap = TaiKhoan_Quyen.tenDangNhap
            INNER JOIN Quyen ON TaiKhoan_Quyen.IDquyen = Quyen.IDquyen
            WHERE TaiKhoan.tenDangNhap = '$username' AND TaiKhoan.matKhau = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $userRole = $row["tenQuyen"];

        if ($userRole === "KhachHang") {
            // Nếu người dùng có quyền Admin, thực hiện đăng nhập và lưu session
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
            // Người dùng không có quyền Admin
            echo "Mới code cho khách hàng thôi";
        }
    } else {
        // Đăng nhập thất bại
        echo "Tài khoản mật khẩu không đúng";
    }
}

// Đóng kết nối CSDL
$conn->close();

?>
