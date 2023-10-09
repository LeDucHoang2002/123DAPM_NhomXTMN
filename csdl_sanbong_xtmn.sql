-- Tạo cơ sở dữ liệu QuanLySanBong_XTMN
CREATE DATABASE IF NOT EXISTS QuanLySanBong_XTMN;

-- Sử dụng cơ sở dữ liệu QuanLySanBong_XTMN
USE QuanLySanBong_XTMN;

-- Tạo bảng Quyen
CREATE TABLE IF NOT EXISTS Quyen (
    IDquyen INT AUTO_INCREMENT PRIMARY KEY,
    tenQuyen VARCHAR(50) NOT NULL
);

-- Tạo bảng TaiKhoan
CREATE TABLE IF NOT EXISTS TaiKhoan (
    tenDangNhap VARCHAR(50) PRIMARY KEY,
    tenTaiKhoan VARCHAR(50) NOT NULL,
    soDienThoai VARCHAR(11) NOT NULL,
    matKhau CHAR(50) NOT NULL,
    diaChi VARCHAR(30) NOT NULL,
    avt VARCHAR(200) NULL
);

-- Tạo bảng TaiKhoan_Quyen
CREATE TABLE IF NOT EXISTS TaiKhoan_Quyen (
    tenDangNhap VARCHAR(50) NOT NULL,
    IDquyen INT NOT NULL,
    PRIMARY KEY (tenDangNhap, IDquyen),
    CONSTRAINT FK_TKQ_Q FOREIGN KEY (IDquyen) REFERENCES Quyen(IDquyen),
    CONSTRAINT FK_TKQ_TK FOREIGN KEY (tenDangNhap) REFERENCES TaiKhoan(tenDangNhap)
);

-- Tạo bảng HinhAnh
CREATE TABLE IF NOT EXISTS HinhAnh (
    IDhinhAnh INT AUTO_INCREMENT PRIMARY KEY,
    hinhAnh VARCHAR(200) NOT NULL
);

-- Tạo bảng QuanHuyen
CREATE TABLE IF NOT EXISTS QuanHuyen (
    IDquanHuyen INT AUTO_INCREMENT PRIMARY KEY,
    tenQuanHuyen VARCHAR(50) NOT NULL
);

-- Tạo bảng PhuongXa
CREATE TABLE IF NOT EXISTS PhuongXa (
    IDphuongXa INT AUTO_INCREMENT PRIMARY KEY,
    tenPhuongXa VARCHAR(50) NOT NULL,
    IDquanHuyen INT NOT NULL,
    CONSTRAINT FK_PX_QH FOREIGN KEY (IDquanHuyen) REFERENCES QuanHuyen(IDquanHuyen)
);

-- Tạo bảng SanBong
CREATE TABLE IF NOT EXISTS SanBong (
    IDsanBong INT AUTO_INCREMENT PRIMARY KEY,
    tenSan VARCHAR(200) NOT NULL,
    tenDangNhap VARCHAR(50) NOT NULL,
    IDphuongXa INT NOT NULL,
    hinhAnh VARCHAR(200) NULL,
    moTa VARCHAR(200) NULL,
    dinhVi VARCHAR(200) NULL,
    viTri VARCHAR(200) NOT NULL,
    thoiGianMoCua VARCHAR(200) NOT NULL,
    thoiGianDongCua VARCHAR(200) NOT NULL,
    mucGia VARCHAR(200) NULL,
    CONSTRAINT FK_SB_CSB FOREIGN KEY (tenDangNhap) REFERENCES TaiKhoan(tenDangNhap),
    CONSTRAINT FK_SB_PX FOREIGN KEY (IDphuongXa) REFERENCES PhuongXa(IDphuongXa)
);

-- Tạo bảng SanCon
CREATE TABLE IF NOT EXISTS SanCon (
    IDsanCon INT AUTO_INCREMENT PRIMARY KEY,
    IDsanBong INT NOT NULL,
    tenSanCon VARCHAR(50) NOT NULL,
    loaiSan VARCHAR(20) NOT NULL,
    tinhTrang VARCHAR(50) NOT NULL,
    gia DECIMAL(10, 2) NOT NULL,
    soLuongSao INT,
    moTa VARCHAR(200) NULL,
    CONSTRAINT FK_SC_SB FOREIGN KEY (IDsanBong) REFERENCES SanBong(IDsanBong)
);

