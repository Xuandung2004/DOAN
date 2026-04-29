@include('layouts.header')

<section id="promotions" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-2" data-aos="fade-up">Săn Mã Giảm Giá</h1>
                <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Nhanh tay thu thập mã -
                    Số lượng có hạn!</p>
            </div>
        </div>

        <div class="row">
            @foreach($coupons as $coupon)
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="promotion-card bg-white rounded-4 p-4 h-100 d-flex flex-column shadow-sm">

                        <div class="promotion-badge position-absolute top-0 end-0 mt-3 me-3">
                            <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill shadow-sm">
                                @if($coupon->loai == 'phantram')
                                    Giảm {{ $coupon->giatri }}%
                                @else
                                    Giảm {{ number_format($coupon->giatri, 0, ',', '.') }}đ
                                @endif
                            </span>
                        </div>

                        <div class="text-center mb-3 pt-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle"
                                style="width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" class="text-primary" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="8" width="18" height="8" rx="2" ry="2"></rect>
                                    <path d="M12 8v8"></path>
                                    <path d="M8 12h.01"></path>
                                    <path d="M16 12h.01"></path>
                                </svg>
                            </div>
                        </div>

                        <h3 class="promotion-title mb-2 text-center text-uppercase fw-bold text-primary tracking-wide">
                            {{ $coupon->ma }}
                        </h3>

                        <p class="promotion-description text-muted mb-4 text-center">
                            Áp dụng cho đơn hàng từ <br>
                            <strong
                                class="text-dark fs-5">{{ number_format($coupon->giatridontoithieu, 0, ',', '.') }}đ</strong>
                        </p>

                        @php
                            // Chống chia cho 0 nếu giới hạn là 0
                            $gioiHan = $coupon->gioihansudung > 0 ? $coupon->gioihansudung : 1;
                            $phanTramDaDung = ($coupon->dasudung / $gioiHan) * 100;
                            $conLai = $coupon->gioihansudung - $coupon->dasudung;
                        @endphp

                        <div class="mb-4 mt-auto">
                            <div class="d-flex justify-content-between small text-muted mb-2 fw-medium">
                                <span>Đã dùng {{ $coupon->dasudung }}</span>
                                <span class="text-danger">Còn {{ $conLai > 0 ? $conLai : 0 }} mã</span>
                            </div>
                            <div class="progress rounded-pill bg-light" style="height: 8px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                    role="progressbar" style="width: {{ $phanTramDaDung }}%"
                                    aria-valuenow="{{ $phanTramDaDung }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <p class="promotion-date text-muted small mb-4 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-warning me-1 mb-1">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg> HSD:
                            <strong
                                class="text-dark">{{ $coupon->hethan ? \Carbon\Carbon::parse($coupon->hethan)->format('d/m/Y') : 'Không giới hạn' }}</strong>
                        </p>

                        <button onclick="copyCouponCode(this, '{{ $coupon->ma }}')"
                            class="btn btn-primary w-100 fw-bold py-2 rounded-pill copy-btn transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="me-2 mb-1">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg> Copy Mã
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12">
                <div
                    class="special-offer-banner text-white rounded-4 p-5 text-center shadow-lg position-relative overflow-hidden">
                    <div class="position-absolute top-0 start-0 translate-middle bg-white bg-opacity-10 rounded-circle"
                        style="width: 200px; height: 200px;"></div>
                    <div class="position-absolute bottom-0 end-0 translate-middle-x bg-white bg-opacity-10 rounded-circle"
                        style="width: 150px; height: 150px;"></div>

                    <h2 class="mb-3 position-relative z-1 fw-bold">Thành Viên Mới?</h2>
                    <p class="mb-4 fs-5 position-relative z-1">Hóa đơn đầu tiên giảm ngay 10% khi nhập mã: <strong
                            class="bg-white text-primary px-2 py-1 rounded ms-1">WELCOME10</strong></p>
                    <a href="{{ route('products.index') }}"
                        class="btn btn-light btn-lg px-5 rounded-pill fw-bold position-relative z-1 shadow-sm text-primary">Mua
                        sắm ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .promotion-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid transparent;
    }

    .promotion-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        border-color: #e2e8f0;
    }

    .tracking-wide {
        letter-spacing: 2px;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .special-offer-banner {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    }

    /* Hiệu ứng khi copy thành công */
    .copy-success {
        background-color: #10b981 !important;
        border-color: #10b981 !important;
        color: white !important;
    }
</style>

<script>
    function copyCouponCode(buttonElement, code) {
        // Copy text vào clipboard
        navigator.clipboard.writeText(code).then(function () {
            // Đổi trạng thái nút
            let originalText = buttonElement.innerHTML;

            buttonElement.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2 mb-1"><polyline points="20 6 9 17 4 12"></polyline></svg> Đã Copy!';
            buttonElement.classList.add('copy-success');

            // Trả lại trạng thái ban đầu sau 3 giây
            setTimeout(function () {
                buttonElement.innerHTML = originalText;
                buttonElement.classList.remove('copy-success');
            }, 3000);

        }).catch(function (err) {
            console.error('Lỗi không thể copy: ', err);
            alert('Trình duyệt của bạn không hỗ trợ copy tự động. Vui lòng copy thủ công mã: ' + code);
        });
    }
</script>

@include('layouts.footer')