@include('layouts.header')

<section id="products" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Đồ bé gái</h1>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12 text-center">
                <a href="{{ route('products') }}" class="btn btn-link text-decoration-none me-3">Tất cả</a>
                <a href="{{ route('products.boys') }}" class="btn btn-link text-decoration-none me-3">Đồ bé trai</a>
                <a href="{{ route('products.girls') }}" class="btn btn-link text-decoration-none active fw-bold">Đồ bé
                    gái</a>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row">
            <!-- Product 2 -->
            <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="product-item">
                    <div class="product-image position-relative overflow-hidden rounded-3">
                        <a href="#">
                            <img src="{{ asset('images/product-item-2.jpg') }}" alt="Váy công chúa bé gái"
                                class="img-fluid">
                        </a>
                        <div class="product-overlay d-flex align-items-center justify-content-center position-absolute">
                            <a href="#" class="btn btn-light btn-sm">Xem chi tiết</a>
                        </div>
                    </div>
                    <div class="product-content text-center py-3">
                        <h5 class="product-title">Váy công chúa bé gái</h5>
                        <p class="product-category text-muted small mb-2">Váy</p>
                        <div class="product-rating mb-2">
                            <span class="star">★★★★☆</span> (8 đánh giá)
                        </div>
                        <div class="product-price">
                            <span class="price text-primary fw-bold">299.000₫</span>
                            <span class="original-price text-muted text-decoration-line-through ms-2">380.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm mt-3 w-100">Thêm vào giỏ</button>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="product-item">
                    <div class="product-image position-relative overflow-hidden rounded-3">
                        <a href="#">
                            <img src="{{ asset('images/product-item-4.jpg') }}" alt="Áo khoác phong cách"
                                class="img-fluid">
                        </a>
                        <div class="product-overlay d-flex align-items-center justify-content-center position-absolute">
                            <a href="#" class="btn btn-light btn-sm">Xem chi tiết</a>
                        </div>
                    </div>
                    <div class="product-content text-center py-3">
                        <h5 class="product-title">Áo khoác phong cách</h5>
                        <p class="product-category text-muted small mb-2">Áo khoác</p>
                        <div class="product-rating mb-2">
                            <span class="star">★★★★☆</span> (10 đánh giá)
                        </div>
                        <div class="product-price">
                            <span class="price text-primary fw-bold">249.000₫</span>
                            <span class="original-price text-muted text-decoration-line-through ms-2">350.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm mt-3 w-100">Thêm vào giỏ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .product-item {
        transition: all 0.3s ease;
    }

    .product-image {
        aspect-ratio: 1;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-item:hover .product-image img {
        transform: scale(1.05);
    }

    .product-overlay {
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .product-item:hover .product-overlay {
        opacity: 1;
    }

    .product-rating .star {
        color: #ffc107;
    }

    .product-content {
        border: 1px solid #e9ecef;
        border-top: none;
        border-radius: 0 0 20px 20px;
    }
</style>

@include('layouts.footer')