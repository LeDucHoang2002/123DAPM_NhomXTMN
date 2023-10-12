<?php
include '../header_footer/header_phu.php';
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styless/profile.css">


<main>
<div class="profile">
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>
        <?php
        if (isset($_GET['tenDangNhap'])){
            $tenDangNhap = $_GET['tenDangNhap'];
            // Thực hiện kết nối CSDL
            require_once("../database/phpMyAdmin.php");

            // Truy vấn SQL để lấy thông tin từ bảng taikhoan
            $sqlTaiKhoan = "SELECT * from taikhoan where tenDangNhap ='$tenDangNhap'";
            $resultTaiKhoan = $conn->query($sqlTaiKhoan);

            if ($resultTaiKhoan->num_rows > 0) {
                $rowTaiKhoan = $resultTaiKhoan->fetch_assoc();
                
                echo '<div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0 border-right">
                        <div class="user-info">
                        <img class="img-profile img-circle img-responsive center-block" src="'. $rowTaiKhoan["avt"] . '" alt="">
                        <ul class="meta list list-unstyled">
                            <li class="name"><h3>' . $rowTaiKhoan["tenTaiKhoan"] . '</h3></li>
                        </ul>
                        </div>
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">Thông tin chung</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-change-password">Đổi mật khẩu</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-update-notifications">Cài đặt thông báo</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-order-field">Đơn đặt sân</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-history-order-field">Lịch sử đặt sân</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-notifications">Thông báo</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    <img src="'. $rowTaiKhoan["avt"] . '" class="d-block ui-w-80">
                                    <div class="media-body ml-4">
                                    <form method="POST" enctype="multipart/form-data" id="avatarForm">
                                        <label class="btn btn-outline-primary">
                                            Upload new photo
                                            <input type="file" class="account-settings-fileinput">
                                        </label> &nbsp;
                                        <button type="button" class="btn btn-default md-btn-flat">Reset</button>
                                        <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </form>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Tên đăng nhập</label>
                                        <input type="text" class="form-control mb-1" value="'. $rowTaiKhoan["tenDangNhap"] . '">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tên tài khoản</label>
                                        <input type="text" class="form-control" value="'. $rowTaiKhoan["tenTaiKhoan"] . '">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control mb-1" value="'. $rowTaiKhoan["soDienThoai"] . '">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Địa chỉ</label>
                                        <input type="text" class="form-control" value="'. $rowTaiKhoan["diaChi"] . '">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password" class="form-control"  value="'. $rowTaiKhoan["matKhau"] . '">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nhập lại mật khẩu mới</label>
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-update-notifications">
                                <div class="card-body pb-2">
                                    <h5 class="mb-4">Cài đặt thông báo</h5>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">
                                                <b>Cập nhật đơn đăt sân </b></br>
                                                Thông báo khi có cập nhật về đơn đặt sân của tôi, bao gồm cả việc cập nhật thanh toán.
                                            </span>
                                        </label>
                                    </div>                                                
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-order-field">
                                <p>don dat san</p>
                            </div>
                            <div class="tab-pane fade" id="account-history-order-field">
                                
                            </div>
                            <div class="tab-pane fade" id="account-notifications">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Activity</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone comments on my article</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone answers on my forum
                                                thread</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone follows me</span>
                                        </label>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Application</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">News and announcements</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly product updates</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly blog digest</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
                
            }
        }
        
        
        ?>
        <div class="text-right mt-3">
            <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
            <button type="button" class="btn btn-default">Cancel</button>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="../js/profile.js"></script>
    </div>
</main>


    <?php
include '../header_footer/footer.php';
?>