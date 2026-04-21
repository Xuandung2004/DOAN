@include('layouts.header')

<section id="wishlist" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="section-title text-center mb-5" data-aos="fade-up">Danh sách yêu thích</h1>
            </div>
        </div>

        <div class="row">
            <!-- Empty Wishlist Message -->
            <div class="col-12 text-center" id="empty-wishlist">
                <div class="py-5">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        class="text-muted mb-4">
                        <path
                            d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z">
                        </path>
                    </svg>
                    <h3 class="text-muted mb-3">Danh sách yêu thích của bạn trống</h3>
                    <p class="text-muted mb-4">Thêm các sản phẩm yêu thích để dễ dàng truy cập sau này.</p>
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
                </div>
            </div>

            <!-- Wishlist Items -->
            <div class="col-12" id="wishlist-items" style="display: none;">
                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead>
                            <tr class="border-bottom">
                                <th scope="col" class="ps-0">Sản phẩm</th>
                                <th scope="col" class="text-end">Giá</th>
                                <th scope="col" class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="wishlist-list">
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
                                <td class="text-end">
                                    <span class="fw-bold">199.000đ</span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary me-2 add-to-cart-btn">Thêm vào
                                        giỏ</button>
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
                                <td class="text-end">
                                    <span class="fw-bold">349.000đ</span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary me-2 add-to-cart-btn">Thêm vào
                                        giỏ</button>
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

                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{ route('products') }}" class="btn btn-outline-secondary me-2">Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    #wishlist .table img {
        border: 1px solid #f0f0f0;
    }

    #wishlist .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }

    #wishlist tbody tr:hover {
        background-color: #f9f9f9;
    }
</style>

@include('layouts.footer')