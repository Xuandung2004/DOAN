<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;

class CartController extends Controller
{
    /**
     * Hiển thị trang Giỏ hàng
     */
    public function index()
    {
        // Kiểm tra xem khách đã đăng nhập chưa
        if (!Auth::check()) {
            // Nếu chưa thì chuyển hướng về trang Login
            return redirect()->route('login')->with('thongbao', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        // Lấy giỏ hàng của user hiện tại, kèm theo thông tin chi tiết sản phẩm và ảnh
        $cart = Cart::with(['cartItems.product.images'])->where('nguoidungID', Auth::id())->first();

        // Tính tổng tiền tạm tính
        $tamTinh = 0;
        $tongSanPham = 0;

        if ($cart) {
            foreach ($cart->cartItems as $item) {
                $tamTinh += ($item->gia * $item->soluong);
                $tongSanPham += $item->soluong;
            }
        }

        // Phí vận chuyển (ví dụ 30k cố định, nếu chưa có hàng thì 0đ)
        $phiVanChuyen = ($tamTinh > 0) ? 30000 : 0; 
        $tongThanhToan = $tamTinh + $phiVanChuyen;

        return view('pages.cart', compact('cart', 'tamTinh', 'tongSanPham', 'phiVanChuyen', 'tongThanhToan'));
    }
    /**
     * Thêm sản phẩm vào giỏ hàng (Xử lý bằng AJAX)
     */
    public function addToCart(Request $request)
    {
        // 1. Kiểm tra đăng nhập (Bảng GioHang bắt buộc phải có nguoidungID)
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Vui lòng đăng nhập để mua hàng!'
            ], 401);
        }

        $sanphamID = $request->sanpham_id;
        $soluongMua = $request->soluong ?? 1;

