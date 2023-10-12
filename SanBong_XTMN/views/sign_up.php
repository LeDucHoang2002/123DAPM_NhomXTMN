<!DOCTYPE html>
<html lang="en">
<head>
    
<link rel="stylesheet" href="../styless/home.css">
<link rel="stylesheet" href="../styless/signup.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="shortcut icon" href="../image/logoXTMN.png" type="image/x-icon">  
    <title>Sân Bóng Đá Đà Nẵng</title>
   
</head>
<body>
    <header class="header_signup">
            <div class="logo_home">
                <a href="home_page.php">
                <img id="img_logo" src="../image/logoXTMN.png" alt="logo"></img>
                </a>
                <h1>Đăng Ký</h1> 
            </div>
            <div class="help">
                <a href="#">Bạn cần giúp đỡ ?</a>  
            </div>         
    </header>
    
    <main >
    <div class="trangchu_signup">
            <div class="main_left">
                <img src="../image/nen_dong.gif" alt="#" loop="20">
            </div>
            <div class="main_right">
                <h2>Đăng Ký</h2>
                <form method="post" action="../database/signup_process.php"> 
                <div class="form-group">
                        <label for="soDienThoai">Số điện thoại:</label>
                        <div class="password-container">
                            <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                <div class="form-group">
                        <label for="tenDangNhap">Tên đăng nhập:</label>
                        <div class="password-container">
                            <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập">
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
                    <label for="confirm_password">Nhập Lại Mật Khẩu:</label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                        <span class="toggle-confirm-password">
                            <img src="../image/icons_eyes_dong.png" alt="Con mắt">
                        </span>
                    </div>
                </div>
                
                <div class="button-signup">
                        <div class="signup">
                            <button type="submit" class="signup2">Đăng Ký</button>
                        </div>
                </div>
                <div class="register-link">
                    Bạn đã có tài khoản? <a href="log_in.php">Đăng Nhập</a>
                </div>
                </fieldset>
            </form>
            </div>
            <div class="login">
            <div class="top">
                </fieldset>
            </form>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const passwordField = document.getElementById("password");
                const confirmPasswordField = document.getElementById("confirm_password");
                const togglePassword = document.querySelector(".toggle-password img");
                const toggleConfirmPassword = document.querySelector(".toggle-confirm-password img");
                const registerButton = document.querySelector(".signup2");
                const registrationForm = document.getElementById("registration-form");

                togglePassword.addEventListener("click", function() {
                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        togglePassword.src = "../image/icon_eyes_mo.png"; // Thay đổi hình ảnh khi mở
                    } else {
                        passwordField.type = "password";
                        togglePassword.src = "../image/icons_eyes_dong.png"; // Thay đổi hình ảnh khi đóng
                    }
                });

                toggleConfirmPassword.addEventListener("click", function() {
                    if (confirmPasswordField.type === "password") {
                        confirmPasswordField.type = "text";
                        toggleConfirmPassword.src = "../image/icon_eyes_mo.png"; // Thay đổi hình ảnh khi mở
                    } else {
                        confirmPasswordField.type = "password";
                        toggleConfirmPassword.src = "../image/icons_eyes_dong.png"; // Thay đổi hình ảnh khi đóng
                    }
                });

                function validatePassword() {
                    if (passwordField.value !== confirmPasswordField.value) {
                        confirmPasswordField.setCustomValidity("Mật khẩu không khớp");
                    } else {
                        confirmPasswordField.setCustomValidity("");
                    }
                }

                passwordField.addEventListener("change", validatePassword);
                confirmPasswordField.addEventListener("keyup", validatePassword);

                registerButton.addEventListener("click", function(event) {
                    if (passwordField.value !== confirmPasswordField.value) {
                        event.preventDefault(); // Ngăn chặn gửi biểu mẫu nếu mật khẩu không khớp
                        alert("Mật khẩu không khớp. Vui lòng kiểm tra lại!");
                    }
                });
            });
        </script>
    </main>
    
    <?php
include '../header_footer/footer.php';
?>