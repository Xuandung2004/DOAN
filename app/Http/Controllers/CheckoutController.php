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
            return redirect()->route('cart.index')->with('thongbao', 'Giỏ hàng của bạn đang trống!');
        }

        $tamTinh = 0;
        foreach ($cart->cartItems as $item) {
            $tamTinh += ($item->gia * $item->soluong);
        }

        $phiVanChuyen = 30000; // Phí ship mặc định
        $tongThanhToan = $tamTinh + $phiVanChuyen;

        // Tạm thời chưa xử lý mã giảm giá ở view hiển thị, sẽ làm ở chức năng apply coupon sau
        $soTienGiam = 0; 

        return view('pages.checkout', compact('cart', 'tamTinh', 'phiVanChuyen', 'soTienGiam', 'tongThanhToan'));
    }

    /**
     * Bước 2: Nhận dữ liệu đặt hàng và Lưu vào Database
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'diachigiaohang' => 'required|string|max:500',
            'phuongthucthanhtoan' => 'required|in:COD,VNPAY', // Chỉ nhận 2 phương thức này
            'magiamgia' => 'nullable|string' // Khách nhập mã (chữ) từ form
        ]);

        $user = Auth::user();
        $cart = Cart::with('cartItems.product')->where('nguoidungID', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('thongbao', 'Giỏ hàng trống!');
        }

        // ==========================================
        // BẮT ĐẦU TRANSACTION: KHÓA DATABASE
        // ==========================================
        DB::beginTransaction();

        try {
            // 1. Tính toán lại tiền (Không bao giờ tin tưởng tiền gửi từ Frontend lên)
            $tamTinh = 0;
            foreach ($cart->cartItems as $item) {
                // Tùy chọn: Kiểm tra lại tồn kho ở đây một lần nữa cho chắc
                if ($item->product->soluong < $item->soluong) {
                    throw new \Exception('Sản phẩm ' . $item->product->ten . ' không đủ số lượng trong kho!');
                }
                $tamTinh += ($item->gia * $item->soluong);
            }

            $phiVanChuyen = 30000;
            $soTienGiam = 0;
            $couponId = null;

            // 2. Xử lý Mã giảm giá (Nếu có nhập)
            if ($request->filled('magiamgia')) {
                $coupon = Coupon::where('ma', $request->magiamgia)
                                ->where('hethan', '>', now())
                                ->where('dasudung', '<', DB::raw('gioihansudung')) // Còn lượt dùng
                                ->first();

                if ($coupon && $tamTinh >= $coupon->giatridontoithieu) {
                    $couponId = $coupon->id;
                    // Nếu là giảm % (loai = 'percent'), nếu là giảm tiền mặt (loai = 'fixed')
                    $soTienGiam = ($coupon->loai == 'percent') ? ($tamTinh * $coupon->giatri / 100) : $coupon->giatri;
                }
            }

            $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;
            if ($tongThanhToan < 0) $tongThanhToan = 0;

            // 3. Tạo Đơn hàng (Bảng donhang)
            $order = Order::create([
                'nguoidungID' => $user->id,
                'tongtien' => $tongThanhToan,
                'diachigiaohang' => $request->diachigiaohang,
                'phuongthucthanhtoan' => $request->phuongthucthanhtoan,
                'trangthaithanhtoan' => 0, // Mặc định là 0 (Chờ thanh toán)
                'trangthaidon' => 0,       // 0 (Chờ xử lý)
                'magiamgiaID' => $couponId,
                'sotiengiam' => $soTienGiam,
            ]);

            // 4. Tạo Chi tiết đơn hàng (Bảng donhangchitiet) & Trừ tồn kho
            foreach ($cart->cartItems as $item) {
                OrderItem::create([
                    'donhangID' => $order->id,
                    'sanphamID' => $item->sanphamID,
                    'soluong' => $item->soluong,
                    'gia' => $item->gia
                ]);

                // Trừ tồn kho sản phẩm
                $item->product->decrement('soluong', $item->soluong);
            }

            // 5. Cập nhật lượt dùng của Mã giảm giá
            if ($couponId) {
                Coupon::where('id', $couponId)->increment('dasudung');
            }

            // ==========================================
            // CHIA NHÁNH THANH TOÁN
            // ==========================================
            if ($request->phuongthucthanhtoan === 'VNPAY') {
                // CHƯA XÓA GIỎ HÀNG NGAY!
                DB::commit(); // Lưu đơn hàng để lấy ID truyền sang VNPay
                
                // Trả về hàm xử lý VNPay (Ông bạn sẽ viết code tạo URL VNPay ở đây)
                // return $this->processVNPay($order); 
                
                // Tạm thời báo lỗi nếu chưa làm VNPay
                return redirect()->route('cart.index')->with('thongbao', 'Tính năng VNPay đang được bảo trì!');
            }

            // NẾU LÀ THANH TOÁN COD:
            // 6. Xóa giỏ hàng vì đã đặt xong
            $cart->cartItems()->delete(); 
            
            // XÁC NHẬN LƯU VÀO DATABASE
            DB::commit();

            return redirect()->route('cart.index')->with('thongbao', 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.');

        } catch (\Exception $e) {
            // CÓ LỖI XẢY RA -> QUAY XE, KHÔNG LƯU BẤT CỨ THỨ GÌ VÀO DB
            DB::rollBack();
            Log::error('Lỗi đặt hàng: ' . $e->getMessage());
            
            return redirect()->route('cart.index')->with('thongbao', 'Lỗi: ' . $e->getMessage());
        }
    }
}