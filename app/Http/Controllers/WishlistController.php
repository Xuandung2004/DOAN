<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        // 1. Kiểm tra xem khách đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Vui lòng đăng nhập để thêm vào yêu thích!'
            ], 401);
        }

        $sanphamID = $request->sanpham_id;
        $nguoidungID = Auth::id();

        // 2. Tìm xem sản phẩm này đã có trong danh sách yêu thích của người này chưa
        $wishlist = Wishlist::where('nguoidungID', $nguoidungID)
                            ->where('sanphamID', $sanphamID)
                            ->first();

        // 3. Xử lý Bật/Tắt (Toggle)
        if ($wishlist) {
            // Nếu có rồi thì XÓA đi
            $wishlist->delete();
            $status = 'removed';
            $message = 'Đã bỏ khỏi danh sách yêu thích!';
        } else {
            // Nếu chưa có thì THÊM mới
            Wishlist::create([
                'nguoidungID' => $nguoidungID,
                'sanphamID' => $sanphamID
            ]);
            $status = 'added';
            $message = 'Đã thêm vào danh sách yêu thích!';
        }

        // --- ĐOẠN MỚI THÊM: ĐẾM LẠI TỔNG SỐ LƯỢNG SAU KHI THÊM/XÓA ---
        $totalItems = Wishlist::where('nguoidungID', $nguoidungID)->count();

        // 4. Trả về kết quả kèm theo con số totalItems
        return response()->json([
            'status' => $status,
            'message' => $message,
            'totalItems' => $totalItems // JS sẽ bắt lấy con số này để in lên Header
        ]);
    }
    /**
     * Hiển thị trang Danh sách yêu thích
     */
    public function index()
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('thongbao', 'Vui lòng đăng nhập để xem danh sách yêu thích.');
        }

        // 2. Lấy danh sách yêu thích của User (Kèm theo thông tin Product và Ảnh để tối ưu tốc độ)
        $wishlists = Wishlist::with(['product.images'])
                        ->where('nguoidungID', Auth::id())
                        ->orderBy('ngaytao', 'desc')
                        ->get();

        // 3. Trả về View
        return view('pages.wishlist', compact('wishlists'));
    }
}