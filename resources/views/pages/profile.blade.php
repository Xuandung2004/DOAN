@include('layouts.header')

<section id="profile" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Hồ sơ cá nhân</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center mx-auto"
                                style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                                {{ substr($user->hoten ?? 'U', 0, 1) }}
                            </div>
                        </div>
                        <h5 class="card-title mb-1 fw-bold">{{ $user->hoten }}</h5>
                        <p class="text-muted small mb-4">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="list-group mt-4 sticky-top" style="top: 20px;">
                    <a href="#thong-tin" class="list-group-item list-group-item-action active profile-tab-btn"
                        data-tab="thong-tin">
                        <i class="fas fa-user me-2"></i> Thông tin & Địa chỉ
                    </a>
                    <a href="#mat-khau" class="list-group-item list-group-item-action profile-tab-btn"
                        data-tab="mat-khau">
                        <i class="fas fa-lock me-2"></i> Thay đổi mật khẩu
                    </a>
                    <a href="#don-hang" class="list-group-item list-group-item-action profile-tab-btn"
                        data-tab="don-hang">
                        <i class="fas fa-shopping-bag me-2 px-1"></i> Lịch sử đơn hàng
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="list-group-item list-group-item-action text-danger fw-bold w-100 text-start">
                            <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                @if(session('thongbao'))
                    <div class="alert alert-success shadow-sm"><i
                            class="fas fa-check-circle me-2"></i>{{ session('thongbao') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white p-4 rounded shadow-sm border-0">

                    <div id="thong-tin" class="tab-pane active show">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Thông tin tài khoản</h5>

                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">Họ và tên <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="hoten" class="form-control"
                                        value="{{ old('hoten', $user->hoten) }}" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">Email <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <label class="col-sm-3 col-form-label fw-bold">Số điện thoại</label>
                                <div class="col-sm-9">
                                    <input type="tel" name="sodienthoai" class="form-control"
                                        value="{{ old('sodienthoai', $user->sodienthoai) }}"
                                        placeholder="VD: 0987654321">
                                </div>
                            </div>

                            <h5 class="mb-4 mt-5 fw-bold border-bottom pb-2">Địa chỉ giao hàng</h5>
                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label fw-bold">Địa chỉ chi tiết</label>
                                <div class="col-sm-9">
                                    <textarea name="diachi" class="form-control" rows="3"
                                        placeholder="Nhập số nhà, tên đường, phường/xã...">{{ old('diachi', $user->diachi) }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu thông tin</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="mat-khau" class="tab-pane">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="hoten" value="{{ $user->hoten }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">

                            <h5 class="mb-4 fw-bold border-bottom pb-2">Thay đổi mật khẩu</h5>

                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold">Mật khẩu hiện tại <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="password" name="matkhau_cu" class="form-control"
                                        placeholder="Nhập mật khẩu cũ">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold">Mật khẩu mới <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="password" name="matkhau" class="form-control"
                                        placeholder="Ít nhất 8 ký tự">
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold">Nhập lại mật khẩu mới <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="password" name="matkhau_confirmation" class="form-control"
                                        placeholder="Xác nhận lại mật khẩu">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Đổi mật
                                        khẩu</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="don-hang" class="tab-pane">
                        <h5 class="mb-4 fw-bold border-bottom pb-2">Đơn hàng của tôi</h5>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã ĐH</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="fw-bold text-primary">
                                                #DH{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->ngaytao)->format('d/m/Y') }}</td>
                                            <td class="fw-bold text-danger">
                                                {{ number_format($order->tongtien, 0, ',', '.') }}đ
                                            </td>
                                            <td>
                                                @if($order->trangthaidon == 0)
                                                    <span class="badge bg-secondary">Chờ xử lý</span>
                                                @elseif($order->trangthaidon == 1)
                                                    <span class="badge bg-info text-dark">Đang giao</span>
                                                @elseif($order->trangthaidon == 2)
                                                    <span class="badge bg-success">Hoàn tất</span>
                                                @else
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Bạn chưa có đơn hàng nào.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
        border-left: 4px solid transparent;
        padding: 15px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #555;
    }

    #profile .list-group-item:hover {
        background-color: #f8f9fa;
        border-left-color: #0d6efd;
        color: #0d6efd;
    }

    #profile .list-group-item.active {
        background-color: #e7f1ff;
        border-left-color: #0d6efd;
        color: #0d6efd;
        font-weight: bold;
    }

    #profile .tab-pane {
        display: none;
        animation: fadeIn 0.4s;
    }

    #profile .tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.querySelectorAll('.profile-tab-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const tabName = btn.getAttribute('data-tab');

            document.querySelectorAll('.profile-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('#profile .tab-pane').forEach(pane => pane.classList.remove('active', 'show'));

            btn.classList.add('active');
            document.getElementById(tabName).classList.add('active', 'show');
        });
    });
</script>

@include('layouts.footer')