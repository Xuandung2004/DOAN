@include('layouts.header')

<section id="billboard" class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="section-title text-center mt-4" data-aos="fade-up">Bộ sưu tập mới</h1>
            <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
                <p>Khám phá những mẫu trang phục mới nhất dành cho bé, mang lại sự thoải mái và phong cách đáng yêu. Cập
                    nhật xu hướng thời trang trẻ em nổi bật nhất mùa này!</p>
            </div>
        </div>
        <div class="row">
            <div class="swiper main-swiper py-4" data-aos="fade-up" data-aos-delay="600">

                <div class="swiper-wrapper d-flex border-animation-left">

                    <div class="swiper-slide">
                        <div class="banner-item image-zoom-effect">
                            <div class="image-holder">
                                <a href="{{ route('products', ['danhmuc' => 1]) }}">
                                    <img src="{{ asset('images/banner-image-6.jpg') }}" alt="product" class="img-fluid">
                                </a>
                            </div>
                            <div class="banner-content py-4">
                                <h5 class="element-title text-uppercase">
                                    <a href="{{ route('products', ['danhmuc' => 1]) }}" class="item-anchor">Áo khoác cho
                                        bé</a>
                                </h5>
                                <p>Chất liệu cao cấp, mềm mại và an toàn cho làn da nhạy cảm của bé.</p>
                                <div class="btn-left">
                                    <a href="{{ route('products', ['danhmuc' => 1]) }}"
                                        class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Khám phá
                                        ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="banner-item image-zoom-effect">
                            <div class="image-holder">
                                <a href="{{ route('products', ['danhmuc' => 2]) }}">
                                    <img src="{{ asset('images/banner-image-1.jpg') }}" alt="product" class="img-fluid">
                                </a>
                            </div>
                            <div class="banner-content py-4">
                                <h5 class="element-title text-uppercase">
                                    <a href="{{ route('products', ['danhmuc' => 2]) }}" class="item-anchor">Váy công
                                        chúa</a>
                                </h5>
                                <p>Thiết kế xinh xắn, chất vải thoáng mát giúp bé tự tin tỏa sáng.</p>
                                <div class="btn-left">
                                    <a href="{{ route('products', ['danhmuc' => 2]) }}"
                                        class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Khám phá
                                        ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="banner-item image-zoom-effect">
                            <div class="image-holder">
                                <a href="{{ route('products', ['danhmuc' => 1]) }}">
                                    <img src="{{ asset('images/banner-image-2.jpg') }}" alt="product" class="img-fluid">
                                </a>
                            </div>
                            <div class="banner-content py-4">
                                <h5 class="element-title text-uppercase">
                                    <a href="{{ route('products', ['danhmuc' => 1]) }}" class="item-anchor">Bộ thun năng
                                        động</a>
                                </h5>
                                <p>Thấm hút mồ hôi tốt, phù hợp cho các hoạt động vui chơi ngoài trời.</p>
                                <div class="btn-left">
                                    <a href="{{ route('products', ['danhmuc' => 1]) }}"
                                        class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Khám phá
                                        ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="banner-item image-zoom-effect">
                            <div class="image-holder">
                                <a href="{{ route('products', ['danhmuc' => 3]) }}">
                                    <img src="{{ asset('images/banner-image-3.jpg') }}" alt="product" class="img-fluid">
                                </a>
                            </div>
                            <div class="banner-content py-4">
                                <h5 class="element-title text-uppercase">
                                    <a href="{{ route('products', ['danhmuc' => 3]) }}" class="item-anchor">Set đồ sơ
                                        sinh</a>
                                </h5>
                                <p>Nâng niu làn da nhạy cảm với 100% cotton hữu cơ tự nhiên.</p>
                                <div class="btn-left">
                                    <a href="{{ route('products', ['danhmuc' => 3]) }}"
                                        class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Khám phá
                                        ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="banner-item image-zoom-effect">
                            <div class="image-holder">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('images/banner-image-5.jpg') }}" alt="product" class="img-fluid">
                                </a>
                            </div>
                            <div class="banner-content py-4">
                                <h5 class="element-title text-uppercase">
                                    <a href="{{ route('products') }}" class="item-anchor">Đồ ngủ dễ thương</a>
                                </h5>
                                <p>Đem lại cho bé giấc ngủ ngon lành với họa tiết động vật ngộ nghĩnh.</p>
                                <div class="btn-left">
                                    <a href="{{ route('products') }}"
                                        class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Khám phá
                                        ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
                    <use xlink:href="#arrow-left"></use>
                </svg></div>
            <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
                    <use xlink:href="#arrow-right"></use>
                </svg></div>
        </div>
    </div>
