<?php

require_once("phpMyAdmin.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ngayChon"])&& isset($_POST["tenSanCon"])&& isset($_POST["gioBatDau"]) && isset($_POST["gioKetThuc"])) {
    $ngayChon = $_POST["ngayChon"];
    $tenSanCon = $_POST["tenSanCon"];
    $gioBatDau = $_POST["gioBatDau"];
    $gioKetThuc = $_POST["gioKetThuc"];

    // Thực hiện truy vấn CSDL kiểm tra giờ
    // Thay thế phần này bằng truy vấn CSDL thực tế
    $giờTồnTại = kiemTraGioTonTaiTrongCSDL($ngayChon,$tenSanCon,$gioBatDau, $gioKetThuc);

    if ($giờTồnTại) {
        echo "true";
    } else {
        echo "false";
    }
}

function kiemTraGioTonTaiTrongCSDL($ngayChon,$tenSanCon,$gioBatDau, $gioKetThuc) {
    $sql = "SELECT COUNT(*) AS ton_tai FROM chitietdatsan
            JOIN sancon ON chitietdatsan.IDsanCon = sancon.IDsanCon
            JOIN sanbong ON sancon.IDsanBong = sanbong.IDsanBong
            WHERE sanbong.IDsanBong = 1
            AND sancon.tenSanCon = 'Sân Số 1'
            AND chitietdatsan.ngayDat = '2023-10-13'
            AND (
                (chitietdatsan.gioBatDau < '08:00' AND '08:00' < chitietdatsan.gioKetThuc)
                OR (chitietdatsan.gioBatDau < '10:00' AND '10:00' < chitietdatsan.gioKetThuc)
            )";

    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $tonTai = $row["ton_tai"];
        return $tonTai > 0;
    }

    return false;
}
?>
