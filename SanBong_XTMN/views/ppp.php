<!DOCTYPE html>
<html>
<head>
    <title>Chọn Giờ</title>
</head>
<body>
    <label for="gio1">Chọn giờ thứ nhất:</label>
    <input type="time" id="gio1" name="gio1">

    <label for="gio2">Chọn giờ thứ hai:</label>
    <input type="time" id="gio2" name="gio2">

    <p id="error-message" style="color: red;"></p>

    <script>
        // Lấy các phần tử input
        var gio1Input = document.getElementById("gio1");
        var gio2Input = document.getElementById("gio2");
        var errorMessage = document.getElementById("error-message");

        // Thêm sự kiện người dùng thay đổi giờ
        gio1Input.addEventListener("change", validateTime);
        gio2Input.addEventListener("change", validateTime);

        function validateTime() {
            var gio1Value = gio1Input.value;
            var gio2Value = gio2Input.value;

            // Chuyển đổi chuỗi giờ thành đối tượng Date
            var gio1Date = new Date("1970-01-01T" + gio1Value);
            var gio2Date = new Date("1970-01-01T" + gio2Value);

            // So sánh giờ
            if (gio1Date >= gio2Date) {
                errorMessage.textContent = "Giờ thứ hai phải lớn hơn giờ thứ nhất.";
                gio2Input.value = "";
            } else {
                errorMessage.textContent = "";
            }
        }
    </script>
</body>
</html>