</section>

<section class="features py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="0">
                <div class="py-5">
                    <svg width="38" height="38" viewBox="0 0 24 24">
                        <use xlink:href="#calendar"></use>
                    </svg>
                    <h4 class="element-title text-capitalize my-3">Đặt lịch hẹn</h4>
                    <p>Hỗ trợ tư vấn và thử đồ trực tiếp cho bé tại hệ thống cửa hàng của chúng tôi.</p>
                </div>
            </div>
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="300">
                <div class="py-5">
                    <svg width="38" height="38" viewBox="0 0 24 24">
                        <use xlink:href="#shopping-bag"></use>
                    </svg>
                    <h4 class="element-title text-capitalize my-3">Nhận tại cửa hàng</h4>
                    <p>Linh hoạt đặt hàng online và ghé nhận trực tiếp tại chi nhánh gần nhất.</p>
                </div>
            </div>
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="600">
                <div class="py-5">
                    <svg width="38" height="38" viewBox="0 0 24 24">
                        <use xlink:href="#gift"></use>
                    </svg>
                    <h4 class="element-title text-capitalize my-3">Đóng gói quà tặng</h4>
                    <p>Hộp quà tặng xinh xắn, an toàn và hoàn toàn thân thiện với môi trường.</p>
                </div>
            </div>
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="900">
                <div class="py-5">
                    <svg width="38" height="38" viewBox="0 0 24 24">
                        <use xlink:href="#arrow-cycle"></use>
                    </svg>
                    <h4 class="element-title text-capitalize my-3">Đổi trả dễ dàng</h4>
                    <p>Chính sách hỗ trợ đổi trả tận nhà trong vòng 7 ngày nếu bé mặc không vừa size.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="categories overflow-hidden">
    <div class="container">
        <div class="open-up" data-aos="zoom-out">
            <div class="row">
                <div class="col-md-4">
                    <div class="cat-item image-zoom-effect">
                        <div class="image-holder">
                            <a href="products?danhmuc=1">
                                <img src="{{ asset('images/betrai1.1.jpg') }}" alt="categories"
                                    class="product-image img-fluid">
                            </a>
                        </div>
                        <div class="category-content">
                            <div class="product-button">
                                <a href="products?danhmuc=1" class="btn btn-common text-uppercase">Thời trang bé
                                    trai</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cat-item image-zoom-effect">
                        <div class="image-holder">
                            <a href="products?danhmuc=2">
                                <img src="{{ asset('images/begai3.2.jpg') }}" alt="categories"
                                    class="product-image img-fluid">
                            </a>
                        </div>
                        <div class="category-content">
                            <div class="product-button">
                                <a href="products?danhmuc=2" class="btn btn-common text-uppercase">Thời trang bé gái</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cat-item image-zoom-effect">
                        <div class="image-holder">
                            <a href="products?danhmuc=4">
                                <img src="{{ asset('images/phukien5.2.jpg') }}" alt="categories"
                                    class="product-image img-fluid">
                            </a>
                        </div>
                        <div class="category-content">
                            <div class="product-button">
                                <a href="products?danhmuc=4" class="btn btn-common text-uppercase">Phụ kiện cho bé</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="new-arrival" class="new-arrival product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
            <h4 class="text-uppercase">Hàng Mới Về</h4>
            <a href="{{ url('/products') }}" class="btn-link">Xem tất cả sản phẩm</a>
        </div>
        <div class="swiper product-swiper open-up" data-aos="zoom-out">
            <div class="swiper-wrapper d-flex">
                @foreach($newProducts as $product)
                    <div class="swiper-slide">
                        <div class="product-item image-zoom-effect link-effect">
                            <div class="image-holder position-relative">
                                <a href="{{ url('/products/' . $product->duongdan) }}">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ asset($product->images->first()->duongdananh) }}" alt="{{ $product->ten }}"
                                            class="product-image img-fluid">
                                    @else
                                        <img src="{{ asset('images/default-product.jpg') }}" alt="No image"
                                            class="product-image img-fluid">
                                    @endif
                                </a>
                                <a href="javascript:void(0)"
                                    class="btn-icon btn-wishlist toggle-wishlist {{ in_array($product->id, $wishlistIds) ? 'text-danger' : '' }}"
                                    data-id="{{ $product->id }}">

                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </a>
                                <div class="product-content">
                                    <h5 class="element-title text-uppercase fs-5 mt-3">
                                        <a href="{{ url('/products/' . $product->duongdan) }}">{{ $product->ten }}</a>
                                    </h5>
                                    <a href="#" class="text-decoration-none" data-after="Thêm vào giỏ">
                                        <span>{{ number_format($product->gia, 0, ',', '.') }}đ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-left"></use>
            </svg></div>
        <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-right"></use>
            </svg></div>
    </div>
