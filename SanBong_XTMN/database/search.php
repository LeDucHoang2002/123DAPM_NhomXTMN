<?php
// Thực hiện kết nối CSDL
require_once("phpMyAdmin.php");

// Nhận các tham số từ yêu cầu tìm kiếm
$selectedDistrict = $_GET['district'];
$selectedWard = $_GET['ward'];
$searchTerm = $_GET['search'];

// Xử lý và tạo truy vấn SQL dựa trên các tham số
$sql = "SELECT SanBong.IDsanBong, phuongxa.tenPhuongXa, hinhAnh, tenSan, thoiGianMoCua, thoiGianDongCua, mucGia, AVG(BinhLuan.danhGiaSao) AS trungBinhSao 
        FROM SanBong
        LEFT JOIN phuongxa ON SanBong.IDphuongXa = phuongxa.IDphuongXa
        LEFT JOIN sancon ON SanBong.IDsanBong = sancon.IDsanBong
        LEFT JOIN BinhLuan ON sancon.IDsanCon = BinhLuan.IDsanCon 
        LEFT JOIN quanhuyen ON quanhuyen.IDquanHuyen = phuongxa.IDquanHuyen ";

if (!empty($selectedDistrict) || !empty($selectedWard) || !empty($searchTerm)) {
    $sql .= "WHERE ";
}

if (!empty($selectedDistrict)) {
    $sql .= "phuongxa.IDquanHuyen = " . $selectedDistrict;
}

if (!empty($selectedWard)) {
    if (!empty($selectedDistrict)) {
        $sql .= " AND ";
    }
    $sql .= "SanBong.IDphuongXa = " . $selectedWard;
}

if (!empty($searchTerm)) {
    if (!empty($selectedDistrict) || !empty($selectedWard)) {
        $sql .= " AND ";
    }
    $sql .= "tenSan LIKE '%" . $searchTerm . "%'";
}


$sql .= " GROUP BY SanBong.IDsanBong";
$result = $conn->query($sql);

// Tạo HTML để hiển thị kết quả tìm kiếm
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Tạo HTML để hiển thị thông tin sân bóng
        echo '<div class="stadium">';
        echo '<div class="stadium1">';
        echo '<a href="details.php?id=' . $row["IDsanBong"] . '" class="book-button">Xem chi tiết</a>';
        
        echo '</div>';
        // ...
        // Thêm mã HTML để hiển thị thông tin sân bóng ở đây
        echo '<img class="img_stadium" src="' . $row["hinhAnh"] . '" alt="Hình ảnh sân bóng">';
            echo '<div class="data_stadium">';
                echo '<b>' . $row["tenSan"] . ' / '. round($row["trungBinhSao"], 1) . '<img src="../image/icons8-star-30.png" alt=""></b>';
                echo '<p><b>Địa chỉ:</b> ' . $row["tenPhuongXa"] . '</p>';
                echo '<p><b>Mở cửa:</b> ' . $row["thoiGianMoCua"] .' <b>-</b> ' . $row["thoiGianDongCua"] .  '</p>';
                echo '<p class="money">Giá: ' . $row["mucGia"] . '</p>';                   
            echo '</div>';
        // ...
        echo '</div>';

    }
} else {
    echo "Không tìm thấy kết quả phù hợp.";
}

// Đóng kết nối
$conn->close();
?>