-- Tạo bảng SanCon_HinhAnh
CREATE TABLE IF NOT EXISTS SanCon_HinhAnh (
    IDsanCon INT NOT NULL,
    IDhinhAnh INT NOT NULL,
    PRIMARY KEY (IDsanCon, IDhinhAnh),
    CONSTRAINT FK_SCHA_SC FOREIGN KEY (IDsanCon) REFERENCES SanCon(IDsanCon),
    CONSTRAINT FK_SCHA_HA FOREIGN KEY (IDhinhAnh) REFERENCES HinhAnh(IDhinhAnh)
);

-- Tạo bảng BinhLuan
CREATE TABLE IF NOT EXISTS BinhLuan (
    IDbinhLuan INT AUTO_INCREMENT PRIMARY KEY,
    tenDangNhap VARCHAR(50) NOT NULL,
    IDsanCon INT NOT NULL,
    ngayBinhLuan DATETIME NULL,
	danhGiaSao INT NOT NULL,
    noiDung VARCHAR(200) NOT NULL,
    CONSTRAINT FK_BL_ND FOREIGN KEY (tenDangNhap) REFERENCES TaiKhoan(tenDangNhap),
    CONSTRAINT FK_BL_SC FOREIGN KEY (IDsanCon) REFERENCES SanCon(IDsanCon)
);

-- Tạo bảng BinhLuan_HinhAnh
CREATE TABLE IF NOT EXISTS BinhLuan_HinhAnh (
    IDbinhLuan INT NOT NULL,
    IDhinhAnh INT NOT NULL,
    PRIMARY KEY (IDbinhLuan, IDhinhAnh),
    CONSTRAINT FK_BLHA_BL FOREIGN KEY (IDbinhLuan) REFERENCES BinhLuan(IDbinhLuan),
    CONSTRAINT FK_BLHA_HA FOREIGN KEY (IDhinhAnh) REFERENCES HinhAnh(IDhinhAnh)
);

-- Tạo bảng PhieuDatSan
CREATE TABLE IF NOT EXISTS PhieuDatSan (
    IDphieuDatSan INT AUTO_INCREMENT PRIMARY KEY,
    tenDangNhap VARCHAR(50) NOT NULL,
    ngayDat DATETIME NULL,
    trangThai VARCHAR(20) NOT NULL,
    CONSTRAINT FK_PDS_KH FOREIGN KEY (tenDangNhap) REFERENCES TaiKhoan(tenDangNhap)
);

-- Tạo bảng ChiTietDatSan
CREATE TABLE IF NOT EXISTS ChiTietDatSan (
    IDphieuDatSan INT NOT NULL,
    IDsanCon INT NOT NULL,
    gioBatDau VARCHAR(30) NULL,
    gioKetThuc VARCHAR(30) NULL,
    ngayDat VARCHAR(30) NULL,
    ghiChu VARCHAR(200) NULL,
    thanhTien DECIMAL(10, 2) NULL,
    PRIMARY KEY (IDphieuDatSan, IDsanCon),
    CONSTRAINT FK_CTDS_DS FOREIGN KEY (IDphieuDatSan) REFERENCES PhieuDatSan(IDphieuDatSan),
    CONSTRAINT FK_CTDS_SC FOREIGN KEY (IDsanCon) REFERENCES SanCon(IDsanCon)
);

-- Thêm dữ liệu vào bảng Quyen
INSERT INTO Quyen (tenQuyen) VALUES ('Admin'), ('ChuSan'), ('KhachHang');

-- Thêm dữ liệu vào bảng TaiKhoan
INSERT INTO TaiKhoan (tenDangNhap, tenTaiKhoan, soDienThoai, matKhau, diaChi, avt)
VALUES
    ('nguyenvanA', 'Nguyễn Văn A', '0123456789', 'ABC12345', '123 Đường ABC', 'https://tse4.mm.bing.net/th?id=OIP.tS4o_QzG25ntuI90jWWWXQHaHa&pid=Api&P=0&h=180'),
    ('nguyenvanB', 'Nguyễn Văn B', '0987654321', 'hashed_password2', '456 Đường XYZ', 'https://scr.vn/wp-content/uploads/2020/07/%E1%BA%A2nh-c%E1%BA%B7p-%C4%91%E1%BA%B9p-ng%E1%BA%A7u-n%E1%BB%AF.jpg'),
    ('nguyenvanC', 'Nguyễn Văn C', '0112233445', 'hashed_password3', '789 Đường LMN', 'https://scr.vn/wp-content/uploads/2020/08/H%C3%ACnh-avt-Anime.jpg');