</section>

<section class="collection bg-light position-relative py-5">
    <div class="container">
        <div class="row">
            <div class="title-xlarge text-uppercase txt-fx domino">Bộ Sưu Tập</div>
            <div class="collection-item d-flex flex-wrap my-5">
                <div class="col-md-6 column-container">
                    <div class="image-holder">
                        <img src="{{ asset('images/sanpham3.jpg') }}" alt="collection" class="product-image img-fluid">
                    </div>
                </div>
                <div class="col-md-6 column-container bg-white">
                    <div class="collection-content p-5 m-0 m-md-5">
                        <h3 class="element-title text-uppercase">Bộ sưu tập Mùa Thu Đông</h3>
                        <p>Mang đến sự ấm áp và phong cách đáng yêu cho bé trong những ngày se lạnh. Chất liệu cotton
                            hữu cơ an toàn, kết hợp cùng họa tiết bắt mắt. Sự lựa chọn hoàn hảo để bé tự do vận động mà
                            vẫn giữ được sự thoải mái suốt cả ngày dài. Khám phá ngay những thiết kế độc quyền chỉ có
                            tại BlueVn!</p>
                        <a href="#" class="btn btn-dark text-uppercase mt-3">Mua Sắm Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="best-sellers" class="best-sellers product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
            <h4 class="text-uppercase">Sản Phẩm Bán Chạy</h4>
            <a href="{{ url('/products') }}" class="btn-link">Xem tất cả sản phẩm</a>
        </div>
        <div class="swiper product-swiper open-up" data-aos="zoom-out">
            <div class="swiper-wrapper d-flex">
                @foreach($bestSellers as $product)
                    <div class="swiper-slide">
                        <div class="product-item image-zoom-effect link-effect">
                            <div class="image-holder">
                                <a href="{{ url('/products/' . $product->duongdan) }}">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ asset($product->images->first()->duongdananh) }}" alt="{{ $product->ten }}"
                                            class="product-image img-fluid">
                                    @else
                                        <img src="{{ asset('images/default-product.jpg') }}" alt="No image"
                                            class="product-image img-fluid">
                                    @endif
                                </a>
                                <a href="javascript:void(0)"
                                    class="btn-icon btn-wishlist toggle-wishlist {{ in_array($product->id, $wishlistIds) ? 'text-danger' : '' }}"
                                    data-id="{{ $product->id }}">

                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </a>
                                <div class="product-content">
                                    <h5 class="text-uppercase fs-5 mt-3">
                                        <a href="{{ url('/products/' . $product->duongdan) }}">{{ $product->ten }}</a>
                                    </h5>
                                    <a href="#" class="text-decoration-none" data-after="Thêm vào giỏ">
                                        <span>{{ number_format($product->gia, 0, ',', '.') }}đ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-left"></use>
            </svg></div>
        <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-right"></use>
            </svg></div>
    </div>
