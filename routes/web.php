<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');


// Thanh toán (Checkout)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

// Gọi bằng phương thức POST để bảo mật (Không để trong middleware auth vì JS sẽ tự bắt lỗi báo cho người dùng)
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
// Trang chủ
Route::get('/', function () {
    return view('layouts.home');
})->name('home');

// ==========================================
// PRODUCT ROUTES (FRONTEND)
// ==========================================
// 1. Trang danh sách sản phẩm (Đã bao gồm tất cả chức năng lọc danh mục, bé trai, bé gái...)
Route::get('/products', [ProductController::class, 'shop'])->name('products');

// 2. Trang chi tiết 1 sản phẩm
Route::get('/product/{slug}', [ProductController::class, 'detail'])->name('product.detail');
// Pages routes
Route::get('/purchase-history', function () {
    return view('pages.purchase-history');
})->name('purchase-history');

Route::get('/promotions', function () {
    return view('pages.promotions');
})->name('promotions');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// ==========================================
// AUTH ROUTES
// ==========================================
Route::middleware('guest')->group(function () {
    // Hiển thị form và xử lý Đăng ký
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Hiển thị form và xử lý Đăng nhập
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Đăng ký các route cho Google OAuth
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
});

// ==========================================
// AUTHENTICATED USER ROUTES
// ==========================================
Route::middleware('auth')->group(function () {
    // Xử lý Đăng xuất (Bắt buộc dùng POST để bảo mật)
    Route::middleware('auth')->group(function () {
    // Xử lý Đăng xuất (Giữ nguyên của ông bạn)
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profile routes: Trỏ về UserController của chúng ta
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    // Bỏ route delete profile đi vì E-commerce không nên cho khách tự xóa sạch tài khoản
    // Quan lý đơn hàng của khách
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
// Quản lý người dùng: Dùng resource nhưng BỎ QUA hàm show và destroy (vì mình không dùng)
    Route::resource('users', UserController::class)->except(['show', 'destroy']);
// Route Custom để Khóa / Mở khóa tài khoản (thay thế cho việc xóa cứng)
    Route::put('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

// Quản lý sản phẩm
    
    // 1. Resource Route cho các chức năng CRUD chuẩn:
    // products.index, products.create, products.store, products.edit, products.update
    Route::resource('products', ProductController::class);

    // 2. Route cho chức năng Ẩn/Hiện sản phẩm (Dùng PATCH vì chỉ cập nhật 1 phần dữ liệu)
    Route::patch('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])
        ->name('products.toggle');

    // 3. Route để xóa 1 ảnh cụ thể của sản phẩm
    Route::delete('products/image/{id}', [ProductController::class, 'destroyImage'])
        ->name('products.destroyImage');
    // index admin
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.index');

    // Quản lý người dùng
    // Route::resource('users', UserController::class);
    // Route::put('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // Quản lý đơn hàng
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});