-- Thêm dữ liệu vào bảng TaiKhoan_Quyen
INSERT INTO TaiKhoan_Quyen (tenDangNhap, IDquyen)
VALUES ('nguyenvanA', 1), ('nguyenvanB', 2), ('nguyenvanC', 3);

-- Thêm dữ liệu vào bảng HinhAnh
INSERT INTO HinhAnh (hinhAnh) VALUES ('https://noithatre.vn/wp-content/uploads/2022/09/gia-tham-co-nhan-tao-san-bong-03.jpg'), ('https://giaydabongtot.com/wp-content/uploads/2020/07/Gia-lam-san-co-nhan-tao-bong-da-bao-nhieu-tien-3.jpg'), ('https://toplist.vn/images/800px/san-bong-da-mini-truong-dh-tdtt-da-nang-617768.jpg');

-- Thêm dữ liệu vào bảng QuanHuyen
INSERT INTO QuanHuyen (tenQuanHuyen)
VALUES (N'Quận Hải Châu'), (N'Quận Thanh Khê'), (N'Quận Liên Chiểu'), (N'Quận Sơn Trà'), (N'Quận Ngũ Hành Sơn'), (N'Quận Cẩm Lệ');

-- Thêm dữ liệu vào bảng PhuongXa cho Quận Hải Châu, Đà Nẵng
INSERT INTO PhuongXa (tenPhuongXa, IDquanHuyen)
VALUES (N'Phường Thanh Bình', 1), (N'Phường Hải Châu I', 1), (N'Phường Hải Châu II', 1), (N'Phường Hòa Cường Bắc', 1);

-- Thêm dữ liệu vào bảng PhuongXa cho Quận Thanh Khê, Đà Nẵng
INSERT INTO PhuongXa (tenPhuongXa, IDquanHuyen)
VALUES (N'Phường Tam Thuận', 2), (N'Phường An Hải Bắc', 2), (N'Phường An Hải Đông', 2), (N'Phường An Khê', 2);

-- Thêm dữ liệu vào bảng PhuongXa cho Quận Liên Chiểu, Đà Nẵng
INSERT INTO PhuongXa (tenPhuongXa, IDquanHuyen)
VALUES (N'Phường Liên Chiểu', 3), (N'Phường Hòa Hiệp Nam', 3), (N'Phường Hòa Khánh Bắc', 3), (N'Phường Hòa Khánh Nam', 3);

-- Thêm dữ liệu vào bảng PhuongXa cho Quận Sơn Trà, Đà Nẵng
INSERT INTO PhuongXa (tenPhuongXa, IDquanHuyen)
VALUES (N'Phường Thọ Quang', 4), (N'Phường Mỹ An', 4), (N'Phường Phước Mỹ', 4), (N'Phường Hòa Quý', 4);

-- Thêm dữ liệu vào bảng PhuongXa cho Quận Ngũ Hành Sơn, Đà Nẵng
INSERT INTO PhuongXa (tenPhuongXa, IDquanHuyen)
VALUES (N'Phường Hoà Hải', 5), (N'Phường Hoà Quý', 5), (N'Phường Khuê Mỹ', 5), (N'Phường Mỹ Đa', 5);

-- Thêm dữ liệu vào bảng PhuongXa cho Quận Cẩm Lệ, Đà Nẵng
INSERT INTO PhuongXa (tenPhuongXa, IDquanHuyen)
VALUES (N'Phường Khuê Trung', 6), (N'Phường Hòa An', 6), (N'Phường Hòa Phát', 6), (N'Phường Hòa Thọ Tây', 6);

