<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Bước 1: Hiển thị trang Thanh toán (Checkout)
     */
    public function index()
    {
        $cart = Cart::with('cartItems.product')->where('nguoidungID', Auth::id())->first();

        // Chặn khách vào trang thanh toán nếu giỏ hàng trống
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart')->with('thongbao', 'Giỏ hàng của bạn đang trống!');
        }

        $tamTinh = 0;
        $tongSanPham = 0;
        foreach ($cart->cartItems as $item) {
            $tamTinh += ($item->gia * $item->soluong);
            $tongSanPham += $item->soluong;
        }

        $phiVanChuyen = $tongSanPham > 0 ? 30000 : 0;
        $soTienGiam = 0; 
        $maGiamGia = '';

        // ĐỒNG BỘ MÃ GIẢM GIÁ TỪ GIỎ HÀNG SANG
        if (session()->has('coupon')) {
            $couponSession = session()->get('coupon');
            $coupon = Coupon::find($couponSession['id']);

            // Kiểm tra lại xem đơn hàng còn đủ điều kiện không
            if ($coupon && $tamTinh >= $coupon->giatridontoithieu) {
                $soTienGiam = $couponSession['sotiengiam'];
                $maGiamGia = $coupon->ma;
            } else {
                session()->forget('coupon'); // Gỡ mã nếu không đủ điều kiện
            }
        }

        $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;
        if ($tongThanhToan < 0) $tongThanhToan = 0;

        return view('pages.checkout', compact('cart', 'tamTinh', 'phiVanChuyen', 'soTienGiam', 'tongThanhToan', 'maGiamGia'));
    }

    /**
     * Bước 2: Nhận dữ liệu đặt hàng và Lưu vào Database
     */
    public function placeOrder(Request $request)
    {
        // 1. Validate dữ liệu cực kỳ chặt chẽ
        $request->validate([
            'tennguoinhan' => 'required|string|max:255',
            'sodienthoai' => 'required|string|max:20',
            'diachigiaohang' => 'required|string|max:500',
            'phuongthucthanhtoan' => 'required|in:COD,VNPAY', 
            'magiamgia' => 'nullable|string' 
        ], [
            'tennguoinhan.required' => 'Vui lòng nhập họ tên người nhận.',
            'sodienthoai.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'diachigiaohang.required' => 'Vui lòng nhập địa chỉ giao hàng.'
        ]);

        $user = Auth::user();
        $cart = Cart::with('cartItems.product')->where('nguoidungID', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart')->with('thongbao', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();

        try {
            $tamTinh = 0;
            foreach ($cart->cartItems as $item) {
                if ($item->product->soluong < $item->soluong) {
                    throw new \Exception('Sản phẩm "' . $item->product->ten . '" không đủ số lượng trong kho!');
                }
                $tamTinh += ($item->gia * $item->soluong);
            }

            $phiVanChuyen = 30000;
            $soTienGiam = 0;
            $couponId = null;

            // Xử lý Mã giảm giá
            if ($request->filled('magiamgia')) {
                $coupon = Coupon::where('ma', $request->magiamgia)
                                ->where(function($q) {
                                    $q->whereNull('hethan')->orWhere('hethan', '>', now());
                                })
                                ->where('dasudung', '<', DB::raw('gioihansudung')) 
                                ->first();

                if ($coupon && $tamTinh >= $coupon->giatridontoithieu) {
                    $couponId = $coupon->id;
                    $soTienGiam = ($coupon->loai == 'phantram') ? ($tamTinh * $coupon->giatri / 100) : $coupon->giatri;
                    if ($soTienGiam > $tamTinh) $soTienGiam = $tamTinh;
                }
            }

            $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;
            if ($tongThanhToan < 0) $tongThanhToan = 0;

            // 2. Tạo Đơn hàng mới (Lưu trực tiếp 2 trường Tên và SĐT mới thêm)
            $order = Order::create([
                'nguoidungID' => $user->id,
                'tennguoinhan' => $request->tennguoinhan, // Lưu vào cột mới
                'sodienthoai' => $request->sodienthoai,   // Lưu vào cột mới
                'tongtien' => $tongThanhToan,
                'diachigiaohang' => $request->diachigiaohang,
                'phuongthucthanhtoan' => $request->phuongthucthanhtoan,
                'trangthaithanhtoan' => 0, 
                'trangthaidon' => 0,       
                'magiamgiaID' => $couponId,
                'sotiengiam' => $soTienGiam,
            ]);

            // 3. Chuyển sản phẩm từ Giỏ hàng sang Chi tiết đơn hàng
            foreach ($cart->cartItems as $item) {
                OrderItem::create([
                    'donhangID' => $order->id,
                    'sanphamID' => $item->sanphamID,
                    'soluong' => $item->soluong,
                    'gia' => $item->gia
                ]);

                // Trừ tồn kho
                $item->product->decrement('soluong', $item->soluong);
            }

            // Cập nhật lượt dùng Mã giảm giá
            if ($couponId) {
                Coupon::where('id', $couponId)->increment('dasudung');
            }

            // CHIA NHÁNH THANH TOÁN VNPAY
            if ($request->phuongthucthanhtoan === 'VNPAY') {
                DB::commit(); 
                return redirect()->route('cart')->with('thongbao', 'Tính năng VNPay đang được bảo trì!');
            }

            // THANH TOÁN COD: Dọn dẹp giỏ hàng
            $cart->cartItems()->delete(); 
            session()->forget('coupon'); 
            
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.',
                'redirect_url' => route('cart') // Truyền link giỏ hàng về cho JS
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi đặt hàng: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }
}