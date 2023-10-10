<!DOCTYPE html>
<html>
<head>
    <title>Giao diện đặt sân</title>
    <style>
        .booking-form-container {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Giao diện đặt sân</h1>

    <!-- Nút để hiển thị form đặt sân -->
    <button id="show-booking-form">Đặt sân</button>

    <!-- Form đặt sân -->
    <div class="booking-form-container">
        <!-- Đây là nội dung của form đặt sân -->
        <form method="post" action="#">
            <!-- Thêm các trường nhập liệu và nút để đặt sân ở đây -->
            <label for="ten">Tên:</label>
            <input type="text" name="ten" id="ten">
            <label for="ngay">Ngày:</label>
            <input type="text" name="ngay" id="ngay">
            <label for="gio">Giờ:</label>
            <input type="text" name="gio" id="gio">
            <button type="submit">Xác nhận đặt sân</button>
        </form>
    </div>

    <script>
        // Lấy phần tử DOM của form đặt sân
        var bookingForm = document.querySelector(".booking-form-container");

        // Lấy phần tử DOM của nút "Đặt sân"
        var showBookingButton = document.getElementById("show-booking-form");

        // Thêm sự kiện click cho nút "Đặt sân"
        showBookingButton.addEventListener("click", function() {
            // Hiển thị form đặt sân khi nhấn nút "Đặt sân"
            bookingForm.style.display = "block";
        });
    </script>
</body>
</html>
