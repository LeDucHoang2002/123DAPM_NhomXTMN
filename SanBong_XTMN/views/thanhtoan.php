
<?php
include '../header_footer/header_phu.php';
?>

<link rel="stylesheet" href="../styless/thanhtoan.css">
    
    <main class="thanhtoan">
        <h3 class="title">THANH TOÁN</h3>
        <div class="thanhtoan_container">
            <div class="infor">
                <div class="infor_san">            
            <?php
            // Include file phpMyAdmin.php to establish a database connection.
            require_once("../database/phpMyAdmin.php");

            // Check if 'id' is set in the URL.
            if (isset($_GET['id'])) {
                $id = $_GET['id']; // Get the 'id' value from the URL
                
                // Check if the request method is POST.
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Handle POST data
                    if (isset($_POST['duLieuBang'])) {
                        $duLieuBang = json_decode($_POST['duLieuBang'], true);

                        // Create a variable to check if the header has been displayed.
                        $headerDisplayed = false;
                        $totalAmount = 0;
                        foreach ($duLieuBang as $datSan) {
                            $ngayDat = $datSan["Ngày đặt"];
                            $tenSanCon = $datSan["Sân bóng"];
                            $gioBatDau = $datSan["Giờ bắt đầu"];
                            $gioKetThuc = $datSan["Giờ kết thúc"];

                            // Query the database to get information about the chosen pitch (sân con) and its price.
                            $sql = "SELECT sc.loaiSan, sc.gia, sb.tenSan
                            FROM SanBong sb
                            INNER JOIN SanCon sc ON sb.IDsanBong = sc.IDsanBong
                            WHERE sb.IDsanBong = $id";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $loaiSan = $row["loaiSan"];
                                $donGia = $row["gia"];
                                $tensan =$row["tenSan"];

                                if (!$headerDisplayed) {
                                    // Display the header only once.
                                    echo "<b>$tensan</b>";
                                    echo"<div class='div_table'> ";
                                    echo "<table border='1'>";
                                    echo "<tr><th>Ngày đặt</th><th>Sân bóng</th><th>Loại sân</th><th>Giờ bắt đầu</th><th>Giờ kết thúc</th><th>Số giờ thuê</th><th>Đơn giá sân con</th><th>Thành tiền</th></tr>";
                                    echo "</div>";
                                    $headerDisplayed = true;
                                }

                                $soGioThue = strtotime($gioKetThuc) - strtotime($gioBatDau);
                                $soGioThue = $soGioThue / 3600;
                                $thanhTien = $soGioThue * $donGia;

                                echo "<tr>";
                                echo "<td>$ngayDat</td>";
                                echo "<td>$tenSanCon</td>";
                                echo "<td>$loaiSan</td>";
                                echo "<td>$gioBatDau</td>";
                                echo "<td>$gioKetThuc</td>";
                                echo "<td>$soGioThue giờ</td>";
                                echo "<td>$donGia</td>";
                                echo "<td>$thanhTien</td>";
                                echo "</tr>";
                                
                            } else {
                                echo "Không tìm thấy thông tin sân con.";
                            }
                            $totalAmount += $thanhTien;
                        }

                        echo "</table>";                        
                        $conn->close();
                    }
                }
            } else {
                echo "Không có ID được truyền vào trang thanh toán.";
            }

            ?>
                    
                </div>
                <div class="enter_infor">
                    <div class="loinhan">
                        <h4>Lời nhắn</h4>
                        <input type="text">
                    </div>

                    <div class="code">
                        <h4>Nhập mã giảm giá (nếu có)</h4>
                        <input type="text">
                        <button>Áp dụng</button>
                    </div>
                </div>
            </div>      
            <div class="hinhthuc">
                <div class="hinhthucthanhtoan">
                    <h4 class="title">HÌNH THỨC THANH TOÁN</h4>
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
                    <h4 class="title">PHƯƠNG THỨC THANH TOÁN</h4>
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
            <div class="thanhtien">
                    <div class="thanhtien-container">
                        <div class="info">
                            <p class="title">Tổng tiền sân</p>
                            <p class="prince"><?php echo $totalAmount . " VNĐ"; ?></p>
                        </div>
                        <div class="info">
                            <p class="title">Tổng voucher giảm giá</p>
                            <p class="prince">200</p>
                        </div>
                        <div class="info">
                            <p class="title">Tổng thanh toán 20%</p>
                            <p class="prince" style="color:red;">800</p>
                        </div>
                        <div class="info">
                            <p class="title">Còn nợ</p>
                            <p class="prince" style="color:#c7c722;">200</p>
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