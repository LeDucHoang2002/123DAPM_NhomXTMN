<?php
include '../header_footer/header.php';
?>
    
    <main class="trangchu">
        
    <h2>Sân Bóng Đà Nẵng</h2>
        <div class="trangchu_main">
            <div id="searchResults" class="search-results">
        <!-- Kết quả tìm kiếm sẽ được hiển thị ở đây -->
            </div>
            <script>
                // Lắng nghe sự kiện click trên nút "Tìm kiếm"
                document.querySelector("button").addEventListener("click", function() {
                    performSearch();
                });

                // Tự động thực hiện tìm kiếm mặc định khi trang web được tải
                window.addEventListener("load", function() {
                    performSearch();
                });

                function performSearch() {
                    const selectedDistrict = document.getElementById("district").value;
                    const selectedWard = document.getElementById("ward").value;
                    const searchTerm = document.getElementById("search").value;

                    // Gửi yêu cầu Ajax để tìm kiếm dựa trên selectedDistrict, selectedWard và searchTerm
                    // Sử dụng Fetch API để gửi yêu cầu
                    fetch(`../database/search.php?district=${selectedDistrict}&ward=${selectedWard}&search=${searchTerm}`)
                        .then(response => response.text())
                        .then(data => {
                            // Hiển thị kết quả tìm kiếm ở phần tử searchResults
                            document.getElementById("searchResults").innerHTML = data;
                        });
                }
                
            </script>

            
        </div>           
    </main>
    <?php
include '../header_footer/footer.php';
?>
