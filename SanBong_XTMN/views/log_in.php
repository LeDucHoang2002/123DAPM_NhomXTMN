<!DOCTYPE html>
<html lang="en">
<head>
    
<link rel="stylesheet" href="../styless/home.css">
<link rel="stylesheet" href="../styless/login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="shortcut icon" href="../image/logoXTMN.png" type="image/x-icon">  
    <title>Sân Bóng Đá Đà Nẵng</title>
   
</head>
<body>
    <header class="header_login">
            <div class="logo_home">
                <a href="home_page.php">
                <img id="img_logo" src="../image/logoXTMN.png" alt="logo"></img>
                </a>
                <h1>Đăng Nhập</h1> 
            </div>
            <div class="help">
                <a href="#">Bạn cần giúp đỡ ?</a>  
            </div>         
    </header>
    
    <main >
    <div class="trangchu_login">
            <div class="main_left">
                <img src="../image/nen_dong.gif" alt="#" loop="20">
            </div>
            <div class="main_right">
                <h2>Đăng Nhập</h2>
                <form method="post" action="../database/login_process.php"> 
                    <div class="form-group">
                        <label for="username">Tài Khoản:</label>
                        <div class="password-container">
                            <input type="text" id="username" name="username" placeholder="Nhập tài khoản">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật Khẩu:</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                            <span class="toggle-password">
                                <img src="../image/icons_eyes_dong.png" alt="Con mắt">
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="remember"> Lưu Mật Khẩu
                        </label>
                    </div>
                    <div class="button-login">
                        <div class="login">
                            <button type="submit" class="login2">Đăng Nhập</button>
                        </div>
                    </div>
                </form>

                <div class="form-group">
                    <a href="#">Quên Mật Khẩu?</a>
                </div>
                <div class="button-login">
                    <div class="login1">
                        <button type="button" class="facebook-login">Facebook</button>
                        <button type="button" class="google-login">Google</button>
                    </div>
                </div>
                <div class="register-link">
                    Chưa có tài khoản? <a href="sign_up.php">Đăng Ký Nhanh</a>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const passwordField = document.getElementById("password");
                const togglePassword = document.querySelector(".toggle-password img");

                togglePassword.addEventListener("click", function() {
                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        togglePassword.src = "../image/icon_eyes_mo.png"; // Thay đổi hình ảnh khi mở
                    } else {
                        passwordField.type = "password";
                        togglePassword.src = "../image/icons_eyes_dong.png"; // Thay đổi hình ảnh khi đóng
                    }
                });
            });
        </script>


    </main>
    <?php
include '../header_footer/footer.php';
?>
