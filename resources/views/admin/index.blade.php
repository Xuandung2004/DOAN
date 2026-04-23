@extends('admin.includes.master')

@section('title', 'Thống kê báo cáo - Quản trị KAIRA')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Thống kê báo cáo doanh thu</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Xuất báo cáo
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng doanh thu (Đã TT)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($tongDoanhThu, 0, ',', '.') }} đ
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Đơn hàng mới (Chờ xử lý)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $donHangMoi }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tongSanPham }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-box fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Khách hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tongKhachHang }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($ketQuaLoc)
        <div class="alert alert-success shadow-sm border-left-success py-3 mb-4">
            <h5 class="font-weight-bold mb-2">Kết quả thống kê: {{ $ketQuaLoc['tieu_de'] }}</h5>
            <div class="d-flex align-items-center">
                <div class="mr-5">Doanh thu: <span
                        class="font-weight-bold text-danger h5 mb-0">{{ number_format($ketQuaLoc['doanh_thu'], 0, ',', '.') }}
                        VNĐ</span></div>
                <div>Số đơn: <span class="font-weight-bold text-primary h5 mb-0">{{ $ketQuaLoc['so_don'] }}</span></div>
            </div>
            <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline-secondary mt-2">Xóa bộ lọc</a>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-dark">Doanh thu khoảng</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.index') }}" method="GET"
                        class="d-flex align-items-end justify-content-between">
                        <input type="hidden" name="loai_loc" value="khoang">
                        <div class="mr-2 w-100">
                            <label class="small text-muted">Ngày bắt đầu:</label>
                            <input type="date" name="ngay_bat_dau" class="form-control" required>
                        </div>
                        <div class="mr-2 w-100">
                            <label class="small text-muted">Ngày kết thúc:</label>
                            <input type="date" name="ngay_ket_thuc" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-light border px-4">Xem tổng quan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-dark">Doanh thu chi tiết năm</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.index') }}" method="GET"
                        class="d-flex align-items-end justify-content-between">
                        <input type="hidden" name="loai_loc" value="nam">
                        <div class="mr-3 w-100">
                            <label class="small text-muted">Năm (YYYY):</label>
                            <input type="number" name="nam" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <button type="submit" class="btn btn-light border px-4">Xem chi tiết</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-dark">Doanh thu chi tiết tuần</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.index') }}" method="GET"
                        class="d-flex align-items-end justify-content-between">
                        <input type="hidden" name="loai_loc" value="tuan">
                        <div class="mr-2 w-100">
                            <label class="small text-muted">Tuần (WW):</label>
                            <input type="number" name="tuan" class="form-control" placeholder="VD: 46" required>
                        </div>
                        <div class="mr-2 w-100">
                            <label class="small text-muted">Năm (YYYY):</label>
                            <input type="number" name="nam" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <button type="submit" class="btn btn-light border px-4">Xem chi tiết</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-dark">Doanh thu chi tiết tháng</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.index') }}" method="GET"
                        class="d-flex align-items-end justify-content-between">
                        <input type="hidden" name="loai_loc" value="thang">
                        <div class="mr-2 w-100">
                            <label class="small text-muted">Tháng (MM):</label>
                            <input type="number" name="thang" class="form-control" min="1" max="12" value="{{ date('m') }}"
                                required>
                        </div>
                        <div class="mr-2 w-100">
                            <label class="small text-muted">Năm (YYYY):</label>
                            <input type="number" name="nam" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <button type="submit" class="btn btn-light border px-4">Xem chi tiết</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow h-100">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-dark">Doanh thu từng tháng (Năm {{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white border-bottom-0 text-center">
                    <h6 class="m-0 font-weight-bold text-dark">Tỷ lệ Trạng thái Đơn hàng</h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="statusPieChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-dark">Sản phẩm theo Danh mục</h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-dark">Trạng thái đơn hàng</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 mb-3">
                            <div class="border rounded py-3 hover-shadow cursor-pointer">
                                <div class="font-weight-bold text-dark">Hoàn thành</div>
                                <div class="text-success">{{ $donHoanThanh }} đơn</div>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="border rounded py-3 hover-shadow cursor-pointer">
                                <div class="font-weight-bold text-dark">Đã thanh toán</div>
                                <div class="text-primary">{{ $donDaThanhToan }} đơn</div>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="border rounded py-3 hover-shadow cursor-pointer">
                                <div class="font-weight-bold text-dark">Đã hủy</div>
                                <div class="text-danger">{{ $donDaHuy }} đơn</div>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="border rounded py-3 hover-shadow cursor-pointer">
                                <div class="font-weight-bold text-dark">Đang xử lý</div>
                                <div class="text-secondary">{{ $donDangXuLy }} đơn</div>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="border rounded py-3 hover-shadow cursor-pointer">
                                <div class="font-weight-bold text-dark">Đang vận chuyển</div>
                                <div class="text-info">{{ $donDangGiao }} đơn</div>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="border rounded py-3 hover-shadow cursor-pointer">
                                <div class="font-weight-bold text-dark">Tổng cộng</div>
                                <div class="text-dark">{{ $tongSoDon }} đơn</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. Biểu đồ cột Doanh thu
        var ctxRev = document.getElementById("revenueChart");
        var revenueChart = new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8", "T9", "T10", "T11", "T12"],
                datasets: [{
                    label: "Doanh thu (VNĐ)",
                    backgroundColor: "#007bff", // Màu xanh khớp thiết kế
                    data: @json($doanhThuThang),
                }],
            },
            options: { maintainAspectRatio: false }
        });

        // 2. Biểu đồ tròn Trạng thái đơn
        var ctxPie = document.getElementById("statusPieChart");
        var statusPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ["Hoàn thành", "Đang giao", "Chờ xử lý", "Đã hủy"],
                datasets: [{
                    data: [{{ $donHoanThanh }}, {{ $donDangGiao }}, {{ $donDangXuLy }}, {{ $donDaHuy }}],
                    backgroundColor: ['#1cc88a', '#36b9cc', '#858796', '#e74a3b'],
                }],
            },
            options: { maintainAspectRatio: false }
        });

        // 3. Biểu đồ tồn kho danh mục
        var ctxCat = document.getElementById("categoryChart");
        var categoryChart = new Chart(ctxCat, {
            type: 'bar',
            data: {
                labels: @json($tenDanhMucs),
                datasets: [{
                    label: "Số lượng Sản phẩm",
                    backgroundColor: "#36b9cc",
                    data: @json($soLuongSPTrongDM),
                }],
            },
            options: { maintainAspectRatio: false }
        });
    </script>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            transition: 0.3s;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>

@endsection