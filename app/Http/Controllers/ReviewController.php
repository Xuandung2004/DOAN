<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // ==========================================
    // PHẦN 1: DÀNH CHO USER (Thêm đánh giá)
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'sanphamID' => 'required|exists:sanpham,id',
            'sosao' => 'required|integer|min:1|max:5',
            'binhluan' => 'required|string|max:1000', // Đã đổi thành binhluan
        ], [
            'sosao.required' => 'Vui lòng chọn số sao đánh giá.',
            'binhluan.required' => 'Vui lòng nhập nội dung bình luận.'
        ]);

        // 1. Lưu đánh giá vào bảng DANH_GIA
        Review::create([
            'nguoidungID' => Auth::id(),
            'sanphamID' => $request->sanphamID,
            'sosao' => $request->sosao,
            'binhluan' => $request->binhluan, // Đã đổi thành binhluan
        ]);

        // 2. Tự động tính toán và cập nhật lại điểm trung bình của Sản phẩm
        $this->updateProductAverageRating($request->sanphamID);

        return back()->with('thongbao', 'Thêm đánh giá thành công! Cảm ơn bạn đã góp ý.');
    }


    // ==========================================
    // PHẦN 2: DÀNH CHO ADMIN (Quản lý đánh giá)
    // ==========================================
    public function adminIndex()
    {
        // Truy xuất kết hợp bảng SAN_PHAM và NGUOI_DUNG
        $reviews = Review::with(['product', 'user'])->orderBy('ngaytao', 'desc')->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $sanphamID = $review->sanphamID; // Lưu lại ID sản phẩm trước khi xóa

        // 1. Xóa bản ghi
        $review->delete();

        // 2. Tính lại điểm trung bình cho sản phẩm sau khi xóa
        $this->updateProductAverageRating($sanphamID);

        return back()->with('thongbao', 'Xóa đánh giá thành công!');
    }


    // ==========================================
    // HÀM DÙNG CHUNG: Tính lại điểm trung bình
    // ==========================================
    private function updateProductAverageRating($productId)
    {
        // Lấy trung bình cộng cột 'sosao' của sản phẩm này
        $averageRating = Review::where('sanphamID', $productId)->avg('sosao');
        
        // Cập nhật vào cột 'diemtrungbinh' của bảng SAN_PHAM (Làm tròn 1 chữ số, vd: 4.5)
        Product::where('id', $productId)->update([
            'diemtrungbinh' => round($averageRating ?? 0, 1) 
        ]);
    }
}