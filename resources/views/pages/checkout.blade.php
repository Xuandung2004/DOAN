@include('layouts.header')

<section id="checkout" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Thanh toán đơn hàng</h1>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.placeOrder') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-lg-8 mb-4">

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4 border-bottom pb-2">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i> Thông tin giao hàng
                            </h5>

                            <div class="mb-3">
                                <label for="diachigiaohang" class="form-label fw-bold">Địa chỉ nhận hàng chi tiết <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="diachigiaohang" name="diachigiaohang" rows="3"
                                    placeholder="Ví dụ: Số 123, Đường ABC, Phường XYZ, Quận..."
                                    required>{{ old('diachigiaohang', Auth::user()->diachi) }}</textarea>
                                <small class="text-muted">Ghi chú thêm: Tòa nhà, số tầng... (nếu có)</small>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4 border-bottom pb-2">
                                <i class="fas fa-credit-card text-primary me-2"></i> Phương thức thanh toán
                            </h5>

                            <div class="form-check p-3 border rounded mb-3 bg-white hover-shadow transition-all">
                                <input class="form-check-input ms-1" type="radio" name="phuongthucthanhtoan"
                                    id="paymentCOD" value="COD" checked>
                                <label class="form-check-label ms-3 w-100 cursor-pointer d-flex align-items-center"
                                    for="paymentCOD">
                                    <i class="fas fa-money-bill-wave text-success fa-2x me-3"></i>
                                    <div>
                                        <span class="fw-bold d-block">Thanh toán khi nhận hàng (COD)</span>
                                        <small class="text-muted">Nhận hàng, kiểm tra rồi mới thanh toán.</small>
                                    </div>
                                </label>
                            </div>

                            <div class="form-check p-3 border rounded bg-white hover-shadow transition-all">
                                <input class="form-check-input ms-1" type="radio" name="phuongthucthanhtoan"
                                    id="paymentVNPAY" value="VNPAY">
                                <label class="form-check-label ms-3 w-100 cursor-pointer d-flex align-items-center"
                                    for="paymentVNPAY">
                                    <img src="https://vnpay.vn/s1/vnpay/assets/images/logo-icon/logo-primary.svg"
                                        alt="VNPay" height="30" class="me-3">
                                    <div>
                                        <span class="fw-bold d-block">Thanh toán qua VNPAY</span>
                                        <small class="text-muted">Quét mã QR, Thẻ ATM nội địa, Thẻ quốc tế.</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3 border-bottom pb-2">
                                <i class="fas fa-ticket-alt text-warning me-2"></i> Áp dụng Mã giảm giá
                            </h5>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control border-secondary" name="magiamgia"
                                    placeholder="Nhập mã ưu đãi (nếu có)..." value="{{ old('magiamgia') }}">
                            </div>
                            <small class="text-danger fst-italic">* Hệ thống sẽ tự động tính toán mã giảm giá khi bạn
                                bấm Đặt hàng.</small>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold border-bottom pb-3 mb-4">Tóm tắt đơn hàng</h5>

                            <div class="mb-4" style="max-height: 250px; overflow-y: auto;">
                                @foreach($cart->cartItems as $item)
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($item->product->images->isNotEmpty())
                                                <img src="{{ asset($item->product->images->first()->duongdananh) }}" alt="img"
                                                    class="rounded border"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <div class="text-truncate fw-bold"
                                                    style="max-width: 150px; font-size: 0.9rem;">{{ $item->product->ten }}
                                                </div>
                                                <small class="text-muted">x{{ $item->soluong }}</small>
                                            </div>
                                        </div>
                                        <span class="fw-bold text-dark"
                                            style="font-size: 0.9rem;">{{ number_format($item->gia * $item->soluong, 0, ',', '.') }}đ</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-secondary border-top pt-3">
                                <span>Tạm tính:</span>
                                <span class="fw-bold text-dark">{{ number_format($tamTinh, 0, ',', '.') }}đ</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-secondary">
                                <span>Phí vận chuyển:</span>
                                <span class="fw-bold text-dark">{{ number_format($phiVanChuyen, 0, ',', '.') }}đ</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4 mt-2 border-top pt-3">
                                <span class="fs-6 fw-bold">Tổng thanh toán:</span>
                                <span
                                    class="fs-4 fw-bold text-danger">{{ number_format($tongThanhToan, 0, ',', '.') }}đ</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 fw-bold shadow-sm py-3">
                                <i class="fas fa-check-circle me-2"></i> XÁC NHẬN ĐẶT HÀNG
                            </button>

                            <a href="{{ route('cart.index') }}"
                                class="btn btn-outline-secondary w-100 text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</section>

<style>
    .cursor-pointer {
        cursor: pointer;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
        border-color: #0d6efd !important;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    /* Chỉnh màu khi Radio được check */
    .form-check-input:checked+label {
        color: #0d6efd;
    }
</style>

@include('layouts.footer')