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
    echo "<tr><th>Sân bóng</th><th>Giờ bắt đầu</th><th>Số giờ thuê</th></tr>";
    foreach ($duLieuMang as $hang) {
        echo "<tr>";
        echo "<td>" . $hang["Sân bóng"] . "</td>";
        echo "<td>" . $hang["Giờ bắt đầu"] . "</td>";
        echo "<td>" . $hang["Số giờ"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // Nếu không có dữ liệu gửi đến, bạn có thể xử lý điều này hoặc hiển thị thông báo lỗi
    echo "Không có dữ liệu đặt sân được gửi đến.";
}
?>
