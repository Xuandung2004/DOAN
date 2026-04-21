<?php include __DIR__ . "/../includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Thông báo Flash Message -->
    <?php if(isset($_SESSION['thongbao'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?php echo $_SESSION['thongbao']; unset($_SESSION['thongbao']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['loi'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $_SESSION['loi']; unset($_SESSION['loi']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle mr-2"></i> Thêm Sản phẩm mới
        </h1>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin sản phẩm</h6>
        </div>
        <div class="card-body">
            <form action="products_save.php" method="POST" enctype="multipart/form-data" id="formProduct">
                <div class="row">
                    <!-- Cột trái: Thông tin cơ bản -->
                    <div class="col-md-8">

                        <!-- Tên sản phẩm -->
                        <div class="form-group">
                            <label for="ten" class="font-weight-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="ten" name="ten" 
                                   placeholder="Nhập tên sản phẩm" required>
                            <small class="form-text text-muted">Nhập tên sản phẩm đầy đủ</small>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="danhmuc" class="font-weight-bold">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control form-control-lg" id="danhmuc" name="danhmuc" required>
                                <option value="">-- Chọn danh mục --</option>
                                <option value="1">Danh mục 1</option>
                                <option value="2">Danh mục 2</option>
                                <option value="3">Danh mục 3</option>
                            </select>
                        </div>

                        <!-- Mô tả chất liệu / Mô tả -->
                        <div class="form-group">
                            <label for="mota" class="font-weight-bold">Mô tả chất liệu</label>
                            <textarea class="form-control" id="mota" name="mota" rows="4" 
                                      placeholder="Nhập mô tả chất liệu sản phẩm"></textarea>
                        </div>

                    </div>

                    <!-- Cột phải: Giá và số lượng -->
                    <div class="col-md-4">

                        <!-- Giá gốc -->
                        <div class="form-group">
                            <label for="gia" class="font-weight-bold">Giá gốc (đ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg" id="gia" name="gia" 
                                   placeholder="0" min="0" step="1000" required>
                        </div>

                        <!-- Giá giảm -->
                        <div class="form-group">
                            <label for="giagiam" class="font-weight-bold">Giá giảm (đ)</label>
                            <input type="number" class="form-control form-control-lg" id="giagiam" name="giagiam" 
                                   placeholder="0" min="0" step="1000">
                            <small class="form-text text-muted">Để trống nếu không có giảm giá</small>
                        </div>

                        <!-- Số lượng -->
                        <div class="form-group">
                            <label for="soluong" class="font-weight-bold">Số lượng tồn kho <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg" id="soluong" name="soluong" 
                                   placeholder="0" min="0" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="trangthai" class="font-weight-bold">Trạng thái</label>
                            <select class="form-control form-control-lg" id="trangthai" name="trangthai">
                                <option value="1" selected>Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Hình ảnh -->
                <div class="form-group">
                    <label for="hinhanh" class="font-weight-bold">Hình ảnh sản phẩm</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="hinhanh" name="hinhanh" accept="image/*">
                        <label class="custom-file-label" for="hinhanh">Chọn file hình ảnh...</label>
                    </div>
                    <small class="form-text text-muted d-block mt-2">
                        Định dạng: JPG, PNG. Kích thước tối đa: 2MB
                    </small>
                    <div id="imagePreview" class="mt-3"></div>
                </div>

                <hr>

                <!-- Nút hành động -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg mr-2">
                        <i class="fas fa-save mr-2"></i> Lưu sản phẩm
                    </button>
                    <a href="index.php" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times mr-2"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
    // Preview hình ảnh
    document.getElementById('hinhanh').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.maxWidth = '200px';
                img.style.border = '2px solid #4e73df';
                img.style.borderRadius = '4px';
                img.style.marginTop = '10px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Cập nhật label
    document.getElementById('hinhanh').addEventListener('change', function() {
        const label = document.querySelector('.custom-file-label');
        label.textContent = this.files.length > 0 ? this.files[0].name : 'Chọn file hình ảnh...';
    });

    // Validation form
    document.getElementById('formProduct').addEventListener('submit', function(e) {
        const ten = document.getElementById('ten').value.trim();
        const danhmuc = document.getElementById('danhmuc').value;
        const gia = document.getElementById('gia').value;
        const soluong = document.getElementById('soluong').value;

        if (!ten || !danhmuc || !gia || !soluong) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ các trường bắt buộc (*)');
            return false;
        }

        if (gia < 0 || soluong < 0) {
            e.preventDefault();
            alert('Giá và số lượng phải lớn hơn 0');
            return false;
        }
    });
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
