<?php
include '../header_footer/header_phu.php';
?>

<link rel="stylesheet" href="../styless/thanhtoan.css">
    <main class="thanh toan">
    
        <div class="thanhtoan_container">
            <div class="thongtin">
            <h4 class="title">1. THÔNG TIN THANH TOÁN</h4>
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
            </div>
            <div class="hinhthuc">
                <div class="hinhthucthanhtoan">
                    <h4 class="title">2. HÌNH THỨC THANH TOÁN</h4>
                    <div class="option_hinhthuc">
                        <div class="option">
                            <input name="hinhthuc" type="radio"/> Thanh toán tất cả
                        </div>
                        <div class="option">
                            <input name="hinhthuc" type="radio"/> Đặt cọc (20% tổng giá trị đơn đặt hàng) Phần còn lại sẽ thanh toán khi nhận sân
                        </div>                                       
                    </div>
                    
                </div>
                <div class="phuongthucthanhtoan">
                    <h4 class="title">3.PHƯƠNG THỨC THANH TOÁN</h4>
                    <div class="option_phuongthuc">
                        <div class="option">
                            <input name="phuongthuc" type="radio"/> Chuyển khoản ngân hàng 
                        </div>
                        <div class="option">
                            <input name="phuongthuc" type="radio"/> Quét mã QR MoMo
                            <img class="logo" src="../image/MoMo_Logo.png" alt="momo">
                        </div>  
                        <div class="option">
                            <input name="phuongthuc" type="radio"/> Quét mã QR ZaloPay 
                            <img class="logo" src="../image/zalo.jpg" alt="zalo">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="btn_thanhtoan">
            <button>THANH TOÁN</button>
        </div>

    </main>
    
    <?php
include '../header_footer/footer.php';
?>