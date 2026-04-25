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

                                        <td class="text-end fw-bold text-danger item-total-{{ $item->sanphamID }}">
                                            {{ number_format($item->gia * $item->soluong, 0, ',', '.') }}đ
                                        </td>

                                        <td class="text-center">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger remove-btn d-inline-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px; padding: 0;" title="Xóa khỏi giỏ hàng"
                                                onclick="removeFromCart(this, {{ $item->sanphamID }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
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
                                <span class="fw-bold text-dark" id="cart-item-count">{{ $tongSanPham }} sản phẩm</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-secondary">
                                <span>Tạm tính:</span>
                                <span class="fw-bold text-dark"
                                    id="cart-subtotal">{{ number_format($tamTinh, 0, ',', '.') }}đ</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-secondary">
                                <span>Phí vận chuyển:</span>
                                <span class="fw-bold text-dark">{{ number_format($phiVanChuyen, 0, ',', '.') }}đ</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-success d-none" id="discount-row">
                                <span>Giảm giá (<span id="applied-coupon-code"></span>):</span>
                                <span class="fw-bold" id="cart-discount">-0đ</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4 mt-2 border-top pt-3">
                                <span class="fs-6 fw-bold">Tổng thanh toán:</span>
                                <span class="fs-4 fw-bold text-danger"
                                    id="cart-total">{{ number_format($tongThanhToan, 0, ',', '.') }}đ</span>
                            </div>

                            <a href="{{ route('checkout.index') }}"
                                class="btn btn-primary btn-lg w-100 mb-3 fw-bold shadow-sm">Tiến hành Thanh toán</a>
                            <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>

                    <div class="card border border-light shadow-sm mt-4 bg-white">
                        <div class="card-body p-4">
                            <h6 class="card-title fw-bold mb-3"><i class="fas fa-ticket-alt me-2 text-warning"></i>Mã khuyến
                                mãi</h6>
                            <div class="input-group">
                                <input type="text" id="coupon-code" class="form-control border-secondary text-uppercase"
                                    placeholder="Nhập mã ưu đãi...">

                                <button class="btn btn-dark px-4" id="apply-coupon-btn" type="button"
                                    onclick="applyCoupon()">Áp dụng</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<div id="custom-toast" class="shadow-lg rounded"
    style="display: none; position: fixed; top: 30px; right: 30px; background-color: #28a745; color: white; padding: 15px 25px; z-index: 9999; align-items: center; gap: 10px; transition: opacity 0.4s ease; opacity: 0;">
    <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
    <span id="toast-message" style="font-weight: bold; font-size: 1.1rem;">Thành công!</span>
</div>

