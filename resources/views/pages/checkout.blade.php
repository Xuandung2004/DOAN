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

        <form id="checkout-form" onsubmit="submitCheckout(event)">
            @csrf

            <div class="row">
                <div class="col-lg-8 mb-4">

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4 border-bottom pb-2">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i> Thông tin giao hàng
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tennguoinhan" class="form-label fw-bold">Họ tên người nhận <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tennguoinhan" name="tennguoinhan"
                                        placeholder="Nhập họ tên..."
                                        value="{{ old('tennguoinhan', Auth::user()->hoten ?? Auth::user()->name ?? Auth::user()->ten ?? '') }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sodienthoai" class="form-label fw-bold">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="sodienthoai" name="sodienthoai"
                                        placeholder="Nhập số điện thoại..."
                                        value="{{ old('sodienthoai', Auth::user()->sodienthoai ?? Auth::user()->phone ?? '') }}"
                                        required>
                                </div>
                            </div>

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

                            <label
                                class="border rounded p-3 mb-3 bg-white d-flex align-items-center w-100 payment-card shadow-sm"
                                for="paymentCOD" style="cursor: pointer; transition: all 0.2s ease;">
                                <div class="m-0 p-0 d-flex align-items-center">
                                    <input class="form-check-input fs-4 m-0 border-secondary" type="radio"
                                        name="phuongthucthanhtoan" id="paymentCOD" value="COD" checked
                                        style="cursor: pointer;">
                                </div>

                                <div class="d-flex align-items-center ms-3 w-100">
                                    <div class="text-success me-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <path d="M6 12h.01M18 12h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block text-primary" style="font-size: 1.05rem;">Thanh
                                            toán khi nhận hàng (COD)</span>
                                        <small class="text-muted">Nhận hàng, kiểm tra rồi mới thanh toán.</small>
                                    </div>
                                </div>
                            </label>

                            <label
                                class="border rounded p-3 mb-3 bg-white d-flex align-items-center w-100 payment-card shadow-sm"
                                for="paymentVNPAY" style="cursor: pointer; transition: all 0.2s ease;">
                                <div class="m-0 p-0 d-flex align-items-center">
                                    <input class="form-check-input fs-4 m-0 border-secondary" type="radio"
                                        name="phuongthucthanhtoan" id="paymentVNPAY" value="VNPAY"
                                        style="cursor: pointer;">
                                </div>

                                <div class="d-flex align-items-center ms-3 w-100">
                                    <div class="me-3 bg-light rounded px-2 py-1 border">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="65" height="24"
                                            viewBox="0 0 80 24">
                                            <text x="0" y="19" font-family="Arial, sans-serif" font-weight="900"
                                                font-size="22" fill="#005BAA" letter-spacing="-1">VN</text>
                                            <text x="31" y="19" font-family="Arial, sans-serif" font-weight="900"
                                                font-size="22" fill="#ED1C24" letter-spacing="-1">PAY</text>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block text-primary" style="font-size: 1.05rem;">Thanh
                                            toán qua VNPAY</span>
                                        <small class="text-muted">Quét mã QR, Thẻ ATM nội địa, Thẻ quốc tế.</small>
                                    </div>
                                </div>
                            </label>
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

                            @if($soTienGiam > 0)
                                <div class="d-flex justify-content-between mb-3 text-success">
                                    <span>Giảm giá ({{ $maGiamGia }}):</span>
                                    <span class="fw-bold">-{{ number_format($soTienGiam, 0, ',', '.') }}đ</span>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mb-4 mt-2 border-top pt-3">
                                <span class="fs-6 fw-bold">Tổng thanh toán:</span>
                                <span
                                    class="fs-4 fw-bold text-danger">{{ number_format($tongThanhToan, 0, ',', '.') }}đ</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 fw-bold shadow-sm py-3">
                                <i class="fas fa-check-circle me-2"></i> XÁC NHẬN ĐẶT HÀNG
                            </button>

                            <a href="{{ route('cart') }}" class="btn btn-outline-secondary w-100 text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>

                    <input type="hidden" name="magiamgia" value="{{ old('magiamgia', $maGiamGia) }}">
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

    .form-check-input:checked+label {
        color: #0d6efd;
    }
</style>
<script>
    function submitCheckout(event) {
        event.preventDefault(); // Chặn trình duyệt load lại trang

        let form = document.getElementById('checkout-form');
        let formData = new FormData(form);

        // CẢI TIẾN 1: Lấy Token thẳng từ thẻ @csrf bên trong form cho chắc ăn 100%
        let tokenInput = form.querySelector('input[name="_token"]');
        let token = tokenInput ? tokenInput.value : '';

        let submitBtn = form.querySelector('button[type="submit"]');

        // Hiệu ứng nút bấm
        submitBtn.disabled = true;
        let originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> ĐANG XỬ LÝ...';

        fetch('{{ route("checkout.placeOrder") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: formData
        })
            .then(response => {
                // CẢI TIẾN 2: Bắt dữ liệu chuẩn để không bị lỗi async/await ở trình duyệt cũ
                return response.json().then(data => ({
                    status: response.status,
                    ok: response.ok,
                    body: data
                }));
            })
            .then(res => {
                let data = res.body;

                // Xử lý nếu Controller báo lỗi Validate
                if (!res.ok) {
                    let errorMsg = data.message || 'Có lỗi xảy ra!';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors)[0][0]; // Lấy lỗi đầu tiên
                    }
                    throw new Error(errorMsg);
                }

                // Nếu thành công
                if (data.status === 'success') {
                    if (typeof showGlobalToast === 'function') {
                        showGlobalToast(data.message);
                    } else {
                        alert(data.message);
                    }

                    // Chuyển trang
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 1500);
                }
            })
            .catch(error => {
                // Báo lỗi bằng Toast đỏ
                if (typeof showGlobalToast === 'function') {
                    showGlobalToast(error.message, 'error');
                } else {
                    alert(error.message);
                }

                // Mở khóa lại nút
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
    }
</script>

@include('layouts.footer')