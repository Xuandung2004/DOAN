@include('layouts.header')

<section id="cart" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Giỏ hàng</h1>
            </div>
        </div>

        <div class="row">
            <!-- Empty Cart Message -->
            <div class="col-12 text-center" id="empty-cart">
                <div class="py-5">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        class="text-muted mb-4">
                        <path
                            d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z">
                        </path>
                    </svg>
                    <h3 class="text-muted mb-3">Giỏ hàng của bạn trống</h3>
                    <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ để tiếp tục.</p>
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="col-lg-8" id="cart-items" style="display: none;">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="border-bottom">
                                <th scope="col" class="ps-0">Sản phẩm</th>
                                <th scope="col" class="text-center">Số lượng</th>
                                <th scope="col" class="text-end">Giá</th>
                                <th scope="col" class="text-end">Tổng</th>
                                <th scope="col" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="cart-list">
                            <!-- Sample Item 1 -->
                            <tr class="border-bottom" data-product-id="1">
                                <td class="ps-0">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('images/product-1.jpg') }}" alt="Áo thun bé trai"
                                            class="img-fluid rounded"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-2">Áo thun bé trai</h6>
                                            <small class="text-muted">Màu: Xanh | Size: 6-7 tuổi</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-secondary qty-decrease"
                                            style="width: 30px; height: 30px; padding: 0;">−</button>
                                        <input type="number" value="1" min="1" class="qty-input text-center"
                                            style="width: 50px; border: 1px solid #ddd; padding: 5px;">
                                        <button class="btn btn-sm btn-outline-secondary qty-increase"
                                            style="width: 30px; height: 30px; padding: 0;">+</button>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold">199.000đ</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold item-total">199.000đ</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger remove-btn" title="Xóa">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>

                            <!-- Sample Item 2 -->
                            <tr class="border-bottom" data-product-id="2">
                                <td class="ps-0">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('images/product-2.jpg') }}" alt="Váy bé gái"
                                            class="img-fluid rounded"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-2">Váy bé gái công chúa</h6>
                                            <small class="text-muted">Màu: Hồng | Size: 4-5 tuổi</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-secondary qty-decrease"
                                            style="width: 30px; height: 30px; padding: 0;">−</button>
                                        <input type="number" value="2" min="1" class="qty-input text-center"
                                            style="width: 50px; border: 1px solid #ddd; padding: 5px;">
                                        <button class="btn btn-sm btn-outline-secondary qty-increase"
                                            style="width: 30px; height: 30px; padding: 0;">+</button>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold">349.000đ</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold item-total">698.000đ</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger remove-btn" title="Xóa">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4" id="cart-summary" style="display: none;">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Tóm tắt đơn hàng</h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Tổng sản phẩm:</span>
                            <span class="fw-bold">3 sản phẩm</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính:</span>
                            <span class="fw-bold">897.000đ</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span>Phí vận chuyển:</span>
                            <span class="fw-bold">30.000đ</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-6">Tổng thanh toán:</span>
                            <span class="fs-6 fw-bold">927.000đ</span>
                        </div>

                        <button class="btn btn-primary w-100 mb-2">Tiếp tục thanh toán</button>
                        <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100">Tiếp tục mua sắm</a>
                    </div>
                </div>

                <div class="card border-0 bg-light mt-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Mã khuyến mãi</h6>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nhập mã khuyến mãi"
                                aria-label="Mã khuyến mãi">
                            <button class="btn btn-outline-secondary" type="button">Áp dụng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    #cart .table img {
        border: 1px solid #f0f0f0;
    }

    #cart tbody tr:hover {
        background-color: #f9f9f9;
    }

    #cart .qty-input {
        border-radius: 4px;
    }

    #cart .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>

@include('layouts.footer')