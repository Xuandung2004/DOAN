@include('layouts.header')
<meta name="csrf-token" content="{{ csrf_token() }}">

<section id="products" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Tất cả sản phẩm</h1>
            </div>
        </div>

        <div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12 text-center">
                <a href="{{ route('products') }}" class="btn btn-link text-decoration-none me-3 fw-bold">Tất cả</a>
                @foreach($danhmucs as $dm)
                    <a href="{{ route('products', ['danhmuc' => $dm->id]) }}"
                        class="btn btn-link text-decoration-none me-3">
                        {{ $dm->ten }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="row">
            @if($sanphams->count() > 0)
                @foreach($sanphams as $index => $sp)
                    @php $delay = ($index % 4) * 100 + 100; @endphp

                    <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $delay }}">
                        <div class="product-item">
                            <div class="product-image position-relative overflow-hidden rounded-3">
                                <a href="{{ route('product.detail', $sp->duongdan) }}">
                                    @if($sp->images->isNotEmpty())
                                        <img src="{{ asset($sp->images->first()->duongdananh) }}" alt="{{ $sp->ten }}"
                                            class="img-fluid">
                                    @else
                                        <img src="{{ asset('images/default-product.jpg') }}" alt="Chưa có ảnh" class="img-fluid">
                                    @endif
                                </a>
                                <div class="product-overlay d-flex align-items-center justify-content-center position-absolute">
                                    <a href="{{ route('product.detail', $sp->duongdan) }}" class="btn btn-light btn-sm">Xem chi
                                        tiết</a>
                                </div>
                            </div>

                            <div class="product-content text-center py-3 px-2">
                                <h5 class="product-title text-truncate" title="{{ $sp->ten }}">{{ $sp->ten }}</h5>

                                <p class="product-category text-muted small mb-2">
                                    {{ $sp->category ? $sp->category->ten : 'Chưa phân loại' }}
                                </p>

                                <div class="product-rating mb-2">
                                    <span class="star text-warning">★</span>
                                    <span>{{ number_format($sp->diemtrungbinh, 1) }}/5.0</span>
                                </div>

                                <div class="product-price">
                                    @if($sp->giagiam > 0 && $sp->giagiam < $sp->gia)
                                        <span
                                            class="price text-primary fw-bold">{{ number_format($sp->giagiam, 0, ',', '.') }}₫</span>
                                        <span
                                            class="original-price text-muted text-decoration-line-through ms-2">{{ number_format($sp->gia, 0, ',', '.') }}₫</span>
                                    @else
                                        <span class="price text-primary fw-bold">{{ number_format($sp->gia, 0, ',', '.') }}₫</span>
                                    @endif
                                </div>

                                <button type="button" class="btn btn-primary btn-sm mt-3 w-100"
                                    onclick="addSingleItemToCart({{ $sp->id }})">
                                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">Không tìm thấy sản phẩm nào!</h4>
                    <p>Hãy thử chọn một danh mục khác hoặc xóa bộ lọc tìm kiếm.</p>
                </div>
            @endif
        </div>

        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $sanphams->links() }}
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
        background-color: #f8f9fa;
        /* Thêm nền màu xám nhạt để phòng trường hợp ảnh trong suốt */
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

    .product-content {
        border: 1px solid #e9ecef;
        border-top: none;
        border-radius: 0 0 20px 20px;
    }

    /* Làm đẹp giao diện phân trang mặc định của Laravel */
    nav svg {
        height: 20px;
    }
</style>

<script>
    function addSingleItemToCart(productId) {
        // 1. Lấy mã bảo vệ của Laravel
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // 2. Bắn AJAX về Server (Bếp)
        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                sanpham_id: productId,
                soluong: 1 // Fix cứng mua 1 cái vì đang ở ngoài danh sách
            })
        })
            .then(response => {
                if (response.status === 401) {
                    // Chưa đăng nhập thì đuổi ra trang login
                    alert('Vui lòng đăng nhập để mua hàng!');
                    window.location.href = '{{ route('login') }}';
                    throw new Error('Not logged in');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Thông báo thành công mượt mà
                    alert(data.message);

                    // Nếu có icon giỏ hàng trên header thì update số lượng ở đây
                    // let cartBadge = document.getElementById('cartItemCount');
                    // if (cartBadge) cartBadge.innerText = data.totalItems;
                } else {
                    // Thông báo lỗi (ví dụ hết hàng)
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
@include('layouts.footer')