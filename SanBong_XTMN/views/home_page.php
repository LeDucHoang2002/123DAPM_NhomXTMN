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
            <img id="img_logo" src="../image/logoXTMN.png" alt="logo"></img>
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
                echo '<a href="../database/logout.php" class="login">' .
                    '<img id="img_login" src="../image/icon_user.png" alt="Tài khoản">' .
                    $username .
                    '</a>';
            } else {
                // Nếu người dùng chưa đăng nhập, hiển thị liên kết đăng nhập
                echo '<a href="log_in.php" class="login">' .
                    '<img id="img_login" src="../image/icon_user.png" alt="Đặt sân">ĐĂNG NHẬP</a>';
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
        <div class="container">
            <div class="search-container">
                <!-- Combobox cho Quận/Huyện -->
                <div class="input-container">
                    <label for="district">Quận/Huyện:</label>
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
                    <label for="ward">Phường/Xã:</label>
                    <select id="ward" name="ward">
                        <option value="">Chọn Phường/Xã</option>
                    </select>
                </div>
                                
                <div class="input-container">
                    <label for="search">Tìm kiếm:</label>
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
    
    <main class="trangchu">
        
    <h2>Sân Bóng Đà Nẵng</h2>
        <div class="trangchu_main">
            <div id="searchResults" class="search-results">
        <!-- Kết quả tìm kiếm sẽ được hiển thị ở đây -->
            </div>
            <script>
                // Lắng nghe sự kiện click trên nút "Tìm kiếm"
                document.querySelector("button").addEventListener("click", function() {
                    performSearch();
                });

                // Tự động thực hiện tìm kiếm mặc định khi trang web được tải
                window.addEventListener("load", function() {
                    performSearch();
                });

                function performSearch() {
                    const selectedDistrict = document.getElementById("district").value;
                    const selectedWard = document.getElementById("ward").value;
                    const searchTerm = document.getElementById("search").value;

                    // Gửi yêu cầu Ajax để tìm kiếm dựa trên selectedDistrict, selectedWard và searchTerm
                    // Sử dụng Fetch API để gửi yêu cầu
                    fetch(`../database/search.php?district=${selectedDistrict}&ward=${selectedWard}&search=${searchTerm}`)
                        .then(response => response.text())
                        .then(data => {
                            // Hiển thị kết quả tìm kiếm ở phần tử searchResults
                            document.getElementById("searchResults").innerHTML = data;
                        });
                }
                
            </script>

            
        </div>           
    </main>
    <footer>
        <div class="footer_">
            <div class="footer_left">
            <img id="logo_footer" src="../image/logoXTMN.png" alt="logo"></img>
                <p><b>HOTLINE :</b> 035 305 7899</p>
                <p><b>FACEBOOK :</b> facebook.com/Đặt sân bóng đá Đà Nẵng </p>
            </div>
            <div class="footer_center">
                <p><b>CHÍNH SÁCH</b></p>
                <p>Chính sách bảo mật</p>
                <p>Chính sách đặt sân và  thanh toán </p>
                <p>Cam kết chất lượng </p>
            </div>
            <div class="footer_right">
                <p><b>HÒM THƯ GÓP Ý</b></p>
                <input type="text" id="text" name="search" placeholder="Nhập thông tin góp ý">                
                <button id="send">Gửi</button>
                </div>
            </div>
        </div>
        <div class="license">
            <h3>© Bản quyền thuộc TEAM XTMN </h3>
        </div>       
    </footer>
</body>
</html>
