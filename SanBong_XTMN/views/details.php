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
    </header>
    
    <main class="trangchu">
        
    <?php
        require_once("../database/phpMyAdmin.php");
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Truy vấn SQL để lấy thông tin từ bảng SanBong và TaiKhoan
            $sqlSanBong = "SELECT SanBong.*, PhuongXa.tenPhuongXa, QuanHuyen.tenQuanHuyen, TaiKhoan.tenTaiKhoan, TaiKhoan.soDienThoai AS chuSanDienThoai
                        FROM SanBong
                        INNER JOIN PhuongXa ON SanBong.IDphuongXa = PhuongXa.IDphuongXa
                        INNER JOIN QuanHuyen ON PhuongXa.IDquanHuyen = QuanHuyen.IDquanHuyen
                        INNER JOIN TaiKhoan ON SanBong.tenDangNhap = TaiKhoan.tenDangNhap
                        WHERE SanBong.IDsanBong = $id";
            $resultSanBong = $conn->query($sqlSanBong);

            if ($resultSanBong->num_rows > 0) {
                $rowSanBong = $resultSanBong->fetch_assoc();

                // Truy vấn SQL để tính trung bình cộng số sao cho sân bóng
                $sqlAverageRating = "SELECT AVG(danhGiaSao) AS trungBinhSao FROM BinhLuan WHERE IDsanCon IN (SELECT IDsanCon FROM SanCon WHERE IDsanBong = $id)";
                $resultAverageRating = $conn->query($sqlAverageRating);

                if ($resultAverageRating->num_rows > 0) {
                    $rowAverageRating = $resultAverageRating->fetch_assoc();
                    $trungBinhSaoSanBong = $rowAverageRating["trungBinhSao"];
                } else {
                    $trungBinhSaoSanBong = 0; // Nếu không có dữ liệu, bạn có thể gán một giá trị mặc định
                }
                // Hiển thị thông tin sân bóng và chủ sân
                echo "<div class='sanbong-info'>";
                    echo "<div class='sanbong-info-left'>";
                        echo "<h2>" . $rowSanBong["tenSan"] . " / ". number_format($trungBinhSaoSanBong, 1) . "<img src='../image/icons8-star-30.png' alt=''></h2>";                                                
                        echo "<div class='img-info-left'>";
                        // Hiển thị hình ảnh của SanBong nếu có
                            if ($rowSanBong["hinhAnh"] !== null && $rowSanBong["hinhAnh"] !== "") {
                                echo "<img class='sanbong-image' src='" . $rowSanBong["hinhAnh"] . "' alt='Hình ảnh sân bóng'>";
                            } else {
                                echo "Không có hình ảnh.";
                            }               
                        echo "</div>";    
                    echo "</div>";
                    echo "<div class='sanbong-info-right'>";
                        echo "<p><b>Địa chỉ: </b>". $rowSanBong["dinhVi"] . ", ". $rowSanBong["viTri"] .", ". $rowSanBong["tenPhuongXa"] . ", ". $rowSanBong["tenQuanHuyen"] . ", Đà Nẵng</p>";                    
                        echo "<p><b>Thời gian hoạt động:</b> " . $rowSanBong["thoiGianMoCua"] ." - " . $rowSanBong["thoiGianDongCua"] ."</p>";
                        echo "<p><b>Giá sân:</b> " . $rowSanBong["mucGia"] . "</p>";
                        echo "<p><b>Mô tả: </b>" . $rowSanBong["moTa"] . "</p>";
                        echo "<p><b>Chủ sân: </b>" . $rowSanBong["tenTaiKhoan"] . "</p>";
                        echo "<p><b>Số điện thoại: </b>" . $rowSanBong["chuSanDienThoai"] . "</p>";
                    echo "</div>";
                echo "</div>";
                echo"</div>";
                echo "<h2 id='h2'>Chi tiết sân bóng</h2>";
                echo"<div class='time'>";
                    echo"<label for='date'>Chọn ngày đặt sân : </label>";                
                        echo"<form method='post' id='dateForm'>";
                        echo"<input type='date' id='date' name='date' min='" . date('d-m-Y') . "'>";
                        echo"<input type='submit' id='Xem' value='Xem sân'>";
                    echo"</form>";            
                echo"</div>";
                

                // Đầu tiên, tạo một div container cho sân con
                echo "<div class='sancon-container'>";
                    // Truy vấn SQL để lấy thông tin từ bảng SanCon dựa trên IDsanBong
                    $sqlSanCon = "SELECT * FROM SanCon WHERE IDsanBong = $id";
                    $resultSanCon = $conn->query($sqlSanCon);

                    if ($resultSanCon->num_rows > 0) {
                        // Trong vòng lặp hiển thị thông tin sân con
                        while ($rowSanCon = $resultSanCon->fetch_assoc()) {
                            // Hiển thị thông tin sân con
                            echo "<div class='sancon-info'>";
                                echo "<div class='sancon-info-top'>";// Truy vấn SQL để lấy trung bình cộng sao cho từng sân con
                                $sqlAverageRating = "SELECT IDsanCon, AVG(danhGiaSao) AS trungBinhSao FROM BinhLuan GROUP BY IDsanCon";
                                $resultAverageRating = $conn->query($sqlAverageRating);

                                // Tạo một mảng để lưu trữ trung bình cộng sao cho từng sân con
                                $averageRatings = array();

                                if ($resultAverageRating->num_rows > 0) {
                                    while ($rowRating = $resultAverageRating->fetch_assoc()) {
                                        $averageRatings[$rowRating["IDsanCon"]] = $rowRating["trungBinhSao"];
                                    }                                
                                } 
                                
                                // Kiểm tra xem có dữ liệu trong $averageRatings hay không
                                if (isset($averageRatings[$rowSanCon["IDsanCon"]])) {
                                    // Nếu có dữ liệu, hiển thị trung bình cộng sao
                                    echo "<h2 id='tensancon'>". $rowSanCon["tenSanCon"] . " / ". number_format($averageRatings[$rowSanCon["IDsanCon"]], 1) . " <img src='../image/icon_star.png' alt=''></h2>";
                                } else {
                                    // Nếu không có dữ liệu, hiển thị giá trị mặc định hoặc thông báo
                                    echo "<h2 id='tensancon'>". $rowSanCon["tenSanCon"] ." / 0<img src='../image/icon_star.png' alt=''></h2>";
                                }

                                echo "<div class='sancon'>";
                                    echo "<div class='sancon_left'>";
                                    // Hiển thị hình ảnh sân con nếu có
                                $sanConID = $rowSanCon["IDsanCon"];
                                $sqlSanConImages = "SELECT HinhAnh.hinhAnh FROM SanCon_HinhAnh
                                                    INNER JOIN HinhAnh ON SanCon_HinhAnh.IDhinhAnh = HinhAnh.IDhinhAnh
                                                    WHERE SanCon_HinhAnh.IDsanCon = $sanConID";
                                $resultSanConImages = $conn->query($sqlSanConImages);

                                if ($resultSanConImages->num_rows > 0) {
                                    while ($rowImage = $resultSanConImages->fetch_assoc()) {
                                        echo "<img  id='img_sancon' src='" . $rowImage["hinhAnh"] . "' alt='Hình ảnh sân con'>";
                                    }
                                }
                                        
                                    echo "</div>";
                                    echo "<div class='sancon_right'>";
                                        echo"<div class='sancon_right_left'>";
                                            echo "<p><b>Loại sân:</b> " . $rowSanCon["loaiSan"] . "</p>";
                                            echo "<p><b>Tình trạng:</b> " . $rowSanCon["tinhTrang"] . "</p>";
                                            echo "<p><b>Giá:</b> " . $rowSanCon["gia"] . "</p>";
                                            echo "<div class='sancon-info-button'>";
                                                if (isset($_SESSION["username"])) {
                                                    // Nếu người dùng đã đăng nhập, chuyển hướng tới trang đặt sân với tham số idsancon
                                                    echo "<a href='ppp.php?idsancon=" . $rowSanCon["IDsanCon"] . "'><button>Đặt sân</button></a>";
                                                } else {
                                                    // Nếu người dùng chưa đăng nhập, chuyển hướng tới trang đăng nhập
                                                    echo "<a href='log_in.php'><button>Đặt sân</button></a>";
                                                }
                                                echo "</div>";

                                        echo "</div>";         
                                        

                                        echo"<div class='sancon_right2'>";   
                                            // Truy vấn SQL để lấy thông tin chi tiết phiếu đặt sân cho sân con này
                                            $sqlChiTietDatSan = "SELECT * FROM ChiTietDatSan WHERE IDsanCon = " . $rowSanCon["IDsanCon"];
                                            $resultChiTietDatSan = $conn->query($sqlChiTietDatSan);

                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                if (isset($_POST['date'])) {
                                                    $selectedDate = $_POST['date'];
                                                    // Thực hiện truy vấn SQL để lấy thông tin sân bận dựa trên ngày đã chọn
                                                    $sqlChiTietDatSan = "SELECT * FROM ChiTietDatSan WHERE IDsanCon = " . $rowSanCon["IDsanCon"] . " AND ngayDat = '" . $selectedDate . "' ORDER BY gioBatDau ASC;";

                                                    echo "<p><b>Lịch đã đặt " . $selectedDate . ":</b></p>";
                                                    // Thực hiện truy vấn SQL và xử lý kết quả
                                                    $resultChiTietDatSan = $conn->query($sqlChiTietDatSan);
                                                    if ($resultChiTietDatSan->num_rows > 0) {
                                                        while ($rowChiTietDatSan = $resultChiTietDatSan->fetch_assoc()) {
                                                            // Hiển thị thông tin chi tiết phiếu đặt sân
                                                            echo "<p>" . $rowChiTietDatSan["gioBatDau"] . " - " . $rowChiTietDatSan["gioKetThuc"] . "</p>";
                                                        }
                                                    } else {
                                                        echo "<p>Chưa có lịch đặt sân</p>";
                                                    }
                                                }
                                            }
                                            echo "<div class='booking-form-container' >";
                                            echo "<label for='gio1'>Chọn giờ thứ nhất:</label>".
                                            "<select id='gio1' name='gio1'>".
                                                "<option value='01:00'>01:00</option>".
                                                "<option value='02:00'>02:00</option>".
                                                "<option value='03:00'>03:00</option>".
                                                "<option value='04:00'>04:00</option>".
                                                "<option value='05:00'>05:00</option>".
                                                "<option value='06:00'>06:00</option>".
                                                "<option value='07:00'>07:00</option>".
                                                "<option value='08:00'>08:00</option>".
                                                "<option value='09:00'>09:00</option>".
                                                "<option value='10:00'>10:00</option>".
                                                "<option value='11:00'>11:00</option>".
                                                "<option value='12:00'>12:00</option>".
                                            "</select>";
                                            echo "<select id='kieu_gio1' name='kieu_gio1'>".
                                                "<option value='AM'>AM</option>".
                                                "<option value='PM'>PM</option>".
                                            "</select>";
                                            echo"</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";                            
                            echo "</div>";
                        echo "</div>";
                    }

                    } else {
                        echo "Không có thông tin về sân con.";
                    }

                // Đóng container cho sân con
                echo "</div>";
                echo"<div class='binhluan'>";
                echo "<h3>Bình luận:</h3>";
                // Truy vấn SQL để lấy thông tin từ bảng BinhLuan và HinhAnh theo IDsanBong
                $sqlBinhLuan = "SELECT BinhLuan.*, TaiKhoan.avt ,TaiKhoan.tenTaiKhoan ,SanCon.tenSanCon
                                FROM BinhLuan 
                                INNER JOIN TaiKhoan ON BinhLuan.tenDangNhap = TaiKhoan.tenDangNhap
                                INNER JOIN SanCon ON BinhLuan.IDsanCon = SanCon.IDsanCon                                
                                WHERE BinhLuan.IDsanCon IN (SELECT IDsanCon FROM SanCon WHERE IDsanBong = $id)";
                $resultBinhLuan = $conn->query($sqlBinhLuan);

                if ($resultBinhLuan->num_rows > 0) {
                    while ($rowBinhLuan = $resultBinhLuan->fetch_assoc()) {
                        // Hiển thị thông tin bình luận
                        
                        echo "<div class='binhluan-info'>";                        
                        // Hiển thị ảnh đại diện của người bình luận
                        if ($rowBinhLuan["avt"] !== null && $rowBinhLuan["avt"] !== "") {
                            echo "<img class='avata-image' src='" . $rowBinhLuan["avt"] . "' alt='Ảnh đại diện'> <b>". $rowBinhLuan["tenTaiKhoan"] . " : </b>". $rowBinhLuan["danhGiaSao"] . " <img id='img_star'src='../image/icon_star.png' alt=''></img>";
                        }
                        echo "<p>" . $rowBinhLuan["ngayBinhLuan"] . "</p>";
                        echo "<p><b>Sân Đã Chọn:</b> " . $rowBinhLuan["tenSanCon"] . "</p>";
                        echo "<p><b>Nội dung:</b> " . $rowBinhLuan["noiDung"] . "</p>";
                        // Hiển thị hình ảnh bình luận nếu có
                        $binhLuanID = $rowBinhLuan["IDbinhLuan"];
                        $sqlBinhLuanImages = "SELECT HinhAnh.hinhAnh FROM BinhLuan_HinhAnh
                                            INNER JOIN HinhAnh ON BinhLuan_HinhAnh.IDhinhAnh = HinhAnh.IDhinhAnh
                                            WHERE BinhLuan_HinhAnh.IDbinhLuan = $binhLuanID";
                        $resultBinhLuanImages = $conn->query($sqlBinhLuanImages);

                        if ($resultBinhLuanImages->num_rows > 0) {
                            while ($rowImage = $resultBinhLuanImages->fetch_assoc()) {
                                echo "<img class='binhluan-image' src='" . $rowImage["hinhAnh"] . "' alt='Hình ảnh bình luận'>";
                            }
                        }


                        echo "</div>";
                    }
                } else {
                    echo "Chưa có bình luận nào cho sân này.";
                }
                
                echo "</div>";
            } else {
                echo "Không tìm thấy thông tin sân bóng.";
            }

            // Đóng kết nối
            $conn->close();
        } else {
            echo "ID không hợp lệ.";
        }
        ?>

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
                <p>Chính sách đặt sân và thanh toán </p>
                <p>Cam kết chất lượng </p>
            </div>
            <div class="footer_right">
                <p><b>HÒM THƯ GÓP Ý</b></p>
                <input type="text" id="text" name="search" placeholder="Nhập thông tin góp ý">                
                <button id="send">Gửi</button>
            </div>
        </div>       
        <div class="license">
            <h3>© Bản quyền thuộc TEAM XTMN </h3>
        </div> 
    </footer>
</body>
</html>
