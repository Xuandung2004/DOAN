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
            // Nếu có rồi thì XÓA đi (Bỏ yêu thích)
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Đã bỏ khỏi danh sách yêu thích!']);
        } else {
            // Nếu chưa có thì THÊM mới
            Wishlist::create([
                'nguoidungID' => $nguoidungID,
                'sanphamID' => $sanphamID
            ]);
            return response()->json(['status' => 'added', 'message' => 'Đã thêm vào danh sách yêu thích!']);
        }
    }
}