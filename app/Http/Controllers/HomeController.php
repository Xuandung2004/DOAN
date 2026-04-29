<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách ID sản phẩm khách đã thích (Nếu chưa đăng nhập thì mảng rỗng)
    $wishlistIds = Auth::check() ? \App\Models\Wishlist::where('nguoidungID', Auth::id())->pluck('sanphamID')->toArray() : [];
        // 1. HÀNG MỚI VÊ: Lấy 8 sản phẩm mới nhất
        $newProducts = Product::with('images')
            ->where('trangthai', 1)
            ->orderBy('ngaytao', 'desc')
            ->take(8)
            ->get();

        // 2. SẢN PHẨM BÁN CHẠY: Lấy 8 sản phẩm có Điểm trung bình cao nhất 
        // (Nếu Database của ông bạn có cột 'daban' thì thay 'diemtrungbinh' thành 'daban' nhé)
        $bestSellers = Product::with('images')
            ->where('trangthai', 1)
            ->orderBy('diemtrungbinh', 'desc')
            ->take(8)
            ->get();

        // 3. CÓ THỂ BÉ SẼ THÍCH: Gợi ý ngẫu nhiên 8 sản phẩm
        $suggestedProducts = Product::with('images')
            ->where('trangthai', 1)
            ->inRandomOrder() // Hàm này của Laravel tự động lấy random, rất xịn!
            ->take(8)
            ->get();

        return view('layouts.home', compact('newProducts', 'bestSellers', 'suggestedProducts', 'wishlistIds'));
    }
    public function promotions()
{
    // Lấy các mã chưa hết hạn và chưa hết lượt dùng
    $coupons = \App\Models\Coupon::where(function($q) {
                                    $q->whereNull('hethan')->orWhere('hethan', '>', now());
                                 })
                                 ->where('dasudung', '<', \Illuminate\Support\Facades\DB::raw('gioihansudung'))
                                 ->get();

    return view('pages.promotions', compact('coupons'));
}
}