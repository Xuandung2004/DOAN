@include('layouts.header')

<section id="wishlist" class="py-5">
    <div class="container">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Danh sách yêu thích</h1>
            </div>
        </div>

        <div class="row">
            @if($wishlists->isEmpty())
                <div class="col-12 text-center" id="empty-wishlist">
                    <div class="py-5 shadow-sm rounded bg-light border">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="text-muted mb-4">
                            <path d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z"></path>
                        </svg>
                        <h3 class="text-muted mb-3">Danh sách yêu thích của bạn trống</h3>
                        <p class="text-muted mb-4">Thêm các sản phẩm yêu thích để dễ dàng mua sắm sau này.</p>
                        <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
                    </div>
                </div>

            @else
                <div class="col-12" id="wishlist-items">
                    <div class="table-responsive mb-4 shadow-sm rounded bg-white p-3">
                        <table class="table align-middle table-hover">
                            <thead>
                                <tr class="border-bottom">
                                    <th scope="col" class="ps-3">Sản phẩm</th>
                                    <th scope="col" class="text-end">Đơn Giá</th>
                                    <th scope="col" class="text-end pe-3">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="wishlist-list">
                                
                                @foreach($wishlists as $item)
                                    <tr class="border-bottom wishlist-row" data-product-id="{{ $item->product->id }}">
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <a href="{{ route('product.detail', $item->product->duongdan) }}">
                                                    @if($item->product->images->isNotEmpty())
                                                        <img src="{{ asset($item->product->images->first()->duongdananh) }}" alt="{{ $item->product->ten }}" class="img-fluid rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/default-product.jpg') }}" class="img-fluid rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                                                    @endif
                                                </a>
                                                <div>
                                                    <a href="{{ route('product.detail', $item->product->duongdan) }}" class="text-decoration-none text-dark fw-bold mb-1 d-block hover-primary">
                                                        {{ $item->product->ten }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="text-end">
                                            @if($item->product->giagiam > 0 && $item->product->giagiam < $item->product->gia)
                                                <span class="fw-bold text-primary">{{ number_format($item->product->giagiam, 0, ',', '.') }}đ</span>
                                                <br><small class="text-muted text-decoration-line-through">{{ number_format($item->product->gia, 0, ',', '.') }}đ</small>
                                            @else
                                                <span class="fw-bold text-primary">{{ number_format($item->product->gia, 0, ',', '.') }}đ</span>
                                            @endif
                                        </td>
                                        
                                        <td class="text-end pe-3">
                                            <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="addSingleItemToCart({{ $item->product->id }})">
                                                <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                                            </button>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="removeWishlistItem(this, {{ $item->product->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <a href="{{ route('products') }}" class="btn btn-outline-secondary me-2">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
    // 1. Hàm Xóa khỏi Wishlist mượt mà
    function removeWishlistItem(buttonElement, productId) {
        if (!confirm('Bạn muốn xóa sản phẩm này khỏi danh sách yêu thích?')) return;

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Lợi dụng luôn hàm toggle (Bật/Tắt) mà mình viết hôm qua
        fetch('{{ route('wishlist.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ sanpham_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'removed') {
                // Xóa dòng HTML trên màn hình
                let row = buttonElement.closest('tr');
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(50px)';
                
                setTimeout(() => { 
                    row.remove(); 
                    
                    // Giảm số lượng trên Header
                    let countBadge = document.getElementById('wishlistItemCount');
                    if(countBadge) {
                        countBadge.innerText = Math.max(0, parseInt(countBadge.innerText) - 1);
                    }

                    // Nếu xóa hết sạch thì load lại trang để hiện cái bảng "Wishlist trống"
                    if(document.querySelectorAll('.wishlist-row').length === 0) {
                        window.location.reload();
                    }
                }, 300);
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }

    // 2. Hàm Thêm vào giỏ hàng (Giống hệt ở trang Danh sách sản phẩm)
    function addSingleItemToCart(productId) {
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
                soluong: 1 
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Đã thêm sản phẩm vào giỏ hàng!');
                // Update số trên Header
                let cartBadge = document.getElementById('cartItemCount');
                if (cartBadge) cartBadge.innerText = data.totalItems;
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }
</script>

<style>
    #wishlist .table img { border: 1px solid #f0f0f0; }
    #wishlist .btn-outline-primary:hover { background-color: #0d6efd; color: white; }
    #wishlist tbody tr:hover { background-color: #f9f9f9; }
    #wishlist .hover-primary:hover { color: #0d6efd !important; }
</style>

@include('layouts.footer')