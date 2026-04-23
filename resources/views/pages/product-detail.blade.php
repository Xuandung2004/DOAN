@include('layouts.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="py-5 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('products') }}" class="text-decoration-none">Sản phẩm</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->ten }}</li>
            </ol>
        </nav>

        <div class="row bg-white p-4 rounded shadow-sm">
            <div class="col-md-5 mb-4 mb-md-0">
                <div class="main-image mb-3 border rounded overflow-hidden"
                    style="aspect-ratio: 1; background: #f8f9fa;">
                    @if($product->images->isNotEmpty())
                        <img id="mainProductImage" src="{{ asset($product->images->first()->duongdananh) }}"
                            alt="{{ $product->ten }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    @else
                        <img id="mainProductImage" src="{{ asset('images/default-product.jpg') }}" alt="Chưa có ảnh"
                            class="img-fluid w-100 h-100" style="object-fit: cover;">
                    @endif
                </div>

                <div class="d-flex gap-2 overflow-auto thumbnails-container">
                    @foreach($product->images as $img)
                        <div class="border rounded cursor-pointer thumbnail-box"
                            onclick="changeMainImage('{{ asset($img->duongdananh) }}')"
                            style="width: 80px; height: 80px; flex-shrink: 0;">
                            <img src="{{ asset($img->duongdananh) }}" class="img-fluid w-100 h-100"
                                style="object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-7 ps-md-5">
                <h2 class="fw-bold mb-3">{{ $product->ten }}</h2>

                <div class="mb-3 d-flex align-items-center">
                    <div class="text-warning me-2">
                        <span class="fw-bold fs-5">{{ number_format($product->diemtrungbinh, 1) }}</span> <i
                            class="fas fa-star"></i>
                    </div>
                    <span class="text-muted">| {{ $product->reviews->count() }} Đánh giá | Đã bán: 120</span>
                </div>

                <div class="price-box mb-4 bg-light p-3 rounded">
                    @if($product->giagiam > 0 && $product->giagiam < $product->gia)
                        <h3 class="text-primary fw-bold mb-0">
                            {{ number_format($product->giagiam, 0, ',', '.') }} VNĐ
                            <small
                                class="text-muted text-decoration-line-through fs-5 ms-2">{{ number_format($product->gia, 0, ',', '.') }}
                                VNĐ</small>
                        </h3>
                    @else
                        <h3 class="text-primary fw-bold mb-0">{{ number_format($product->gia, 0, ',', '.') }} VNĐ</h3>
                    @endif
                </div>

                <div class="description mb-4">
                    <p class="text-secondary">{{ $product->mota }}</p>
                </div>

                <form action="#" method="POST" class="mt-4">
                    @csrf
                    <div class="d-flex align-items-center mb-4">
                        <span class="me-3 fw-bold">Số lượng:</span>
                        <div class="input-group" style="width: 140px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">-</button>
                            <input type="number" name="soluong" id="qtyInput" class="form-control text-center fw-bold"
                                value="1" min="1" max="{{ $product->soluong }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">+</button>
                        </div>
                        <span class="ms-3 text-muted small">(Còn {{ $product->soluong }} sản phẩm)</span>
                    </div>

                    <div class="d-flex gap-3">
                        <form id="addToCartForm" class="mt-4">
                            <input type="hidden" id="sanphamID" value="{{ $product->id }}">
                            <div class="d-flex gap-3">
                                <button type="button" onclick="addToCart()" class="btn btn-primary btn-lg px-5 fw-bold">
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </form>
                        @php
                            $isFavorited = Auth::check() && \App\Models\Wishlist::where('nguoidungID', Auth::id())->where('sanphamID', $product->id)->exists();
                        @endphp

                        <button type="button" class="btn btn-outline-info btn-lg px-4 btn-wishlist"
                            data-id="{{ $product->id }}" onclick="toggleWishlist(this)">
                            <i class="fa{{ $isFavorited ? 's text-danger' : 'r' }} fa-heart wishlist-icon"></i>
                            <span
                                class="wishlist-text">{{ $isFavorited ? 'Đã yêu thích' : 'Thêm vào yêu thích' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-5 bg-white p-4 rounded shadow-sm">
            <div class="col-12">
                <h4 class="fw-bold mb-4 border-bottom pb-2">Đánh giá sản phẩm ({{ $product->reviews->count() }})</h4>

                @if(session('thongbao'))
                    <div class="alert alert-success shadow-sm">
                        <i class="fas fa-check-circle me-2"></i>{{ session('thongbao') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="reviews-list mb-5">
                    @if($product->reviews->count() > 0)
                        @foreach($product->reviews as $review)
                            <div class="d-flex mb-4 border-bottom pb-3">
                                <div class="me-3">
                                    <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ substr($review->user->hoten ?? 'U', 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold mb-1">{{ $review->user->hoten ?? 'Khách hàng' }}</h6>
                                        <small class="text-muted">{{ $review->ngaytao->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-warning small mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= $review->sosao ? 's' : 'r' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="text-secondary mb-1">{{ $review->binhluan }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted fst-italic">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!
                        </p>
                    @endif
                </div>

                <div class="write-review-box bg-light p-4 rounded border">
                    <h5 class="fw-bold mb-3">Viết đánh giá của bạn</h5>
                    @auth
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="sanphamID" value="{{ $product->id }}">

                            <div class="mb-3 d-flex align-items-center">
                                <label class="me-3 fw-bold">Chất lượng:</label>
                                <select name="sosao" class="form-select w-auto" required>
                                    <option value="5">5 Sao (Tuyệt vời)</option>
                                    <option value="4">4 Sao (Tốt)</option>
                                    <option value="3">3 Sao (Bình thường)</option>
                                    <option value="2">2 Sao (Kém)</option>
                                    <option value="1">1 Sao (Tệ)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea name="binhluan" class="form-control" rows="4"
                                    placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Gửi đánh giá</button>
                        </form>
                    @else
                        <div class="alert alert-warning border-0 mb-0">
                            Vui lòng <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Đăng nhập</a> để có
                            thể gửi đánh giá cho sản phẩm này.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function changeMainImage(imgUrl) {
        document.getElementById('mainProductImage').src = imgUrl;
    }

    const qtyInput = document.getElementById('qtyInput');
    const maxQty = parseInt(qtyInput.getAttribute('max'));

    function increaseQty() {
        let currentVal = parseInt(qtyInput.value);
        if (currentVal < maxQty) {
            qtyInput.value = currentVal + 1;
        }
    }

    function decreaseQty() {
        let currentVal = parseInt(qtyInput.value);
        if (currentVal > 1) {
            qtyInput.value = currentVal - 1;
        }
    }

    function toggleWishlist(button) {
        let productId = button.getAttribute('data-id');
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route('wishlist.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ sanpham_id: productId })
        })
            .then(response => {
                if (response.status === 401) {
                    alert('Vui lòng đăng nhập để sử dụng chức năng này!');
                    window.location.href = '{{ route('login') }}';
                    throw new Error('Not logged in');
                }
                return response.json();
            })
            .then(data => {
                let icon = button.querySelector('.wishlist-icon');
                let text = button.querySelector('.wishlist-text');

                if (data.status === 'added') {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-danger');
                    text.innerText = 'Đã yêu thích';
                } else if (data.status === 'removed') {
                    icon.classList.remove('fas', 'text-danger');
                    icon.classList.add('far');
                    text.innerText = 'Thêm vào yêu thích';
                }
                alert(data.message);
            })
            .catch(error => console.error('Error:', error));
    }

    function addToCart() {
        let productId = document.getElementById('sanphamID').value;
        let quantity = document.getElementById('qtyInput').value;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                sanpham_id: productId,
                soluong: quantity
            })
        })
            .then(response => {
                if (response.status === 401) {
                    alert('Vui lòng đăng nhập để mua hàng!');
                    window.location.href = '{{ route('login') }}';
                    throw new Error('Not logged in');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    let cartBadge = document.getElementById('cartItemCount');
                    if (cartBadge) {
                        cartBadge.innerText = data.totalItems;
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<style>
    .cursor-pointer {
        cursor: pointer;
    }

    .thumbnail-box {
        transition: all 0.2s ease;
        border: 2px solid transparent !important;
    }

    .thumbnail-box:hover {
        border-color: #0d6efd !important;
        opacity: 0.8;
    }
</style>

@include('layouts.footer')