<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    // ==========================================
    // PHẦN 1: DÀNH CHO USER (Thêm đánh giá)
    // ==========================================
    public function store(ReviewRequest $request)
    {
        $request->validate([
            'sanphamID' => 'required|exists:sanpham,id',
            'sosao' => 'required|integer|min:1|max:5',
            'binhluan' => 'required|string|max:1000',
        ], [
            'sosao.required' => 'Vui lòng chọn số sao đánh giá.',
            'binhluan.required' => 'Vui lòng nhập nội dung bình luận.'
        ]);

        // 1. Lưu đánh giá
        $review = Review::create([
            'nguoidungID' => Auth::id(),
            'sanphamID' => $request->sanphamID,
            'sosao' => $request->sosao,
            'binhluan' => $request->binhluan,
        ]);

        $review->load('user');
        $tenNguoiDung = $review->user->hoten ?? 'Khách hàng';
        $chuCaiDau = strtoupper(substr($tenNguoiDung, 0, 1));
        // 2. Cập nhật điểm trung bình
        $this->updateProductAverageRating($request->sanphamID);

        // --- ĐOẠN SỬA: TRẢ VỀ JSON THAY VÌ BACK() ---
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm đánh giá thành công! Cảm ơn bạn đã góp ý.',
            'review_data' => [
                'hoten' => $tenNguoiDung,
                'chucai_dau' => $chuCaiDau,
                'sosao' => $request->sosao,
                'binhluan' => $request->binhluan,
                'thoigian' => 'Vừa xong'
            ]
        ]);
        // ---------------------------------------------
    }


    // ==========================================
    // PHẦN 2: DÀNH CHO ADMIN (Quản lý đánh giá)
    // ==========================================
    public function adminIndex(Request $request)
{
    // 1. Khởi tạo query gốc
    $query = Review::with(['product', 'user']);

    // 2. Bắt từ khóa tìm kiếm
    if ($request->has('keyword') && $request->keyword != '') {
        $keyword = $request->keyword;

        $query->where(function($q) use ($keyword) {
            // Tìm trong nội dung bình luận
            $q->where('binhluan', 'like', '%' . $keyword . '%')
              
              // Tìm xuyên qua bảng User (Tên khách hàng)
              ->orWhereHas('user', function($qUser) use ($keyword) {
                  $qUser->where('hoten', 'like', '%' . $keyword . '%');
              })
              
              // Tìm xuyên qua bảng Product (Tên sản phẩm)
              ->orWhereHas('product', function($qProduct) use ($keyword) {
                  $qProduct->where('ten', 'like', '%' . $keyword . '%');
              });
        });
    }

    // 3. Sắp xếp, phân trang (15 dòng) và giữ từ khóa trên URL
    $reviews = $query->orderBy('ngaytao', 'desc')->paginate(15)->withQueryString();

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