</section>
<section class="video py-5 overflow-hidden">
    <div class="container-fluid">
        <div class="row">
            <div class="video-content open-up" data-aos="zoom-out">
                <div class="video-bg">
                    <img src="{{ asset('images/video-image.jpg') }}" alt="video" class="video-image img-fluid">
                </div>
                <div class="video-player">
                    <a class="youtube" href="https://www.youtube.com/embed/pjtsGzQjFM4">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <use xlink:href="#play"></use>
                        </svg>
                        <img src="{{ asset('images/text-pattern.png') }}" alt="pattern" class="text-rotate">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonials py-5 bg-light">
    <div class="section-header text-center mt-5">
        <h3 class="section-title">PHỤ HUYNH NÓI GÌ VỀ CHÚNG TÔI?</h3>
    </div>
    <div class="swiper testimonial-swiper overflow-hidden my-5">
        <div class="swiper-wrapper d-flex">

            <div class="swiper-slide">
                <div class="testimonial-item text-center">
                    <blockquote>
                        <p>“Chất vải cực kỳ mềm mịn, bé nhà mình da nhạy cảm mà mặc cả ngày không bị hằn đỏ. Sẽ ủng hộ
                            shop dài dài!”</p>
                        <div class="review-title text-uppercase">Mẹ bé Tít</div>
                    </blockquote>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="testimonial-item text-center">
                    <blockquote>
                        <p>“Form váy rất đứng dáng, y hệt như hình trên web. Lần đầu mua online đồ cho con mà ưng ý đến
                            vậy.”</p>
                        <div class="review-title text-uppercase">Chị Lan Hương</div>
                    </blockquote>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="testimonial-item text-center">
                    <blockquote>
                        <p>“Đóng gói rất cẩn thận và đẹp mắt, giao hàng siêu nhanh. Bộ đồ mặc nhà giặt máy không hề bị
                            bai dão.”</p>
                        <div class="review-title text-uppercase">Gia đình Dâu Tây</div>
                    </blockquote>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="testimonial-item text-center">
                    <blockquote>
                        <p>“Shop tư vấn size rất chuẩn, bé nhà mình mặc vừa in. Đồ đẹp, giá cả hợp lý, 10 điểm chất
                            lượng!”</p>
                        <div class="review-title text-uppercase">Anh Tuấn Minh</div>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial-swiper-pagination d-flex justify-content-center mb-5"></div>
</section>

<section id="related-products" class="related-products product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
            <h4 class="text-uppercase">Có Thể Bé Sẽ Thích</h4>
            <a href="{{ url('/products') }}" class="btn-link">Xem tất cả sản phẩm</a>
        </div>
        <div class="swiper product-swiper open-up" data-aos="zoom-out">
            <div class="swiper-wrapper d-flex">
                @foreach($suggestedProducts as $product)
                    <div class="swiper-slide">
                        <div class="product-item image-zoom-effect link-effect">
                            <div class="image-holder">
                                <a href="{{ url('/products/' . $product->duongdan) }}">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ asset($product->images->first()->duongdananh) }}" alt="{{ $product->ten }}"
                                            class="product-image img-fluid">
                                    @else
                                        <img src="{{ asset('images/default-product.jpg') }}" alt="No image"
                                            class="product-image img-fluid">
                                    @endif
                                </a>
                                <a href="javascript:void(0)"
                                    class="btn-icon btn-wishlist toggle-wishlist {{ in_array($product->id, $wishlistIds) ? 'text-danger' : '' }}"
                                    data-id="{{ $product->id }}">

                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </a>
                                <div class="product-content">
                                    <h5 class="text-uppercase fs-5 mt-3">
                                        <a href="{{ url('/products/' . $product->duongdan) }}">{{ $product->ten }}</a>
                                    </h5>
                                    <a href="#" class="text-decoration-none" data-after="Thêm vào giỏ">
                                        <span>{{ number_format($product->gia, 0, ',', '.') }}đ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-left"></use>
            </svg></div>
        <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-right"></use>
            </svg></div>
    </div>
