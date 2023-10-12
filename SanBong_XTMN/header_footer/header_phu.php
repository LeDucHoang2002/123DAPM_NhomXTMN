<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styless/details.css">  
    <link rel="stylesheet" href="../styless/home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <link rel="shortcut icon" href="../image/logoXTMN.png" type="image/x-icon">
    <title>Sân Bóng Đá Đà Nẵng</title>
    
</head>
<body>
    <header class="header_details">
        <div class="group_menu">
            <div class="img_logo">
                <img id="img_log0" src="../image/logoXTMN.png" alt="logo">
            </div>
            <div class="menu">
                <nav>
                    <ul>
                        <li><a href="home_page.php">TRANG CHỦ</a></li>
                        <li><a id="details" href="details.php">ĐẶT SÂN</a></li>
                        <li><a href="#">TÌM KÈO</a></li>
                        <li><a href="#">LIÊN HỆ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="login-link">
            <?php
                session_start();
                if (isset($_SESSION["username"])) {
                    // Nếu người dùng đã đăng nhập, hiển thị tên đăng nhập
                    $username = $_SESSION["username"];
                    echo '<div class="dropdown">
                            <img id="img_login" src="../image/icon_user.png" alt="Tài khoản">
                            <b>' . $username . '</b>
                            <div class="dropdown-content">
                                <a href="../database/logout.php" class="login">Đăng xuất</a>
                                <a href="profile.php?tenDangNhap=' . $_SESSION["username"] . '">Trang cá nhân</a>
                            </div>
                          </div>';
                } else {
                    // Nếu người dùng chưa đăng nhập, hiển thị liên kết đăng nhập
                    echo '<a href="log_in.php" class="login"><img id="img_login" src="../image/icon_user.png" alt="Đặt sân">ĐĂNG NHẬP</a>';
                }
                ?>
            </div>
        </div>
    </header>