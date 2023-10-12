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
// Kiểm tra xem có dữ liệu đã được gửi từ biểu mẫu không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ trường ẩn
    $duLieuBang = $_POST["duLieuBang"];

    // Chuyển dữ liệu từ chuỗi JSON thành mảng PHP
    $duLieuMang = json_decode($duLieuBang, true);

    // Bạn có thể truy cập và xử lý $duLieuMang ở đây
    // Ví dụ: Hiển thị thông tin từ bảng
    echo "<h4>Thông Tin Đặt Sân</h4>";
    echo "<table border='1'>";
    echo "<tr><th>Ngày đặt</th><th>Sân bóng</th><th>Giờ bắt đầu</th><th>Giờ kết thúc</th></tr>";
    foreach ($duLieuMang as $hang) {
        echo "<tr>";
        echo "<td>" . $hang["Ngày đặt"] . "</td>";
        echo "<td>" . $hang["Sân bóng"] . "</td>";
        echo "<td>" . $hang["Giờ bắt đầu"] . "</td>";
        echo "<td>" . $hang["Giờ kết thúc"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // Nếu không có dữ liệu gửi đến, bạn có thể xử lý điều này hoặc hiển thị thông báo lỗi
    echo "Không có dữ liệu đặt sân được gửi đến.";
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
<!DOCTYPE html>
<html>
<head>
    <title>Trang Web PHP</title>
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h4>Thông Tin Đặt Sân</h4>
        <b for="gioDatSan"> Ngày đặt sân:</b>
        <input type="date" id="ngayChon" name="ngayChon" min="<?php echo date('Y-m-d'); ?>">
        <b for="tenSanCon"> Sân bóng:</b>
        <input type="text" name="tenSanCon" id="tenSanCon" placeholder="Nhập kiểu 08:00">
        <b for="gioDatSan"> Giờ bắt đầu:</b>
        <input type="text" name="gioDatSan" id="gioDatSan" placeholder="Nhập kiểu 08:00">
        <b for="gioKetThuc"> Giờ kết thúc:</b>
        <input type="text" id="gioKetThuc" name="gioKetThuc" placeholder="Nhập kiểu 08:00">
        <input type="button" value="Thêm" id="them-button">
        <input type="submit" value="Gửi">
    </form>

    <?php
    
    require_once("../database/phpMyAdmin.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ngayChon = "";
        $tenSanCon = "";
        $gioDat24 = "";
        $gioXong24 = "";
        $gioTonTai = '0';

        if (isset($_POST["ngayChon"]) && isset($_POST["tenSanCon"]) && isset($_POST["gioDatSan"]) && isset($_POST["gioKetThuc"])) {
            $ngayChon = $_POST["ngayChon"];
            $tenSanCon = $_POST["tenSanCon"];
            $gioDat24 = $_POST["gioDatSan"];
            $gioXong24 = $_POST["gioKetThuc"];

            $sqlCheckReservation = "SELECT chitietdatsan.* FROM chitietdatsan
                JOIN sancon ON chitietdatsan.IDsanCon = sancon.IDsanCon
                JOIN sanbong ON sancon.IDsanBong = sanbong.IDsanBong
                WHERE sanbong.IDsanBong = 1
                AND sancon.tenSanCon= '$tenSanCon'
                AND chitietdatsan.ngayDat='$ngayChon'
                AND (
                (gioBatDau < '$gioDat24' AND '$gioDat24' < gioKetThuc)
                OR (gioBatDau < '$gioXong24' AND '$gioXong24' < gioKetThuc)
                )";

            $resultCheckReservation = $conn->query($sqlCheckReservation);

            if ($resultCheckReservation->num_rows > 0) {
                $gioTonTai = '1';
            } 
        }
    }
    ?>
    
    <?php
    if (!empty($gioTonTai)) {
        echo "Giá trị gioTonTai: " . $gioTonTai;
    }else{
        echo "Giá trị gioTonTai: " . $gioTonTai;
    }
    ?>
</body>
</html>