</section>
<section class="logo-bar py-5 my-5">
    <div class="container">
        <div class="row">
            <div class="logo-content d-flex flex-wrap justify-content-between">
                <img src="{{ asset('images/logo1.png') }}" alt="logo thương hiệu" class="logo-image img-fluid">
                <img src="{{ asset('images/logo2.png') }}" alt="logo thương hiệu" class="logo-image img-fluid">
                <img src="{{ asset('images/logo3.png') }}" alt="logo thương hiệu" class="logo-image img-fluid">
                <img src="{{ asset('images/logo4.png') }}" alt="logo thương hiệu" class="logo-image img-fluid">
                <img src="{{ asset('images/logo5.png') }}" alt="logo thương hiệu" class="logo-image img-fluid">
            </div>
        </div>
    </div>
</section>

<section class="newsletter bg-light" style="background: url('{{ asset('images/pattern-bg.png') }}') no-repeat;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 py-5 my-5">
                <div class="subscribe-header text-center pb-3">
                    <h3 class="section-title text-uppercase">Đăng ký nhận bản tin</h3>
                </div>
                <form id="form" class="d-flex flex-wrap gap-2">
                    <input type="text" name="email" placeholder="Nhập địa chỉ email của bạn"
                        class="form-control form-control-lg">
                    <button class="btn btn-dark btn-lg text-uppercase w-100">Đăng Ký</button>
                </form>
            </div>
        </div>
    </div>
</section>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tìm tất cả các nút trái tim trên màn hình
        let wishlistButtons = document.querySelectorAll('.toggle-wishlist');

        wishlistButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Ngăn chặn web nhảy lên đầu trang

                let sanphamId = this.getAttribute('data-id');
                let heartBtn = this; // Lưu lại cái nút vừa bị bấm
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Bắn tín hiệu siêu tốc (AJAX) lên Controller
                fetch('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ sanpham_id: sanphamId })
                })
                    .then(response => {
                        if (response.status === 401) { // Bắt lỗi chưa đăng nhập
                            alert('Vui lòng đăng nhập để sử dụng chức năng này!');
                            window.location.href = '{{ route("login") }}';
                            throw new Error('Chưa đăng nhập');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // 1. ĐỔI MÀU TRÁI TIM TẠI CHỖ
                        if (data.status === 'added') {
                            heartBtn.classList.add('text-danger');
                        } else if (data.status === 'removed') {
                            heartBtn.classList.remove('text-danger');
                        }

                        // 2. CẬP NHẬT CON SỐ TRÊN HEADER NGAY LẬP TỨC
                        let badgeHeader = document.getElementById('wishlistItemCount');
                        if (badgeHeader && data.totalItems !== undefined) {
                            badgeHeader.innerText = data.totalItems;

                            // (Hiệu ứng thêm cho sinh động: Nháy nháy cái số cho khách hàng biết)
                            badgeHeader.classList.add('animate__animated', 'animate__rubberBand');
                            setTimeout(() => {
                                badgeHeader.classList.remove('animate__animated', 'animate__rubberBand');
                            }, 1000);
                        }
                    })
                    .catch(error => console.error('Lỗi khi thao tác Wishlist:', error));
            });
        });
    });
</script>
<!-- ==========================================
     KẾT THÚC PHẦN NỘI DUNG (CONTENT)
=========================================== -->

<!-- GỌI PHẦN FOOTER -->
@include('layouts.footer')