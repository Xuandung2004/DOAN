<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Vui lòng đăng nhập!'], 401);
        }

        $sanphamID = $request->sanpham_id;

        // 1. Tìm giỏ hàng của user hiện tại
        $cart = Cart::where('nguoidungID', Auth::id())->first();

        if ($cart) {
            // 2. Xóa sản phẩm đó khỏi chi tiết giỏ hàng
            CartItem::where('giohangID', $cart->id)
                    ->where('sanphamID', $sanphamID)
                    ->delete();

            // 3. Tính lại tổng số lượng hàng còn lại trong giỏ
            $totalItems = CartItem::where('giohangID', $cart->id)->sum('soluong');

            return response()->json([
                'status' => 'success', 
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                'totalItems' => $totalItems
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy giỏ hàng!'], 400);
    }
}