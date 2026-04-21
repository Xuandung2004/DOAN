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

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');


// Gọi bằng phương thức POST để bảo mật (Không để trong middleware auth vì JS sẽ tự bắt lỗi báo cho người dùng)
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
// Trang chủ
Route::get('/', function () {
    return view('layouts.home');
})->name('home');
Route::get('hello', function () {
    return view('layouts.hello');
});

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

Route::get('/wishlist', function () {
    return view('pages.wishlist');
})->name('wishlist');

Route::get('/cart', function () {
    return view('pages.cart');
})->name('cart');

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
});
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
// Quản lý người dùng: Dùng resource nhưng BỎ QUA hàm show và destroy (vì mình không dùng)
    Route::resource('users', UserController::class)->except(['show', 'destroy']);
// Route Custom để Khóa / Mở khóa tài khoản (thay thế cho việc xóa cứng)
    Route::put('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

//     // Quản lý sản phẩm
//     Route::resource('products', ProductController::class);
//     Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
//     Route::patch('products/{id}/status', [ProductController::class, 'updateStatus'])->name('products.updateStatus');
//     Route::patch('products/{id}/price', [ProductController::class, 'updatePrice'])->name('products.updatePrice');
//     Route::patch('products/{id}/stock', [ProductController::class, 'updateStock'])->name('products.updateStock');
//     Route::delete('products/{anhID}/image', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
});