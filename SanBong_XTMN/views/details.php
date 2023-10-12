<?php
include '../header_footer/header_phu.php';
?>
    
    <main class="trangchu">
            
    <script>
    // Sử dụng JavaScript để theo dõi sự kiện nhấn nút "Đặt sân"
    document.addEventListener('DOMContentLoaded', function () {
        const bookButton = document.querySelector('[data-show-form="true"]');
        if (bookButton) {
            bookButton.addEventListener('click', function (e) {
                e.preventDefault(); // Ngăn chặn chuyển hướng mặc định
                document.querySelector('.booking-form-container').style.display = 'block'; // Hiển thị form
            });
        }
    });
    </script>

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
                        echo"<input type='date' id='date' name='date' min='" . date('Y-m-d') . "'>";
                        echo"<input type='submit' id='Xem' value='Xem sân'>";
                    echo"</form>";        
                echo"</div>"; 
                echo "<div class='sancon-info-button'>";
                    if (isset($_SESSION["username"])) {
                        // Nếu người dùng đã đăng nhập, thêm một thuộc tính để xác định việc hiển thị
                        echo "<button id='show-booking-form'>Đặt sân</button>";
                    } else {
                        // Nếu người dùng chưa đăng nhập, chuyển hướng tới trang đăng nhập
                        echo "<a href='log_in.php'><button>Đặt sân</button></a>";
                    }                    
                    echo "<button id='exit-booking-form'>Hủy</button>";
                echo "</div>";   
                ?>
                <div class="booking-form-container">
                    <div class="thongTinDatSan">
                        <!-- Form để nhập dữ liệu -->
                        <form method="POST" action="thanhtoan.php">
                            <h4>Thông Tin Đặt Sân</h4>
                            <b for="gioDatSan"> Ngày đặt sân:</b>
                            <input type="date" id="ngayChon" min="<?php echo date('Y-m-d'); ?>">
                            <b for="tenSanCon"> Sân bóng:</b>
                            <select name="tenSanCon" id="tenSanCon">
                                <?php
                                // Truy vấn dữ liệu từ bảng SanCon để hiển thị trong combobox
                                $sql = "SELECT * FROM SanCon where IDsanBong=$id";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["tenSanCon"] . "'>" . $row["tenSanCon"] . "</option>";
                                    }
                                } else {
                                    echo "Không có dữ liệu sân bóng.";
                                }
                                ?>
                            </select>
                            <b for="gioDatSan"> Giờ bắt đầu:</b>
                            <input type="text" name="gioDatSan" id="gioDatSan" placeholder="Nhập kiểu 08:00">
                            <b for="gioKetThuc"> Giờ kết thúc:</b>
                            <input type="text" id="gioKetThuc" name="gioKetThuc" placeholder="Nhập kiểu 08:00">
                            <input type="button" value="Thêm" id="them-button">
                        </form>
                    </div>
                    
                    <!-- Bảng Dữ liệu -->
                    <table border="1" id="du-lieu-table">
                        <tr><th>Ngay đặt</th>
                            <th>Sân bóng</th>
                            <th>Giờ bắt đầu</th>
                            <th>Giờ kết thúc</th>
                            <th>Chỉnh sửa</th>
                        </tr>
                    </table>
                    <div class="xacNhanDatSan">
                        <!-- Nút để chuyển dữ liệu sang trang thanhtoan.php -->
                        <?php
                        $id = $_GET['id']; // Thay đổi giá trị này thành giá trị thực tế của id
                        ?>

                        <form method="POST" action="thanhtoan.php?id=<?php echo $id; ?>">
                            <input type="hidden" name="duLieuBang" id="duLieuBangInput">
                            <button type="submit" id="xacNhanDatSan">Đặt Sân</button>
                        </form>

                    </div>
                    <script>
                        // ...
                        // Sự kiện khi nhấn nút "Đặt Sân"
                    document.getElementById("xacNhanDatSan").addEventListener("click", function() {
                        if (du_lieu.length > 0) {
                            // Có dữ liệu trong mảng, gửi dữ liệu đó đến trang thanh toán
                            var duLieuBangInput = document.getElementById("duLieuBangInput");
                            duLieuBangInput.value = JSON.stringify(du_lieu);
                        } else {
                            // Không có dữ liệu trong mảng, không thực hiện hành động gì
                            event.preventDefault(); // Ngăn chặn việc gửi form
                            alert("Không có dữ liệu để đặt sân.");
                        }
                    });

                    </script>
    
                    <script>
                    // Khởi tạo một mảng để lưu trữ dữ liệu
                    var du_lieu = [];

                    // Lấy các phần tử DOM 

                    var ngayChonInput = document.getElementById("ngayChon");
                    var tenSanConInput = document.getElementById("tenSanCon");
                    var gioDatSan = document.getElementById("gioDatSan");
                    var gioKetThuc = document.getElementById("gioKetThuc");
                    var themButton = document.getElementById("them-button");
                    var duLieuTable = document.getElementById("du-lieu-table");
                    
                    // Sự kiện khi nhấn nút "Thêm"
                    themButton.addEventListener("click", function() {
                        var ngayChon = ngayChonInput.value;
                        var tenSanCon = tenSanConInput.value;
                        var gioDat = gioDatSan.value;
                        var gioXong = gioKetThuc.value;

                        // Chuyển đổi số giờ thành chuỗi kiểu giờ 24 giờ
                        var gioDat24 = gioDat.toString().padStart(2, '0') + ":00";
                        var gioXong24 = gioXong.toString().padStart(2, '0') + ":00";
                        <?php
                        
                        // Truy vấn dữ liệu từ bảng SanBong để hiển thị trong combobox
                        $sql = "SELECT * FROM SanBong where IDsanBong=$id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $gioMoCua = $row["thoiGianMoCua"];
                            $gioDongCua = $row["thoiGianDongCua"];
                            echo "var gioMoCua = '" . $gioMoCua . "';";
                            echo "var gioDongCua = '" . $gioDongCua . "';";
                        } 
                        ?>
                        // Kiểm tra nếu giờ bắt đầu và số giờ thuê không trống
                        if (ngayChon.trim() !== ""&&tenSanCon.trim() !== ""&&gioDat.trim() !== "" && gioXong.trim() !== "") {
                            if ( gioDat24 >= gioMoCua &&  gioDat24 <= gioXong24 && gioXong24 <= gioDongCua) {
                                if (gioDat24==gioXong24) {
                                    
                                    alert("Không được để trống thông tin.");
                                }else{
                                    // Kiểm tra nếu ngày đặt và tên sân con trùng với bất kỳ bản ghi nào trong mảng
                                    var trungLich = du_lieu.some(function(row) {
                                        return row["Ngày đặt"] === ngayChon && row["Sân bóng"] === tenSanCon;
                                    });

                                    if (trungLich) {
                                        // Nếu trùng ngày và tên sân con, kiểm tra giờ bắt đầu và giờ kết thúc
                                        var trungGio = du_lieu.some(function(row) {
                                            var gioBatDauDaDat = row["Giờ bắt đầu"];
                                            var gioKetThucDaDat = row["Giờ kết thúc"];

                                            if (
                                                (gioBatDauDaDat<gioDat24 && gioDat24 < gioKetThucDaDat) ||
                                                (gioBatDauDaDat<gioXong24 && gioXong24 < gioKetThucDaDat)||
                                                (gioDat24<gioBatDauDaDat && gioKetThucDaDat<gioXong24)
                                            ) {
                                                return true;
                                            }
                                        });

                                        if (trungGio) {
                                            alert("Trùng lịch cho ngày "+ngayChon +", "+tenSanCon+".");
                                        } else {
                                            // Thêm dữ liệu vào mảng và cập nhật bảng
                                            du_lieu.push({ "Ngày đặt": ngayChon, "Sân bóng": tenSanCon, "Giờ bắt đầu": gioDat, "Giờ kết thúc": gioXong });
                                            capNhatBang();
                                            ngayChonInput.value = "";
                                            tenSanConInput.value = "";
                                            gioDatSan.value = "";
                                            gioKetThuc.value = "";
                                        }
                                    } else {
                                        // Nếu không trùng ngày và tên sân con, thêm dữ liệu vào mảng và cập nhật bảng
                                        du_lieu.push({ "Ngày đặt": ngayChon, "Sân bóng": tenSanCon, "Giờ bắt đầu": gioDat, "Giờ kết thúc": gioXong });
                                        capNhatBang();
                                        ngayChonInput.value = "";
                                        tenSanConInput.value = "";
                                        gioDatSan.value = "";
                                        gioKetThuc.value = "";
                                    }
                                }
                            
                            }else {                                
                                alert("Giờ đặt phải trể hơn "+gioMoCua+" và sớm hơn "+gioDongCua +".");
                                }   
                        } else {
                            alert("Vui lòng nhập giờ bắt đầu và số giờ thuê.");
                        }
                    });

                    function kiemTraGioTonTai(ngayChon, tenSanCon, gioBatDau, gioKetThuc) {
                    var xhr = new XMLHttpRequest();
                    var url = "../database/kiem_tra_gio.php"; // Thay đổi thành tên tệp PHP xử lý kiểm tra giờ

                    // Đảm bảo sử dụng dấu & để ngăn cách các tham số và sử dụng "=" để gán giá trị.
                    var params = "ngayChon=" + ngayChon + "&tenSanCon=" + tenSanCon + "&gioBatDau=" + gioBatDau + "&gioKetThuc=" + gioKetThuc;

                    xhr.open("POST", url, true);

                    // Gửi yêu cầu với dữ liệu thông qua phương thức POST
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = xhr.responseText;
                            if (response === "true") {
                                // Giờ đã tồn tại
                                return true;
                            } else {
                                // Giờ chưa tồn tại
                                return false;
                            }
                        }
                    }

                    xhr.send(params);
                }

                    // Hàm cập nhật bảng
                    function capNhatBang() {
                        while (duLieuTable.rows.length > 1) {
                            duLieuTable.deleteRow(1);
                        }
                        du_lieu.forEach(function(row, index) {
                            var newRow = duLieuTable.insertRow(-1);
                            var cell1 = newRow.insertCell(0);
                            var cell2 = newRow.insertCell(1);
                            var cell3 = newRow.insertCell(2);
                            var cell4 = newRow.insertCell(3);
                            var cell5 = newRow.insertCell(4);
                            cell1.innerHTML = row["Ngày đặt"];
                            cell2.innerHTML = row["Sân bóng"];
                            cell3.innerHTML = row["Giờ bắt đầu"];
                            cell4.innerHTML = row["Giờ kết thúc"];
                            cell5.innerHTML = '<button onclick="chinhSuaHang(' + index + ')">Chỉnh sửa</button>';
                        });
                    }

                    // Hàm chỉnh sửa hàng
                    function chinhSuaHang(index) {
                        ngayChonInput.value = du_lieu[index]["Ngày đặt"];
                        tenSanConInput.value = du_lieu[index]["Sân bóng"];
                        gioDatSan.value = du_lieu[index]["Giờ bắt đầu"];
                        gioKetThuc.value = du_lieu[index]["Giờ kết thúc"];

                        // Xóa hàng sau khi chọn để chỉnh sửa
                        du_lieu.splice(index, 1);
                        capNhatBang();
                    }
                </script>

                </div>
                <script>
                    // Lấy phần tử DOM của form đặt sân
                    var bookingForm = document.querySelector(".booking-form-container");
                    var showbookingForm = document.querySelector("#show-booking-form");
                    var exitbookingForm = document.querySelector("#exit-booking-form");

                    // Lấy phần tử DOM của nút "Đặt sân"
                    var showBookingButton = document.getElementById("show-booking-form");

                    // Thêm sự kiện click cho nút "Đặt sân"
                    showBookingButton.addEventListener("click", function() {
                        // Hiển thị form đặt sân khi nhấn nút "Đặt sân"
                        bookingForm.style.display = "block";
                        showbookingForm.style.display = "none";
                        exitbookingForm.style.display = "block";
                    });// tắt phần tử DOM của form đặt sân
                    var bookingForm = document.querySelector(".booking-form-container");
                    var showbookingForm = document.querySelector("#show-booking-form");
                    var exitbookingForm = document.querySelector("#exit-booking-form");

                    // Lấy phần tử DOM của nút "Đặt sân"
                    var showBookingButton = document.getElementById("exit-booking-form");

                    // Thêm sự kiện click cho nút "Đặt sân"
                    showBookingButton.addEventListener("click", function() {
                        // Hiển thị form đặt sân khi nhấn nút "Đặt sân"
                        bookingForm.style.display = "none";
                        showbookingForm.style.display = "block";
                        exitbookingForm.style.display = "none";
                        du_lieu = []; // Xoá toàn bộ dữ liệu
                        capNhatBang();
                    });
                </script>
                <?php // Đầu tiên, tạo một div container cho sân con
                
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
    <?php
include '../header_footer/footer.php';
?>