-- Thêm dữ liệu vào bảng SanBong
INSERT INTO SanBong (tenSan, tenDangNhap, IDphuongXa, hinhAnh, moTa, dinhVi, viTri, thoiGianMoCua, thoiGianDongCua, mucGia)
VALUES
    (N'Sân Bóng ABC', 'nguyenvanA', 1, '../image/img_header.jpg', N'Sân bóng 1', N'Sân bóng 1', N'Địa chỉ 1', '08:00 AM', '10:00 PM', '200,000 VND'),
    (N'Sân Bóng XYZ', 'nguyenvanB', 2, 'https://foba.vn/wp-content/uploads/2020/09/Hinh-anh-%E2%80%93-2020-San-Bong-Cu-Chi-Sau-01-Nam-Khai-Thac-1.jpg', N'Sân bóng 2', N'Sân bóng 2', N'Địa chỉ 2', '07:00 AM', '11:00 PM', '250,000 VND'),
    (N'Sân Bóng XTMN', 'nguyenvanC', 3, 'https://chieusangngoaitroi.com/wp-content/uploads/2019/07/Den-chieu-sang-khong-the-thieu-tren-san-bong.jpg', N'Sân bóng 3', N'Sân bóng 3', N'Địa chỉ 3', '09:00 AM', '09:00 PM', '180,000 VND'),
	(N'Sân Bóng HL', 'nguyenvanB', 2, 'http://daithanhgroups.com/upload/images/kinh-doanh(1).jpg', N'Sân bóng 2', N'Sân bóng 2', N'Địa chỉ 2', '07:00 AM', '11:00 PM', '250,000 VND'),
    (N'Sân Bóng HIT', 'nguyenvanC', 3, 'https://toplist.vn/images/800px/san-bong-tri-hai-khu-the-thao-an-phu-619025.jpg', N'Sân bóng 3', N'Sân bóng 3', N'Địa chỉ 3', '09:00 AM', '09:00 PM', '180,000 VND');

-- Thêm dữ liệu vào bảng SanCon
INSERT INTO SanCon (IDsanBong, tenSanCon, loaiSan, tinhTrang, gia, soLuongSao, moTa)
VALUES
    (1, N'Sân Số 1', N'Sân 7 người', N'Sẵn sàng', 150000, 4, N'Sân đẹp, mới sửa chữa'),
    (1, N'Sân Số 2', N'Sân 5 người', N'Sẵn sàng', 120000, 3, N'Sân gần nhà vệ sinh'),
    (2, N'Sân Số 1', N'Sân 7 người', N'Sẵn sàng', 170000, 4, N'Sân đẹp, thoải mái chơi'),
    (3, N'Sân Số 1', N'Sân 5 người', N'Sẵn sàng', 140000, 3, N'Sân lớn, sạch sẽ');

-- Thêm dữ liệu vào bảng SanCon_HinhAnh
INSERT INTO SanCon_HinhAnh (IDsanCon, IDhinhAnh)
VALUES (1, 1), (1, 2), (2, 3), (3, 3);

-- Thêm dữ liệu vào bảng BinhLuan
INSERT INTO BinhLuan (tenDangNhap, IDsanCon,ngayBinhLuan,danhGiaSao, noiDung)
VALUES
    ('nguyenvanA', 1,NOW(),5, N'Sân rất tốt, tôi rất hài lòng'),
    ('nguyenvanB', 1,NOW(),3 ,N'Giá hơi cao nhưng sân đẹp'),
    ('nguyenvanC', 2,NOW(),5, N'Sân này chất lượng tốt, mình sẽ quay lại');

-- Thêm dữ liệu vào bảng BinhLuan_HinhAnh
INSERT INTO BinhLuan_HinhAnh (IDbinhLuan, IDhinhAnh)
VALUES (1, 1), (1, 2), (2, 3), (3, 3);

-- Thêm dữ liệu vào bảng PhieuDatSan
INSERT INTO PhieuDatSan (tenDangNhap, ngayDat, trangThai)
VALUES
    ('nguyenvanA', NOW(), N'Đã xác nhận'),
    ('nguyenvanB', NOW(), N'Chờ xác nhận'),
    ('nguyenvanC', NOW(), N'Đã xác nhận');

-- Thêm dữ liệu vào bảng ChiTietDatSan
INSERT INTO ChiTietDatSan (IDphieuDatSan, IDsanCon, gioBatDau, gioKetThuc, ngayDat, ghiChu, thanhTien)
VALUES
    (1, 1, '09:00 AM', '10:00 AM', '2023-10-10', N'Chơi 7 người', 150000),
    (1, 2, '04:00 PM', '05:00 PM', '2023-10-10', N'Chơi 5 người', 120000),
    (2, 3, '08:00 AM', '09:00 AM', '2023-10-13', N'Chơi 7 người', 170000),
    (3, 1, '07:00 AM', '08:00 AM', '2023-10-10', N'Chơi 5 người', 140000);