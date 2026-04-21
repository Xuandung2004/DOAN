@include('layouts.header')

<section id="promotions" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Khuyến mãi và giảm giá</h1>
            </div>
        </div>

        <!-- Promotions Grid -->
        <div class="row">
            <!-- Promotion 1 -->
            <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="promotion-card bg-light rounded-3 p-4 h-100">
                    <div class="promotion-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger fs-6">-25%</span>
                    </div>
                    <img src="{{ asset('images/product-item-1.jpg') }}" alt="Khuyến mãi"
                        class="img-fluid rounded-2 mb-3" style="height: 250px; object-fit: cover; width: 100%;">
                    <h4 class="promotion-title mb-2">Giảm 25% cho bộ sưu tập áo thun</h4>
                    <p class="promotion-description text-muted mb-3">Áo thun chất liệu cotton 100%, thoáng mát và bền
                        đẹp cho bé yêu</p>
                    <p class="promotion-date text-muted small mb-3">
                        <i class="far fa-calendar"></i> Từ 15/04 - 30/04/2026
                    </p>
                    <a href="{{ route('products') }}" class="btn btn-primary w-100">Xem sản phẩm</a>
                </div>
            </div>

            <!-- Promotion 2 -->
            <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="promotion-card bg-light rounded-3 p-4 h-100">
                    <div class="promotion-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger fs-6">-30%</span>
                    </div>
                    <img src="{{ asset('images/product-item-2.jpg') }}" alt="Khuyến mãi"
                        class="img-fluid rounded-2 mb-3" style="height: 250px; object-fit: cover; width: 100%;">
                    <h4 class="promotion-title mb-2">Giảm 30% cho bộ sưu tập váy công chúa</h4>
                    <p class="promotion-description text-muted mb-3">Váy xoè xinh xắn, chất liệu thoáng mát, phù hợp mặc
                        hàng ngày</p>
                    <p class="promotion-date text-muted small mb-3">
                        <i class="far fa-calendar"></i> Từ 18/04 - 25/04/2026
                    </p>
                    <a href="{{ route('products') }}" class="btn btn-primary w-100">Xem sản phẩm</a>
                </div>
            </div>

            <!-- Promotion 3 -->
            <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="promotion-card bg-light rounded-3 p-4 h-100">
                    <div class="promotion-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger fs-6">Mua 2 tặng 1</span>
                    </div>
                    <img src="{{ asset('images/product-item-3.jpg') }}" alt="Khuyến mãi"
                        class="img-fluid rounded-2 mb-3" style="height: 250px; object-fit: cover; width: 100%;">
                    <h4 class="promotion-title mb-2">Mua 2 bộ thun, tặng 1 bộ</h4>
                    <p class="promotion-description text-muted mb-3">Bộ thun năng động, co giãn tốt, thích hợp cho các
                        hoạt động ngoài trời</p>
                    <p class="promotion-date text-muted small mb-3">
                        <i class="far fa-calendar"></i> Từ 20/04 - 30/04/2026
                    </p>
                    <a href="{{ route('products') }}" class="btn btn-primary w-100">Xem sản phẩm</a>
                </div>
            </div>

            <!-- Promotion 4 -->
            <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="promotion-card bg-light rounded-3 p-4 h-100">
                    <div class="promotion-badge position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger fs-6">-20%</span>
                    </div>
                    <img src="{{ asset('images/product-item-4.jpg') }}" alt="Khuyến mãi"
                        class="img-fluid rounded-2 mb-3" style="height: 250px; object-fit: cover; width: 100%;">
                    <h4 class="promotion-title mb-2">Giảm 20% cho áo khoác mùa xuân</h4>
                    <p class="promotion-description text-muted mb-3">Áo khoác phong cách, thiết kế hiện đại, phù hợp
                        thời tiết mùa xuân</p>
                    <p class="promotion-date text-muted small mb-3">
                        <i class="far fa-calendar"></i> Từ 15/04 - 22/04/2026
                    </p>
                    <a href="{{ route('products') }}" class="btn btn-primary w-100">Xem sản phẩm</a>
                </div>
            </div>
        </div>

        <!-- Special Offer Banner -->
        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12">
                <div class="special-offer-banner bg-primary text-white rounded-3 p-5 text-center">
                    <h2 class="mb-3">Hóa đơn đầu tiên giảm 10%</h2>
                    <p class="mb-4 fs-5">Nhập mã: <strong>WELCOME10</strong> khi thanh toán để nhận giảm giá</p>
                    <a href="{{ route('products') }}" class="btn btn-light btn-lg">Mua sắm ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .promotion-card {
        position: relative;
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .promotion-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .promotion-badge {
        z-index: 10;
    }

    .special-offer-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>

@include('layouts.footer')