<script>
    // 1. HÀM HIỂN THỊ THÔNG BÁO XANH LÁ (TOAST)
    function showSuccessToast(message) {
        let toast = document.getElementById('custom-toast');
        document.getElementById('toast-message').innerText = message;

        toast.style.display = 'flex';
        setTimeout(() => { toast.style.opacity = '1'; }, 10);

        // Sau 3 giây tự biến mất
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => { toast.style.display = 'none'; }, 400);
        }, 3000);
    }

    // 2. HÀM XÓA SẢN PHẨM KHỎI GIỎ (Bỏ confirm, Xóa thẳng tay)
    function removeFromCart(buttonElement, productId) {
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
                    let productRow = buttonElement.closest('tr');
                    if (productRow) {
                        // Hiệu ứng bay màu sang phải
                        productRow.style.transition = 'all 0.4s ease';
                        productRow.style.opacity = '0';
                        productRow.style.transform = 'translateX(50px)';

                        setTimeout(() => {
                            productRow.remove(); // Xóa dòng HTML

                            // Cập nhật lại các con số tiền bên cột Tóm tắt
                            document.getElementById('cart-subtotal').innerText = data.subtotal;
                            document.getElementById('cart-total').innerText = data.total;
                            document.getElementById('cart-item-count').innerText = data.totalItemsCount + ' sản phẩm';

                            // --- XỬ LÝ GIAO DIỆN MÃ GIẢM GIÁ KHI XÓA SẢN PHẨM ---
                            let discountRow = document.getElementById('discount-row');
                            let applyBtn = document.getElementById('apply-coupon-btn');
                            let codeInput = document.getElementById('coupon-code');

                            if (data.hasCoupon) {
                                document.getElementById('cart-discount').innerText = '-' + data.discount;
                            } else {
                                // Nếu mất mã -> Ẩn dòng giảm giá, mở khóa ô nhập mã
                                if (discountRow) discountRow.classList.add('d-none');
                                if (codeInput) {
                                    codeInput.readOnly = false;
                                    codeInput.value = '';
                                }
                                if (applyBtn) {
                                    applyBtn.innerText = 'Áp dụng';
                                    applyBtn.classList.replace('btn-success', 'btn-dark');
                                    applyBtn.disabled = false;
                                }
                                // Cảnh báo khách hàng
                                if (data.couponMessage) {
                                    showGlobalToast(data.couponMessage, 'warning');
                                }
                            }
                            // --------------------------------------------------
                            let cartBadge = document.getElementById('cartItemCount'); // Thay ID cho đúng với HTML của ông bạn
                            if (cartBadge) cartBadge.innerText = data.totalItemsCount;
                            // Hiện thông báo góc phải
                            showSuccessToast(data.message);

                            // Nếu xóa hết sạch đồ trong giỏ thì mới load lại trang
                            if (data.totalItemsCount === 0) {
                                window.location.reload();
                            }
                        }, 400);
                    }
                } else {
                    showGlobalToast(data.message, 'error');
                }
            })
            .catch(error => console.error('Lỗi:', error));
    }

    // 3. HÀM CẬP NHẬT SỐ LƯỢNG (+ / -)
    function updateCartQty(buttonElement, changeAmount) {
        let tr = buttonElement.closest('tr');
        let productId = tr.getAttribute('data-product-id');
        let inputField = buttonElement.parentElement.querySelector('.qty-input');

        let currentVal = parseInt(inputField.value);
        let maxVal = parseInt(inputField.getAttribute('max'));
        let newVal = currentVal + changeAmount;

        if (newVal >= 1 && newVal <= maxVal) {
            inputField.value = newVal;
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route('cart.update') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ sanpham_id: productId, soluong: newVal })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.querySelector('.item-total-' + productId).innerText = data.itemTotal;
                        document.getElementById('cart-subtotal').innerText = data.subtotal;
                        document.getElementById('cart-total').innerText = data.total;
                        document.getElementById('cart-item-count').innerText = data.totalItemsCount + ' sản phẩm';
                        // Cập nhật số trên Header
                        let cartBadge = document.getElementById('cartItemCount');
                        if (cartBadge) cartBadge.innerText = data.totalItemsCount;
                        // --- XỬ LÝ GIAO DIỆN MÃ GIẢM GIÁ KHI TĂNG/GIẢM SỐ LƯỢNG ---
                        let discountRow = document.getElementById('discount-row');
                        let applyBtn = document.getElementById('apply-coupon-btn');
                        let codeInput = document.getElementById('coupon-code');

                        if (data.hasCoupon) {
                            document.getElementById('cart-discount').innerText = '-' + data.discount;
                        } else {
                            // Nếu mất mã -> Ẩn dòng giảm giá, mở khóa ô nhập mã
                            if (discountRow) discountRow.classList.add('d-none');
                            if (codeInput) {
                                codeInput.readOnly = false;
                                codeInput.value = '';
                            }
                            if (applyBtn) {
                                applyBtn.innerText = 'Áp dụng';
                                applyBtn.classList.replace('btn-success', 'btn-dark');
                                applyBtn.disabled = false;
                            }
                            // Cảnh báo khách hàng
                            if (data.couponMessage) {
                                showGlobalToast(data.couponMessage, 'warning'); // Cảnh báo vàng
                            }
                        }
                        // ---------------------------------------------------------
                    } else {
                        showGlobalToast(data.message, 'error');
                        inputField.value = currentVal;
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        } else if (newVal > maxVal) {
            showGlobalToast('Xin lỗi, sản phẩm này trong kho chỉ còn ' + maxVal + ' chiếc!', 'error');
        }
    }

    // 4. HÀM ÁP MÃ GIẢM GIÁ (Dùng Toast)
    function applyCoupon() {
        let codeInput = document.getElementById('coupon-code');
        let applyBtn = document.getElementById('apply-coupon-btn');
        let code = codeInput.value.trim();

        if (!code) {
            alert('Vui lòng nhập mã giảm giá!');
            return;
        }

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        applyBtn.disabled = true;
        applyBtn.innerText = 'Đang xử lý...';

        fetch('{{ route('cart.applyCoupon') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ma_giam_gia: code })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showSuccessToast(data.message); // Gọi Toast ra thay cho Alert

                    document.getElementById('discount-row').classList.remove('d-none');
                    document.getElementById('applied-coupon-code').innerText = code.toUpperCase();

                    document.getElementById('cart-discount').innerText = '-' + data.soTienGiam;
                    document.getElementById('cart-total').innerText = data.tongThanhToan;

                    codeInput.readOnly = true;
                    applyBtn.innerText = 'Đã áp dụng';
                    applyBtn.classList.replace('btn-dark', 'btn-success');
                } else {
                    showGlobalToast(data.message, 'error');
                    applyBtn.disabled = false;
                    applyBtn.innerText = 'Áp dụng';
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                applyBtn.disabled = false;
                applyBtn.innerText = 'Áp dụng';
            });
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