@include('layouts.header')

<section id="cart" class="py-5">
    <div class="container">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Giỏ hàng của bạn</h1>
            </div>
        </div>

        <div class="row">
            @if(!$cart || $cart->cartItems->count() === 0)
                <div class="col-12 text-center" id="empty-cart">
                    <div class="py-5 shadow-sm rounded bg-light border">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            class="text-muted mb-4">
                            <path
                                d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z">
                            </path>
                        </svg>
                        <h3 class="text-muted mb-3">Giỏ hàng của bạn đang trống</h3>
                        <p class="text-muted mb-4">Có vẻ như bạn chưa chọn mua sản phẩm nào.</p>
                        <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Tiếp tục mua sắm ngay</a>
                    </div>
                </div>

            @else
                <div class="col-lg-8" id="cart-items">
                    <div class="table-responsive shadow-sm rounded bg-white p-3">
                        <table class="table align-middle table-hover">
                            <thead>
                                <tr class="border-bottom">
                                    <th scope="col" class="ps-3">Sản phẩm</th>
                                    <th scope="col" class="text-center">Số lượng</th>
                                    <th scope="col" class="text-end">Đơn Giá</th>
                                    <th scope="col" class="text-end">Tổng</th>
                                    <th scope="col" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="cart-list">

                                @foreach($cart->cartItems as $item)
                                    <tr class="border-bottom cart-row" data-product-id="{{ $item->sanphamID }}">
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <a href="{{ route('product.detail', $item->product->duongdan) }}">
                                                    @if($item->product->images->isNotEmpty())
                                                        <img src="{{ asset($item->product->images->first()->duongdananh) }}"
                                                            alt="{{ $item->product->ten }}" class="img-fluid rounded border"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/default-product.jpg') }}"
                                                            class="img-fluid rounded border"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @endif
                                                </a>
                                                <div>
                                                    <a href="{{ route('product.detail', $item->product->duongdan) }}"
                                                        class="text-decoration-none text-dark fw-bold mb-1 d-block hover-primary">
                                                        {{ $item->product->ten }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-secondary"
                                                    style="width: 30px; height: 30px; padding: 0;"
                                                    onclick="updateCartQty(this, -1)">−</button>
                                                <input type="number" value="{{ $item->soluong }}" min="1"
                                                    max="{{ $item->product->soluong }}" class="qty-input text-center"
                                                    style="width: 50px; border: 1px solid #ddd; padding: 5px;" readonly>
                                                <button class="btn btn-sm btn-outline-secondary"
                                                    style="width: 30px; height: 30px; padding: 0;"
                                                    onclick="updateCartQty(this, 1)">+</button>
                                            </div>
                                        </td>

                                        <td class="text-end text-primary fw-bold">
                                            {{ number_format($item->gia, 0, ',', '.') }}đ
                                        </td>

                                        <td class="text-end fw-bold text-danger">
                                            {{ number_format($item->gia * $item->soluong, 0, ',', '.') }}đ
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-btn" title="Xóa"
                                                onclick="removeFromCart(this, {{ $item->sanphamID }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4" id="cart-summary">
                    <div class="card border border-light shadow-sm bg-light">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold border-bottom pb-3 mb-4">Tóm tắt đơn hàng</h5>

                            <div class="d-flex justify-content-between mb-3 text-secondary">
                                <span>Tổng sản phẩm:</span>
                                <span class="fw-bold text-dark">{{ $tongSanPham }} sản phẩm</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-secondary">
                                <span>Tạm tính:</span>
                                <span class="fw-bold text-dark">{{ number_format($tamTinh, 0, ',', '.') }}đ</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom text-secondary">
                                <span>Phí vận chuyển:</span>
                                <span class="fw-bold text-dark">{{ number_format($phiVanChuyen, 0, ',', '.') }}đ</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                                <span class="fs-6 fw-bold">Tổng thanh toán:</span>
                                <span
                                    class="fs-4 fw-bold text-danger">{{ number_format($tongThanhToan, 0, ',', '.') }}đ</span>
                            </div>

                            <a href="#" class="btn btn-primary btn-lg w-100 mb-3 fw-bold shadow-sm">Tiến hành Thanh toán</a>
                            <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100"><i
                                    class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm</a>
                        </div>
                    </div>

                    <div class="card border border-light shadow-sm mt-4 bg-white">
                        <div class="card-body p-4">
                            <h6 class="card-title fw-bold mb-3"><i class="fas fa-ticket-alt me-2 text-warning"></i>Mã khuyến
                                mãi</h6>
                            <div class="input-group">
                                <input type="text" class="form-control border-secondary" placeholder="Nhập mã ưu đãi..."
                                    aria-label="Mã khuyến mãi">
                                <button class="btn btn-dark px-4" type="button">Áp dụng</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
    // Hàm xóa sản phẩm (đã làm hôm qua)
    function removeFromCart(buttonElement, productId) {
        if (!confirm('Bạn muốn xóa sản phẩm này khỏi giỏ?')) return;

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route('cart.remove') }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ sanpham_id: productId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Hiệu ứng xóa dòng
                    let productRow = buttonElement.closest('tr');
                    if (productRow) {
                        productRow.style.transition = 'all 0.4s ease';
                        productRow.style.opacity = '0';
                        productRow.style.transform = 'translateX(50px)';
                        setTimeout(() => {
                            productRow.remove();
                            // Tải lại trang nhẹ nhàng để PHP tính lại tổng tiền
                            window.location.reload();
                        }, 400);
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Lỗi:', error));
    }

    // Hàm tạm để nút +/- nhảy số (Sẽ cần viết AJAX gọi server lưu lại sau)
    function updateCartQty(buttonElement, changeAmount) {
        let inputField = buttonElement.parentElement.querySelector('.qty-input');
        let currentVal = parseInt(inputField.value);
        let maxVal = parseInt(inputField.getAttribute('max'));

        let newVal = currentVal + changeAmount;

        if (newVal >= 1 && newVal <= maxVal) {
            inputField.value = newVal;
            // TODO: Ở đây cần gọi 1 hàm AJAX gửi về Server để lưu số lượng mới, rồi load lại tổng tiền. 
            // Tạm thời mình cứ tải lại trang để đảm bảo dữ liệu chuẩn xác nhất
            // window.location.reload(); 
        } else if (newVal > maxVal) {
            alert('Xin lỗi, sản phẩm này chỉ còn ' + maxVal + ' mặt hàng!');
        }
    }
</script>

<style>
    #cart .hover-primary:hover {
        color: #0d6efd !important;
    }

    #cart .qty-input:focus {
        outline: none;
    }

    /* Ẩn mũi tên lên xuống của thẻ input number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

@include('layouts.footer')