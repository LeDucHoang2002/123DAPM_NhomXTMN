<!DOCTYPE html>
<html lang="en">
<head>
    
<link rel="stylesheet" href="../styless/home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <link rel="shortcut icon" href="../image/logoXTMN.png" type="image/x-icon">
    <title>Sân Bóng Đá Đà Nẵng</title>
   
</head>
<body>
    <header class="header">
        
        <div class="group_menu">
            
            <img id="img_logo" src="../image/logoXTMN.png" alt="logo" ></img>
            <div class="menu">
                <nav >
                    <ul>
                        <li><a id="home_page" href="home_page.php">TRANG CHỦ</a></li>
                        <li><a href="details.php">ĐẶT SÂN</a></li>
                        <li><a href="ppp.php">TÌM KÈO</a></li>
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
        <?php
            // Thực hiện kết nối CSDL
            require_once("../database/phpMyAdmin.php");

            // Truy vấn SQL để lấy danh sách quận/huyện từ CSDL
            $queryDistricts = "SELECT * FROM QuanHuyen";
            $resultDistricts = $conn->query($queryDistricts);
        ?>
        <div class="container-header">
            <div class="search-container">
                <!-- Combobox cho Quận/Huyện -->
                <div class="input-container">
                    <select id="district" name="district">
                        <option value="">Chọn Quận/Huyện</option>
                        <?php
                        // Lặp qua các dòng dữ liệu từ truy vấn quận/huyện và tạo tùy chọn
                        while ($rowDistrict = $resultDistricts->fetch_assoc()) {
                            echo "<option value='" . $rowDistrict["IDquanHuyen"] . "'>" . $rowDistrict["tenQuanHuyen"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="input-container">
                    <select id="ward" name="ward">
                        <option value="">Chọn Phường/Xã</option>
                    </select>
                </div>
                                
                <div class="input-container">
                    <input type="text" id="search" name="search" placeholder="Nhập thông tin tìm kiếm...">
                </div>
                <div >
                    <button class="button_timkiem"onclick="performSearch()"><img id="img_search" src="../image/icons_search.png" alt="#"></button>
                </div>
                
            </div>
        </div>

        <script>
            // Lắng nghe sự kiện thay đổi trong combobox Quận/Huyện
            document.getElementById("district").addEventListener("change", function() {
                var selectedDistrictId = this.value;
                var wardSelect = document.getElementById("ward");

                // Xóa tất cả các tùy chọn phường/xã hiện có
                wardSelect.innerHTML = "<option value=''>Chọn Phường/Xã</option>";

                // Nếu đã chọn Quận/Huyện
                if (selectedDistrictId !== "") {
                    // Truy vấn danh sách phường/xã dựa trên Quận/Huyện đã chọn
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Parse dữ liệu JSON từ phản hồi
                            var wards = JSON.parse(xhr.responseText);

                            // Thêm tùy chọn phường/xã vào combobox
                            for (var i = 0; i < wards.length; i++) {
                                var ward = wards[i];
                                var option = document.createElement("option");
                                option.value = ward.IDphuongXa;
                                option.textContent = ward.tenPhuongXa;
                                wardSelect.appendChild(option);
                            }
                        }
                    };

                    // Gửi yêu cầu AJAX để lấy danh sách phường/xã
                    xhr.open("GET", "../database/get_wards.php?district_id=" + selectedDistrictId, true);
                    xhr.send();
                }
            });
            </script>

    </header>