        // 2. Tìm thông tin sản phẩm và kiểm tra tồn kho
        $product = Product::findOrFail($sanphamID);
        if ($product->soluong < $soluongMua) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Sản phẩm này chỉ còn ' . $product->soluong . ' mặt hàng!'
            ], 400);
        }

        // Giá bán (Nếu có giá giảm thì lấy giá giảm)
        $giaBan = ($product->giagiam > 0 && $product->giagiam < $product->gia) ? $product->giagiam : $product->gia;

        // 3. Tìm Giỏ hàng của user, nếu chưa có thì tự động tạo mới (firstOrCreate)
        $cart = Cart::firstOrCreate(['nguoidungID' => Auth::id()]);

        // 4. Kiểm tra sản phẩm đã có trong giỏ chưa
        $cartItem = CartItem::where('giohangID', $cart->id)
                            ->where('sanphamID', $sanphamID)
                            ->first();

        if ($cartItem) {
            // Có rồi thì cộng dồn số lượng
            $cartItem->soluong += $soluongMua;
            $cartItem->save();
        } else {
            // Chưa có thì tạo dòng mới
            CartItem::create([
                'giohangID' => $cart->id,
                'sanphamID' => $sanphamID,
                'soluong'   => $soluongMua,
                'gia'       => $giaBan
            ]);
        }

        // Lấy tổng số lượng item trong giỏ để cập nhật icon giỏ hàng trên Header (nếu cần)
        $totalItems = CartItem::where('giohangID', $cart->id)->sum('soluong');

        return response()->json([
            'status' => 'success', 
            'message' => 'Đã thêm ' . $product->ten . ' vào giỏ hàng!',
            'totalItems' => $totalItems
        ]);
    }
    /**
     * Xóa sản phẩm khỏi giỏ hàng (AJAX)
     */
    // 1. HÀM CẬP NHẬT SỐ LƯỢNG (Đã vá lỗi mã giảm giá)
    public function updateCart(Request $request)
    {
        $request->validate([
            'sanpham_id' => 'required|exists:sanpham,id',
            'soluong' => 'required|integer|min:1'
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $cart = \App\Models\Cart::where('nguoidungID', $user->id)->first();

        if (!$cart) return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống']);

        $cartItem = \App\Models\CartItem::where('giohangID', $cart->id)
                                        ->where('sanphamID', $request->sanpham_id)
                                        ->first();

        if (!$cartItem) return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);

        $product = \App\Models\Product::find($request->sanpham_id);
        
        if ($request->soluong > $product->soluong) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm trong kho chỉ còn ' . $product->soluong]);
        }

        $cartItem->soluong = $request->soluong;
        $cartItem->save();

        // Tính Tạm tính mới
        $cart->load('cartItems.product');
        $tamTinh = 0;
        $tongSanPham = 0;
        foreach ($cart->cartItems as $item) {
            $tamTinh += ($item->gia * $item->soluong);
            $tongSanPham += $item->soluong;
        }

        $phiVanChuyen = 30000;

        // --- ĐOẠN MỚI: TÍNH LẠI MÃ GIẢM GIÁ ---
        $soTienGiam = 0;
        $thongBaoHuyMa = '';
        if (session()->has('coupon')) {
            $couponSession = session()->get('coupon');
            $coupon = \App\Models\Coupon::find($couponSession['id']);

            // Nếu đơn hàng vẫn đủ điều kiện tối thiểu thì tính lại tiền giảm
            if ($coupon && $tamTinh >= $coupon->giatridontoithieu) {
                if ($coupon->loai == 'phantram') {
                    $soTienGiam = ($tamTinh * $coupon->giatri) / 100;
                } else {
                    $soTienGiam = $coupon->giatri;
                }
                if ($soTienGiam > $tamTinh) $soTienGiam = $tamTinh;

                // Lưu mức giảm mới vào Session
                session()->put('coupon', [
                    'id' => $coupon->id,
                    'ma' => $coupon->ma,
                    'sotiengiam' => $soTienGiam
                ]);
            } else {
                // Nếu tiền tụt quá mức cho phép -> Hủy luôn mã giảm giá
                session()->forget('coupon');
                $thongBaoHuyMa = 'Mã giảm giá đã bị gỡ do tổng đơn không đủ điều kiện!';
            }
        }
        // -------------------------------------

        $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;

        return response()->json([
            'status' => 'success',
            'itemTotal' => number_format($cartItem->gia * $cartItem->soluong, 0, ',', '.') . 'đ',
            'subtotal' => number_format($tamTinh, 0, ',', '.') . 'đ',
            'total' => number_format($tongThanhToan, 0, ',', '.') . 'đ',
            'totalItemsCount' => $tongSanPham,
            'discount' => number_format($soTienGiam, 0, ',', '.') . 'đ',
            'hasCoupon' => $soTienGiam > 0,
            'couponMessage' => $thongBaoHuyMa
        ]);
    }

    // 2. HÀM XÓA SẢN PHẨM (Đã vá lỗi mã giảm giá)
    public function remove(Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Vui lòng đăng nhập!'], 401);
        }

        $request->validate(['sanpham_id' => 'required']);
        $sanphamID = $request->sanpham_id;

        $cart = \App\Models\Cart::where('nguoidungID', \Illuminate\Support\Facades\Auth::id())->first();

        if ($cart) {
            \App\Models\CartItem::where('giohangID', $cart->id)
                    ->where('sanphamID', $sanphamID)
                    ->delete();

            $cart->load('cartItems'); 
            $tamTinh = 0;
            $tongSanPham = 0;
            
            foreach ($cart->cartItems as $item) {
                $tamTinh += ($item->gia * $item->soluong);
                $tongSanPham += $item->soluong;
            }

            $phiVanChuyen = $tongSanPham > 0 ? 30000 : 0;

            // --- ĐOẠN MỚI: TÍNH LẠI MÃ GIẢM GIÁ ---
            $soTienGiam = 0;
            $thongBaoHuyMa = '';
            if (session()->has('coupon')) {
                $couponSession = session()->get('coupon');
                $coupon = \App\Models\Coupon::find($couponSession['id']);

                if ($coupon && $tamTinh >= $coupon->giatridontoithieu) {
                    if ($coupon->loai == 'phantram') {
                        $soTienGiam = ($tamTinh * $coupon->giatri) / 100;
                    } else {
                        $soTienGiam = $coupon->giatri;
                    }
                    if ($soTienGiam > $tamTinh) $soTienGiam = $tamTinh;

                    session()->put('coupon', [
                        'id' => $coupon->id,
                        'ma' => $coupon->ma,
                        'sotiengiam' => $soTienGiam
                    ]);
                } else {
                    session()->forget('coupon');
                    $thongBaoHuyMa = 'Mã giảm giá đã bị gỡ do tổng đơn không đủ điều kiện!';
                }
            }
            // -------------------------------------

            $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;

            return response()->json([
                'status' => 'success', 
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                'subtotal' => number_format($tamTinh, 0, ',', '.') . 'đ',
                'total' => number_format($tongThanhToan, 0, ',', '.') . 'đ',
                'totalItemsCount' => $tongSanPham,
                'discount' => number_format($soTienGiam, 0, ',', '.') . 'đ',
                'hasCoupon' => $soTienGiam > 0,
                'couponMessage' => $thongBaoHuyMa
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy giỏ hàng!'], 400);
    }
    // Thêm hàm này vào CartController
    public function applyCoupon(Request $request)
    {
        $request->validate(['ma_giam_gia' => 'required|string']);

        $user = Auth::user();
        $cart = Cart::with('cartItems')->where('nguoidungID', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống!']);
        }

        // Tính tạm tính hiện tại
        $tamTinh = 0;
        foreach ($cart->cartItems as $item) {
            $tamTinh += ($item->gia * $item->soluong);
        }

        // 1. Kiểm tra mã giảm giá trong DB
        $coupon = Coupon::where('ma', strtoupper($request->ma_giam_gia))->first();

        // Các chốt chặn kiểm tra tính hợp lệ
        if (!$coupon) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không tồn tại!']);
        }
        if ($coupon->hethan && \Carbon\Carbon::parse($coupon->hethan)->isPast()) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá này đã hết hạn!']);
        }
        if ($coupon->gioihansudung && $coupon->dasudung >= $coupon->gioihansudung) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá này đã hết lượt sử dụng!']);
        }
        if ($tamTinh < $coupon->giatridontoithieu) {
            return response()->json(['status' => 'error', 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu (' . number_format($coupon->giatridontoithieu, 0, ',', '.') . 'đ) để dùng mã này!']);
        }

        // 2. Tính toán số tiền được giảm
        $soTienGiam = 0;
        if ($coupon->loai == 'phantram') {
            $soTienGiam = ($tamTinh * $coupon->giatri) / 100;
        } else {
            $soTienGiam = $coupon->giatri;
        }

        // Đảm bảo tiền giảm không vượt quá tiền hàng
        if ($soTienGiam > $tamTinh) {
            $soTienGiam = $tamTinh;
        }

        // 3. Tính lại Tổng thanh toán
        $phiVanChuyen = 30000;
        $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;

        // 4. Lưu mã vào Session để trang Checkout sử dụng
        session()->put('coupon', [
            'id' => $coupon->id,
            'ma' => $coupon->ma,
            'sotiengiam' => $soTienGiam
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Áp dụng mã giảm giá thành công!',
            'soTienGiam' => number_format($soTienGiam, 0, ',', '.') . 'đ',
            'tongThanhToan' => number_format($tongThanhToan, 0, ',', '.') . 'đ'
        ]);
    }
}