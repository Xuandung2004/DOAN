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
use Illuminate\Support\Facades\RateLimiter;

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
        $userID = Auth::id(); // Lấy ID của khách (hoặc dùng Auth::id() nếu bắt buộc đăng nhập)
        $rateLimitKey = 'place-order:' . $userID;

    // Kiểm tra xem khách có đang bị khóa không (Tối đa 1 lần thử)
    if (RateLimiter::tooManyAttempts($rateLimitKey, 1)) {
        $seconds = RateLimiter::availableIn($rateLimitKey); // Lấy số giây còn lại phải đợi
        return response()->json([
            'status' => 'error',
            'message' => 'Bạn thao tác quá nhanh! Vui lòng đợi ' . $seconds . ' giây rồi thử lại.'
        ], 429); // Mã 429 là Too Many Requests
    }

        // Nếu qua ải, ghi nhận lần click này và khóa key trong đúng 10 giây
        RateLimiter::hit($rateLimitKey, 10);

        // 1. Validate dữ liệu cực kỳ chặt chẽ
        $request->validate([
            'tennguoinhan' => 'required|string|max:255',
            'sodienthoai' => ['required', 'regex:/^(0|\+84)[0-9]{9,10}$/'],
            'diachigiaohang' => 'required|string|max:500',
            'phuongthucthanhtoan' => 'required|in:COD,VNPAY', 
            'magiamgia' => 'nullable|string' 
        ], [
            'tennguoinhan.required' => 'Vui lòng nhập họ tên người nhận.',
            'sodienthoai.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'sodienthoai.regex' => 'Số điện thoại không đúng định dạng (phải bắt đầu bằng 0 hoặc +84 và đủ 10-11 số).',
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
                // Truy vấn trực tiếp DB và khóa dòng sản phẩm này lại
                // Nếu có 2 người cùng nhấn mua 1 lúc thì người sau sẽ phải đợi 
                // người trước xử lý xong mới được phép tiếp tục
                $productLocked = Product::where('id', $item->sanphamID)
                                                    ->lockForUpdate()
                                                    ->first();
                // Kiểm tra số lượng trước khi cho phép đặt hàng
                if (!$productLocked || $productLocked->soluong < $item->soluong) {
                    throw new \Exception('Sản phẩm "' . ($productLocked->ten ?? $item->product->ten) . '" không đủ số lượng trong kho!');
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
                                ->lockForUpdate()
                                ->first();

                if ($coupon && $tamTinh >= $coupon->giatridontoithieu) {
                    $couponId = $coupon->id;
                    $soTienGiam = ($coupon->loai == 'phantram') ? ($tamTinh * $coupon->giatri / 100) : $coupon->giatri;
                    if ($soTienGiam > $tamTinh) $soTienGiam = $tamTinh;
                }
            }

            $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;
            if ($tongThanhToan < 0) $tongThanhToan = 0;

            // 2. Tạo Đơn hàng mới (Trạng thái chờ)
            $order = Order::create([
                'nguoidungID' => $user->id,
                'tennguoinhan' => $request->tennguoinhan, 
                'sodienthoai' => $request->sodienthoai,   
                'tongtien' => $tongThanhToan,
                'diachigiaohang' => $request->diachigiaohang,
                'phuongthucthanhtoan' => $request->phuongthucthanhtoan,
                'trangthaithanhtoan' => 0, // 0: Chưa thanh toán
                'trangthaidon' => 0,       // 0: Chờ xử lý
                'magiamgiaID' => $couponId,
                'sotiengiam' => $soTienGiam,
            ]);

            // 3. Tạo Chi tiết đơn hàng (NHƯNG CHƯA TRỪ KHO)
            foreach ($cart->cartItems as $item) {
                OrderItem::create([
                    'donhangID' => $order->id,
                    'sanphamID' => $item->sanphamID,
                    'soluong' => $item->soluong,
                    'gia' => $item->gia
                ]);
            }

            // 4. CHIA NHÁNH THANH TOÁN
            if ($request->phuongthucthanhtoan === 'VNPAY') {
                if ($tongThanhToan <= 0) {
                 // Chặn không cho qua VNPay
                DB::rollBack();
                 return response()->json([
                 'status' => 'error',
                 'message' => 'Đơn hàng 0đ không thể thanh toán qua VNPay. Vui lòng chọn COD!'
                 ], 400);
                }
                // Với VNPay, ta chỉ lưu tạm đơn hàng, KHÔNG TRỪ KHO, KHÔNG CẬP NHẬT MÃ GIẢM GIÁ
                DB::commit(); 

                // 1. Cấu hình VNPay
                $vnp_Url = config('vnpay.sandbox_url');
                $vnp_Returnurl = url(config('vnpay.return_url')); 
                $vnp_TmnCode = config('vnpay.tmn_code'); 
                $vnp_HashSecret = config('vnpay.hash_secret'); 

                // 2. Thông tin đơn hàng gửi sang VNPay
                $maDonHang = 'DH' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
                $vnp_TxnRef = $maDonHang; 
                $vnp_OrderInfo = 'Thanh toan don hang KAIRA ma ' . $maDonHang;
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = $tongThanhToan * 100; 
                $vnp_Locale = 'vn';
                $vnp_IpAddr = $request->ip(); 

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                );

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash; 
                }

                // 3. Trả link về cho Javascript (AJAX) tự động chuyển hướng
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đang chuyển hướng đến VNPay...',
                    'redirect_url' => $vnp_Url 
                ]);
            }

            // ==========================================
            // THANH TOÁN COD: Chắc chắn mua -> Trừ kho và cập nhật ngay
            // ==========================================
            foreach ($cart->cartItems as $item) {
                $item->product->decrement('soluong', $item->soluong);
            }

            if ($couponId) {
                Coupon::where('id', $couponId)->increment('dasudung');
            }

            $cart->cartItems()->delete(); 
            session()->forget('coupon'); 
            
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.',
                'redirect_url' => route('cart')
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

    /**
     * Bước 3: Hứng kết quả từ VNPay trả về
     */
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = config('vnpay.hash_secret'); 

        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        $maDonHang = $inputData['vnp_TxnRef'];
        $orderId = (int) str_replace('DH', '', $maDonHang); 
        $order = Order::find($orderId); 

        // 2. So sánh chữ ký để đảm bảo an toàn tuyệt đối
        if ($secureHash === $vnp_SecureHash) {
            // Mã 00 nghĩa là giao dịch thành công
            if ($_GET['vnp_ResponseCode'] == '00') {
                
                // Nếu đơn hàng hợp lệ và chưa được thanh toán trước đó
                // if ($order && $order->trangthaithanhtoan == 0) {
                    DB::beginTransaction();
                    try {
                        // Khóa đơn hàng để tránh tình trạng 2 hoặc nhiều luồng cùng xử lý một đơn hàng
                        $order = Order::where('id', $orderId)->lockForUpdate()->first();
                        // Nếu đơn hàng hợp lệ và chưa được thanh toán trước đó
                        if ($order && $order->trangthaithanhtoan == 0) {
                        // Khách đã thanh toán nhưng hết hàng
                        $hetHang = false;
                    foreach ($order->orderItems as $item) {
                        $productLocked = Product::where('id', $item->sanphamID)->lockForUpdate()->first();
                        if (!$productLocked || $productLocked->soluong < $item->soluong) {
                            $hetHang = true;
                            break;
                        }
                    }
                    if ($hetHang) {
                        $order->trangthaithanhtoan = 2; // Đã thanh toán nhưng HẾT HÀNG
                        $order->save();
                        DB::commit();

                        return view('pages.vnpay_return', [
                            'status' => 'warning',
                            'message' => 'Bạn đã thanh toán thành công, nhưng sản phẩm vừa hết hàng...'
                        ]);
                    }
                        // 1. Đánh dấu đã thanh toán
                        $order->trangthaithanhtoan = 1; 
                        $order->save();

                        // 2. BÂY GIỜ MỚI TRỪ TỒN KHO
                        foreach ($order->orderItems as $item) {
                            $item->product->decrement('soluong', $item->soluong);
                        }

                        // 3. CẬP NHẬT LƯỢT DÙNG MÃ GIẢM GIÁ
                        if ($order->magiamgiaID) {
                            Coupon::where('id', $order->magiamgiaID)->increment('dasudung');
                        }

                        // 4. DỌN DẸP GIỎ HÀNG
                        $cart = Cart::where('nguoidungID', $order->nguoidungID)->first();
                        if ($cart) {
                            $cart->cartItems()->delete();
                        }
                        session()->forget('coupon');

                        DB::commit();
                        } else {
                            DB::rollBack();
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error('Lỗi khi xử lý thành công VNPay: ' . $e->getMessage());
                        return view('pages.vnpay_return', [
                            'status' => 'error', 
                            'message' => 'Lỗi hệ thống khi cập nhật đơn hàng!'
                        ]);
                    }
                // }
                // Trả về giao diện Thành công
                return view('pages.vnpay_return', [
                    'status' => 'success', 
                    'message' => 'Thanh toán thành công! Cảm ơn bạn đã mua hàng tại KAIRA.'
                ]);
            } else {
                // Khách hàng bấm HỦY hoặc lỗi thẻ
                // Cập nhật trạng thái đơn hàng thành Đã hủy (3)
                if ($order && $order->trangthaidon != 3) {
                    $order->trangthaidon = 3; 
                    $order->save();
                }

                return view('pages.vnpay_return', [
                    'status' => 'error', 
                    'message' => 'Giao dịch không thành công hoặc đã bị hủy!'
                ]);
            }
        } else {
            // Sai chữ ký
            return view('pages.vnpay_return', [
                'status' => 'error', 
                'message' => 'Chữ ký không hợp lệ! Dữ liệu có thể đã bị can thiệp.'
            ]);
        }
    }
}