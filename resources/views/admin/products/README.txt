===============================================
HƯỚNG DẪN QUẢN LÝ SẢN PHẨM ADMIN PANEL
===============================================

GIỚI THIỆU
----------
Hệ thống quản lý sản phẩm giúp Admin quản lý toàn bộ danh sách sản phẩm của cửa hàng.
Các file giao diện được lưu trong thư mục: resources/views/admin/products/

CẤU TRÚC FILE
--------------
1. index.php              - Trang danh sách sản phẩm
2. create.php             - Form thêm sản phẩm mới
3. edit.php               - Form sửa thông tin sản phẩm
4. README.txt             - File hướng dẫn này

CHỨC NĂNG CHI TIẾT
-------------------

1. DANH SÁCH SẢN PHẨM (index.php)
   - Hiển thị danh sách tất cả sản phẩm
   - Cột thông tin: STT, Tên, Danh mục, Giá, Số lượng, Trạng thái
   - Nút chức năng: 
     * Sửa - Chỉnh sửa thông tin sản phẩm
     * Xóa - Chuyển sản phẩm sang trạng thái "Ẩn"
   - Nút "Thêm sản phẩm" ở góc trên phải để tạo sản phẩm mới

2. THÊM SẢN PHẨM (create.php)
   - Form input với các trường:
     * Tên sản phẩm (bắt buộc)
     * Danh mục (bắt buộc)
     * Mô tả chất liệu (tùy chọn)
     * Giá gốc (bắt buộc)
     * Giá giảm (tùy chọn)
     * Số lượng tồn kho (bắt buộc)
     * Trạng thái (Hiển thị/Ẩn)
     * Hình ảnh sản phẩm (tùy chọn)
   - Chức năng:
     * Validation dữ liệu trước khi lưu
     * Preview hình ảnh trước upload
     * Nút "Lưu sản phẩm" để lưu vào database
     * Nút "Hủy" để quay lại danh sách

3. SỬA SẢN PHẨM (edit.php)
   - Tương tự form thêm nhưng điền sẵn dữ liệu hiện tại
   - Hiển thị hình ảnh sản phẩm hiện tại
   - Cho phép tải lên hình ảnh mới (nếu cần)
   - Nút "Cập nhật sản phẩm" để lưu thay đổi

FLOW XỬ LÝ (Use Case)
---------------------

[Use Case 1: Xem danh sách sản phẩm]
1. Admin chọn "Quản lý sản phẩm" từ menu
2. Hệ thống truy xuất dữ liệu từ bảng SAN_PHAM kết hợp DANH_MUC
3. Hiển thị danh sách sản phẩm trên index.php
4. Use case kết thúc

[Use Case 2: Thêm sản phẩm mới]
1. Admin nhấn nút "Thêm sản phẩm" trên index.php
2. Hệ thống chuyển sang trang create.php
3. Admin điền thông tin: tên, danh mục, mô tả, giá, số lượng, trạng thái
4. Admin nhấn "Lưu sản phẩm"
5. Hệ thống validation dữ liệu
6. Hệ thống lưu vào bảng SAN_PHAM
7. Thông báo "Thêm sản phẩm thành công"
8. Tải lại danh sách index.php
9. Use case kết thúc

[Use Case 3: Cập nhật thông tin sản phẩm]
1. Admin nhấn nút "Sửa" bên cạnh sản phẩm cần chỉnh sửa
2. Hệ thống truy xuất dữ liệu sản phẩm từ bảng SAN_PHAM
3. Điền sẵn dữ liệu vào form edit.php
4. Admin thay đổi thông tin cần sửa
5. Admin nhấn "Cập nhật sản phẩm"
6. Hệ thống validation dữ liệu
7. Hệ thống cập nhật bảng SAN_PHAM
8. Thông báo "Cập nhật sản phẩm thành công"
9. Quay lại danh sách index.php
10. Use case kết thúc

[Use Case 4: Xóa/Ẩn sản phẩm]
1. Admin nhấn biểu tượng "Xóa" bên cạnh sản phẩm
2. Hệ thống hiển thị cảnh báo xác nhận
3. Admin chọn "Đồng ý"
4. Thay vì xóa vật lý bản ghi, hệ thống cập nhật trường TRANG_THAI của sản phẩm về 0 (ẩn)
5. Thông báo "Xóa sản phẩm thành công"
6. Tải lại danh sách index.php (sản phẩm không còn hiển thị)
7. Use case kết thúc

BẢNG DỮ LIỆU LIÊN QUAN
----------------------

Bảng SAN_PHAM:
  - id (Primary Key)
  - danhmuc_id (Foreign Key - liên kết DANH_MUC)
  - ten (tên sản phẩm)
  - mota (mô tả chất liệu)
  - gia (giá gốc)
  - giagiam (giá khuyến mại)
  - soluong (số lượng tồn kho)
  - trang_thai (0 = Ẩn, 1 = Hiển thị)
  - hinhanh (đường dẫn ảnh)
  - ngay_tao (ngày tạo)
  - ngay_cap_nhat (ngày cập nhật)

Bảng DANH_MUC:
  - id (Primary Key)
  - ten (tên danh mục)
  - mota (mô tả danh mục)

TÍNH NĂNG BỔ SUNG
------------------
- Validation dữ liệu phía client (JS)
- Preview ảnh trước upload
- Thông báo flash message sau mỗi hành động
- Badges hiển thị trạng thái và danh mục
- Responsive design - hoạt động tốt trên di động
- Xác nhận trước khi xóa/ẩn sản phẩm

LƯU Ý QUAN TRỌNG
-----------------
1. Các file này là template hiển thị (View)
   - Cần kết hợp với PHP backend để xử lý dữ liệu
   - Cần kết nối database để lấy/lưu dữ liệu

2. Form submit sẽ gửi dữ liệu tới các file backend:
   - create.php → products_save.php (xử lý lưu)
   - edit.php → products_update.php (xử lý cập nhật)
   - index.php → products_delete.php (xử lý xóa)

3. Hình ảnh được lưu trong thư mục: public/images/

4. CSS/JS sử dụng từ:
   - vendor/fontawesome-free/ (icon)
   - css/sb-admin-2.min.css (responsive design)
   - css/dataTables.dataTables.min.css (table)

HƯỚNG DẪN SỬ DỤNG
------------------

1. Truy cập giao diện Admin
   - Đăng nhập với tài khoản admin
   - Chọn "Quản lý sản phẩm" từ menu

2. Xem danh sách
   - Trực tiếp thấy danh sách sản phẩm
   - Xem thông tin: tên, danh mục, giá, số lượng, trạng thái

3. Thêm sản phẩm
   - Click nút "Thêm sản phẩm" (góc trên phải)
   - Điền đầy đủ thông tin các trường bắt buộc (*)
   - Chọn danh mục phù hợp
   - Nhập giá và số lượng
   - (Tùy chọn) Tải lên hình ảnh
   - Click "Lưu sản phẩm"

4. Sửa sản phẩm
   - Click nút "Sửa" (biểu tượng bút)
   - Chỉnh sửa thông tin
   - Có thể thay đổi hình ảnh
   - Click "Cập nhật sản phẩm"

5. Xóa sản phẩm
   - Click nút "Xóa" (biểu tượng thùng rác)
   - Xác nhận khi được hỏi
   - Sản phẩm sẽ chuyển sang trạng thái "Ẩn"

===============================================
