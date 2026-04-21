@include('layouts.header')

<section id="profile" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Thông tin cá nhân</h1>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <img src="https://via.placeholder.com/120" alt="Avatar" class="rounded-circle"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <h5 class="card-title mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small mb-4">{{ auth()->user()->email }}</p>
                        <button class="btn btn-outline-secondary w-100 mb-2">Thay đổi ảnh</button>
                    </div>
                </div>

                <div class="list-group mt-4 sticky-top" style="top: 20px;">
                    <a href="#thong-tin" class="list-group-item list-group-item-action active profile-tab-btn"
                        data-tab="thong-tin">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path
                                d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z">
                            </path>
                        </svg>
                        Thông tin tài khoản
                    </a>
                    <a href="#dia-chi" class="list-group-item list-group-item-action profile-tab-btn"
                        data-tab="dia-chi">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="me-2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Địa chỉ giao hàng
                    </a>
                    <a href="#mat-khau" class="list-group-item list-group-item-action profile-tab-btn"
                        data-tab="mat-khau">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path
                                d="M19 8h-1V6a6 6 0 0 0-12 0v2H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V11a3 3 0 0 0-3-3zm-7 8a2 2 0 1 1 2-2a2 2 0 0 1-2 2zm4-9H8V6a4 4 0 0 1 8 0z">
                            </path>
                        </svg>
                        Thay đổi mật khẩu
                    </a>
                    <a href="#don-hang" class="list-group-item list-group-item-action profile-tab-btn"
                        data-tab="don-hang">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path
                                d="M3.977 9.84A2 2 0 0 1 5.971 8h12.058a2 2 0 0 1 1.994 1.84l.803 10A2 2 0 0 1 18.833 22H5.167a2 2 0 0 1-1.993-2.16l.803-10Z">
                            </path>
                        </svg>
                        Đơn hàng của tôi
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-9">
                <!-- Thông tin tài khoản -->
                <div id="thong-tin" class="tab-pane active show">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-bottom">
                            <h5 class="mb-0">Thông tin tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Họ và tên</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="{{ auth()->user()->name }}"
                                            placeholder="Họ và tên">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}"
                                            placeholder="Email">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Số điện thoại</label>
                                    <div class="col-sm-9">
                                        <input type="tel" class="form-control" value="0901 234 567"
                                            placeholder="Số điện thoại">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Ngày sinh</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" value="1990-01-15">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Giới tính</label>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="male"
                                                value="male" checked>
                                            <label class="form-check-label" for="male">Nam</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="female"
                                                value="female">
                                            <label class="form-check-label" for="female">Nữ</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        <button type="reset" class="btn btn-outline-secondary ms-2">Hủy</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Địa chỉ giao hàng -->
                <div id="dia-chi" class="tab-pane">
                    <div class="card border-0 shadow-sm mb-4">
                        <div
                            class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Địa chỉ giao hàng</h5>
                            <button class="btn btn-sm btn-primary">+ Thêm địa chỉ mới</button>
                        </div>
                        <div class="card-body">
                            <!-- Address Item -->
                            <div class="row mb-4 pb-4 border-bottom">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">Địa chỉ nhà riêng</h6>
                                        <span class="badge bg-success">Mặc định</span>
                                    </div>
                                    <p class="text-muted mb-2">
                                        Nguyễn Văn A<br>
                                        0901 234 567<br>
                                        123 Đường Ngô Gia Tự, Quận Đống Đa, Hà Nội
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button class="btn btn-sm btn-outline-primary me-2">Chỉnh sửa</button>
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </div>
                            </div>

                            <!-- Address Item -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">Địa chỉ công ty</h6>
                                    </div>
                                    <p class="text-muted mb-2">
                                        Nguyễn Văn A<br>
                                        0901 234 567<br>
                                        456 Đường Lê Duẩn, Quận Hoàn Kiếm, Hà Nội
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button class="btn btn-sm btn-outline-primary me-2">Chỉnh sửa</button>
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thay đổi mật khẩu -->
                <div id="mat-khau" class="tab-pane">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-bottom">
                            <h5 class="mb-0">Thay đổi mật khẩu</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Mật khẩu hiện tại</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control"
                                            placeholder="Nhập mật khẩu hiện tại">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Mật khẩu mới</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" placeholder="Nhập mật khẩu mới">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Xác nhận mật khẩu</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" placeholder="Xác nhận mật khẩu mới">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                                        <button type="reset" class="btn btn-outline-secondary ms-2">Hủy</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Đơn hàng -->
                <div id="don-hang" class="tab-pane">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-bottom">
                            <h5 class="mb-0">Đơn hàng của tôi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Ngày đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#DH001</td>
                                            <td>15/04/2026</td>
                                            <td>927.000đ</td>
                                            <td><span class="badge bg-success">Đã giao</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Chi tiết</button></td>
                                        </tr>
                                        <tr>
                                            <td>#DH002</td>
                                            <td>10/04/2026</td>
                                            <td>549.000đ</td>
                                            <td><span class="badge bg-warning">Đang giao</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Chi tiết</button></td>
                                        </tr>
                                        <tr>
                                            <td>#DH003</td>
                                            <td>05/04/2026</td>
                                            <td>1.299.000đ</td>
                                            <td><span class="badge bg-info">Chờ xác nhận</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Chi tiết</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    #profile .list-group-item {
        border: none;
        border-left: 3px solid transparent;
        padding: 12px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #profile .list-group-item:hover {
        background-color: #f0f0f0;
        border-left-color: #0d6efd;
    }

    #profile .list-group-item.active {
        background-color: #e7f1ff;
        border-left-color: #0d6efd;
        color: #0d6efd;
    }

    #profile .tab-pane {
        display: none;
    }

    #profile .tab-pane.active {
        display: block;
    }
</style>

<script>
    document.querySelectorAll('.profile-tab-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const tabName = btn.getAttribute('data-tab');

            // Remove active class from all buttons and tabs
            document.querySelectorAll('.profile-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('#profile .tab-pane').forEach(pane => pane.classList.remove('active'));

            // Add active class to clicked button and corresponding tab
            btn.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });
</script>

@include('layouts.footer')