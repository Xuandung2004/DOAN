@include('layouts.header')

<section class="py-5 bg-light">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('orders.history') }}" class="text-decoration-none text-primary fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Quay lại lịch sử đơn hàng
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            Mã đơn: <span class="text-primary">#DH{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </h5>
                        @if($order->trangthaidon == 0)
                            <span class="badge bg-secondary fs-6">Chờ xử lý</span>
                        @elseif($order->trangthaidon == 1)
                            <span class="badge bg-primary fs-6">Đang giao</span>
                        @elseif($order->trangthaidon == 2)
                            <span class="badge bg-success fs-6">Hoàn tất</span>
                        @else
                            <span class="badge bg-danger fs-6">Đã hủy</span>
                        @endif
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Sản phẩm</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-end pe-4">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($item->product->images->isNotEmpty())
                                                        <img src="{{ asset($item->product->images->first()->duongdananh) }}"
                                                            alt="img" class="rounded border"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endif
                                                    <span class="fw-bold">{{ $item->product->ten }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ number_format($item->gia, 0, ',', '.') }}đ</td>
                                            <td class="text-center">{{ $item->soluong }}</td>
                                            <td class="text-end pe-4 fw-bold text-danger">
                                                {{ number_format($item->gia * $item->soluong, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold border-bottom pb-2 mb-3"><i
                                class="fas fa-map-marker-alt text-primary me-2"></i> Thông tin nhận hàng</h6>
                        <p class="mb-1 fw-bold">{{ Auth::user()->hoten }}</p>
                        <p class="mb-1 text-muted">{{ Auth::user()->sodienthoai }}</p>
                        <p class="mb-0 text-muted">{{ $order->diachigiaohang }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold border-bottom pb-2 mb-3"><i
                                class="fas fa-file-invoice-dollar text-primary me-2"></i> Chi tiết thanh toán</h6>

                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Tạm tính:</span>
                            <span
                                class="fw-bold text-dark">{{ number_format($order->tongtien + $order->sotiengiam - 30000, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Phí vận chuyển:</span>
                            <span class="fw-bold text-dark">30.000đ</span>
                        </div>
                        @if($order->sotiengiam > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá:</span>
                                <span class="fw-bold">-{{ number_format($order->sotiengiam, 0, ',', '.') }}đ</span>
                            </div>
                        @endif

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Tổng cộng:</span>
                            <span
                                class="fs-4 fw-bold text-danger">{{ number_format($order->tongtien, 0, ',', '.') }}đ</span>
                        </div>

                        <div
                            class="alert alert-{{ $order->trangthaithanhtoan == 1 ? 'success' : 'warning' }} py-2 mb-0 text-center">
                            <strong>{{ $order->phuongthucthanhtoan }}</strong> -
                            {{ $order->trangthaithanhtoan == 1 ? 'Đã thanh toán' : 'Chờ thanh toán' }}
                        </div>

                        @if($order->trangthaidon == 0)
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger w-100 fw-bold"
                                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                    <i class="fas fa-times-circle me-1"></i> Hủy đơn hàng này
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')