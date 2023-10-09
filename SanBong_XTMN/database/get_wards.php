<?php
// Thực hiện kết nối CSDL
require_once("phpMyAdmin.php");

// Lấy ID quận/huyện từ yêu cầu AJAX
$districtId = $_GET['district_id'];

// Truy vấn SQL để lấy danh sách phường/xã dựa trên ID quận/huyện
$queryWards = "SELECT * FROM PhuongXa WHERE IDquanHuyen = $districtId";
$resultWards = $conn->query($queryWards);

// Tạo mảng để lưu trữ danh sách phường/xã
$wards = array();

// Lặp qua các dòng dữ liệu từ truy vấn phường/xã và thêm vào mảng
while ($rowWard = $resultWards->fetch_assoc()) {
    $wards[] = $rowWard;
}

// Trả về danh sách phường/xã dưới dạng JSON
echo json_encode($wards);

// Đóng kết nối CSDL
$conn->close();
?>
