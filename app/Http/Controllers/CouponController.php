<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // ==========================================
    // PHẦN DÀNH CHO ADMIN
    // ==========================================

    /**
     * Use case: Xem danh sách mã giảm giá
     */
    public function index(Request $request)
    {
        $query = Coupon::query();

    // Bắt từ khóa tìm kiếm
    if ($request->has('keyword') && $request->keyword != '') {
        $keyword = $request->keyword;
        // Tìm kiếm theo Mã giảm giá
        $query->where('ma', 'like', '%' . $keyword . '%');
    }

    // Phân trang và giữ nguyên từ khóa trên URL
    $coupons = $query->orderBy('ngaytao', 'desc')->paginate(10)->withQueryString();

    return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Hiển thị form Thêm mới mã giảm giá
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Use case: Lưu mã giảm giá mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'ma' => 'required|string|max:50|unique:magiamgia,ma',
            'loai' => 'required|in:phantram,tienmat',
            'giatri' => 'required|numeric|min:0',
            'giatridontoithieu' => 'nullable|numeric|min:0',
            'gioihansudung' => 'nullable|integer|min:1',
            'hethan' => 'nullable|date|after:today',
        ], [
            'ma.required' => 'Vui lòng nhập mã giảm giá.',
            'ma.unique' => 'Mã này đã tồn tại trên hệ thống.',
            'hethan.after' => 'Ngày hết hạn phải từ ngày mai trở đi.',
        ]);

        Coupon::create([
            'ma' => strtoupper($request->ma), // Tự động viết hoa mã cho đẹp
            'loai' => $request->loai,
            'giatri' => $request->giatri,
            'giatridontoithieu' => $request->giatridontoithieu ?? 0,
            'gioihansudung' => $request->gioihansudung,
            'dasudung' => 0, // Mặc định chưa ai dùng
            'hethan' => $request->hethan,
        ]);

        return redirect()->route('coupons.index')->with('thongbao', 'Thêm mã giảm giá thành công!');
    }

    /**
     * Hiển thị form Sửa mã giảm giá
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Use case: Cập nhật mã giảm giá
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'ma' => 'required|string|max:50|unique:magiamgia,ma,' . $coupon->id,
            'loai' => 'required|in:phantram,tienmat',
            'giatri' => 'required|numeric|min:0',
            'giatridontoithieu' => 'nullable|numeric|min:0',
            'gioihansudung' => 'nullable|integer|min:1',
            'hethan' => 'nullable|date',
        ], [
            'ma.unique' => 'Mã này đã được sử dụng cho chương trình khác.',
        ]);

        $coupon->update([
            'ma' => strtoupper($request->ma),
            'loai' => $request->loai,
            'giatri' => $request->giatri,
            'giatridontoithieu' => $request->giatridontoithieu ?? 0,
            'gioihansudung' => $request->gioihansudung,
            'hethan' => $request->hethan,
        ]);

        return redirect()->route('coupons.index')->with('thongbao', 'Cập nhật mã giảm giá thành công!');
    }
}