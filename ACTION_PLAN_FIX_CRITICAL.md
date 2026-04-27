# 🔧 ACTION PLAN - FIX CRITICAL ISSUES KAIRA

## ISSUE #1: Admin Routes Authorization - FIX IMPLEMENTATION

### **Vấn đề**
Admin routes không kiểm tra user có phải admin không. Bất kỳ user đã login cũng có thể vào `/admin`.

### **Giải pháp**

#### **Step 1: Tạo Middleware AdminCheck**

File: `app/Http/Middleware/IsAdmin.php`
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra user đã login chưa
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập.');
        }

        // Kiểm tra user có phải admin (vaitro == 1) không
        if (auth()->user()->vaitro != 1) {
            abort(403, 'Bạn không có quyền truy cập khu vực này.');
        }

        return $next($request);
    }
}
```

#### **Step 2: Register Middleware trong `app/Http/Kernel.php`**

```php
protected $routeMiddleware = [
    // ... middleware khác
    'admin' => \App\Http\Middleware\IsAdmin::class,
];
```

#### **Step 3: Áp dụng middleware vào Admin Routes**

File: `routes/web.php` - thay đổi dòng 124:

**Trước:**
```php
Route::middleware(['auth'])->prefix('admin')->group(function () {
```

**Sau:**
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
```

### **Verification**
- Đăng nhập với tài khoản user (vaitro = 0)
- Truy cập `/admin` → Phải nhận lỗi 403 Forbidden
- Đăng nhập với tài khoản admin (vaitro = 1)
- Truy cập `/admin` → OK ✓

---

## ISSUE #2: VNPay Credentials Hardcoded - FIX IMPLEMENTATION

### **Giải pháp**

#### **Step 1: Thêm vào `.env` file**

File: `.env`
```env
VNPAY_TMN_CODE=K2EX4HKN
VNPAY_HASH_SECRET=XU1XTXBKUK10V4RNH13TKVHZ91T9595X
VNPAY_SANDBOX_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL=/vnpay-return
```

#### **Step 2: Tạo config file**

File: `config/vnpay.php`
```php
<?php

return [
    'tmn_code' => env('VNPAY_TMN_CODE'),
    'hash_secret' => env('VNPAY_HASH_SECRET'),
    'sandbox_url' => env('VNPAY_SANDBOX_URL'),
    'return_url' => env('VNPAY_RETURN_URL'),
];
```

#### **Step 3: Update CheckoutController**

File: `app/Http/Controllers/CheckoutController.php` - dòng 164-166

**Trước:**
```php
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = url('/vnpay-return'); 
$vnp_TmnCode = "K2EX4HKN";
$vnp_HashSecret = "XU1XTXBKUK10V4RNH13TKVHZ91T9595X";
```

**Sau:**
```php
$vnp_Url = config('vnpay.sandbox_url');
$vnp_Returnurl = url(config('vnpay.return_url'));
$vnp_TmnCode = config('vnpay.tmn_code');
$vnp_HashSecret = config('vnpay.hash_secret');
```

### **⚠️ CẢNH BÁO**
- Sau khi sửa, **xóa credentials cũ khỏi VNPay account**
- Tạo TMN code + Hash secret mới
- Update vào `.env.example` (nhưng không include actual values)

---

## ISSUE #3: VNPay Transaction Flow - FIX IMPLEMENTATION

### **Vấn đề**
Stock bị trừ trước khi VNPay verify. Nếu user không thanh toán xong, stock mất mà tiền không có.

### **Giải pháp - Refactor CheckoutController**

**Chiến lược**: 
- Chỉ trừ stock + lưu OrderItem khi VNPay trả về `ResponseCode = 00`
- Nếu VNPay thất bại, rollback toàn bộ

#### **Step 1: Tách checkout thành 2 bước**

File: `app/Http/Controllers/CheckoutController.php`

```php
/**
 * BƯỚC 1: Validate order data & tạo Pending Order
 * (Chưa trừ stock)
 */
public function placeOrder(Request $request)
{
    // Validate
    $request->validate([
        'tennguoinhan' => 'required|string|max:255',
        'sodienthoai' => 'required|regex:/^(0|\+84)[0-9]{9}$/',
        'diachigiaohang' => 'required|string|max:500',
        'phuongthucthanhtoan' => 'required|in:COD,VNPAY',
        'magiamgia' => 'nullable|string'
    ]);

    $user = Auth::user();
    $cart = Cart::with('cartItems.product')->where('nguoidungID', $user->id)->first();

    if (!$cart || $cart->cartItems->isEmpty()) {
        return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
    }

    DB::beginTransaction();

    try {
        // 1. Validate stock & prices
        $tamTinh = 0;
        foreach ($cart->cartItems as $item) {
            // ✓ Kiểm tra stock có đủ không
            if ($item->product->soluong < $item->soluong) {
                throw new \Exception('Sản phẩm "' . $item->product->ten . '" không đủ kho!');
            }
            // ✓ Kiểm tra giá có thay đổi không (xác nhận lại)
            if ($item->gia != $item->product->gia && $item->gia != $item->product->giagiam) {
                throw new \Exception('Giá sản phẩm "' . $item->product->ten . '" đã thay đổi!');
            }
            $tamTinh += ($item->gia * $item->soluong);
        }

        // 2. Validate mã giảm
        $phiVanChuyen = 30000;
        $soTienGiam = 0;
        $couponId = null;

        if ($request->filled('magiamgia')) {
            $coupon = Coupon::where('ma', strtoupper($request->magiamgia))
                            ->where(fn($q) => $q->whereNull('hethan')->orWhere('hethan', '>', now()))
                            ->where('dasudung', '<', DB::raw('gioihansudung'))
                            ->first();

            if ($coupon && $tamTinh >= $coupon->giatridontoithieu) {
                $couponId = $coupon->id;
                $soTienGiam = ($coupon->loai == 'phantram') 
                    ? ($tamTinh * $coupon->giatri / 100) 
                    : $coupon->giatri;
                if ($soTienGiam > $tamTinh) $soTienGiam = $tamTinh;
            }
        }

        $tongThanhToan = $tamTinh + $phiVanChuyen - $soTienGiam;
        if ($tongThanhToan < 0) $tongThanhToan = 0;

        // 3. ⭐ CHƯA COMMIT - Chỉ tạo PENDING ORDER (chưa trừ stock)
        $order = Order::create([
            'nguoidungID' => $user->id,
            'tennguoinhan' => $request->tennguoinhan,
            'sodienthoai' => $request->sodienthoai,
            'tongtien' => $tongThanhToan,
            'diachigiaohang' => $request->diachigiaohang,
            'phuongthucthanhtoan' => $request->phuongthucthanhtoan,
            'trangthaithanhtoan' => 0, // Chờ thanh toán
            'trangthaidon' => 0,       // Chờ xử lý
            'magiamgiaID' => $couponId,
            'sotiengiam' => $soTienGiam,
            'status' => 'pending', // Thêm trạng thái pending để phân biệt
        ]);

        // 4. Chỉ tạo OrderItems, KHÔNG trừ stock
        foreach ($cart->cartItems as $item) {
            OrderItem::create([
                'donhangID' => $order->id,
                'sanphamID' => $item->sanphamID,
                'soluong' => $item->soluong,
                'gia' => $item->gia
            ]);
            // ❌ KHÔNG làm: $item->product->decrement('soluong', $item->soluong);
        }

        // 5. CHIA NHÁNH THANH TOÁN
        if ($request->phuongthucthanhtoan === 'VNPAY') {
            DB::commit(); // Commit pending order (chưa trừ stock)

            // Tạo VNPay redirect URL
            $vnp_Url = $this->generateVNPayUrl($order, $tongThanhToan, $request->ip());

            return response()->json([
                'status' => 'success',
                'redirect_url' => $vnp_Url
            ]);
        } 
        
        // COD: Trừ stock ngay (vì không cần verify từ bên thứ 3)
        foreach ($cart->cartItems as $item) {
            $item->product->decrement('soluong', $item->soluong);
        }

        // Cập nhật mã giảm
        if ($couponId) {
            Coupon::where('id', $couponId)->increment('dasudung');
        }

        // Xóa giỏ hàng (chỉ COD)
        $cart->cartItems()->delete();
        session()->forget('coupon');

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Đặt hàng thành công! Vui lòng thanh toán khi nhận hàng.',
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
 * BƯỚC 2: Xác nhận thanh toán từ VNPay
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
            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    $maDonHang = $inputData['vnp_TxnRef'];
    $orderId = (int) str_replace('DH', '', $maDonHang);
    $order = Order::find($orderId);

    DB::beginTransaction();

    try {
        // 1. Verify chữ ký VNPay
        if ($secureHash != $vnp_SecureHash) {
            throw new \Exception('Chữ ký VNPay không hợp lệ!');
        }

        // 2. Thanh toán thành công
        if ($_GET['vnp_ResponseCode'] == '00' && $order) {
            // ✓ Giờ mới trừ stock (vì đã verify từ VNPay)
            foreach ($order->orderItems as $item) {
                $item->product->decrement('soluong', $item->soluong);
            }

            // ✓ Cập nhật mã giảm
            if ($order->magiamgiaID) {
                Coupon::where('id', $order->magiamgiaID)->increment('dasudung');
            }

            // ✓ Cập nhật trạng thái thanh toán
            $order->trangthaithanhtoan = 1;
            $order->status = 'confirmed'; // Xóa pending
            $order->save();

            // ✓ Xóa giỏ hàng của user
            $cart = Cart::where('nguoidungID', Auth::id())->first();
            if ($cart) {
                $cart->cartItems()->delete();
            }
            session()->forget('coupon');

            DB::commit();

            return view('pages.vnpay_return', [
                'status' => 'success',
                'message' => 'Thanh toán thành công!'
            ]);
        } 
        
        // Thanh toán thất bại hoặc bị hủy
        DB::rollBack();

        return view('pages.vnpay_return', [
            'status' => 'error',
            'message' => 'Giao dịch không thành công. Đơn hàng vẫn còn trong tài khoản.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Lỗi VNPay callback: ' . $e->getMessage());

        return view('pages.vnpay_return', [
            'status' => 'error',
            'message' => 'Lỗi xử lý giao dịch: ' . $e->getMessage()
        ]);
    }
}

private function generateVNPayUrl($order, $amount, $clientIp)
{
    $vnp_Url = config('vnpay.sandbox_url');
    $vnp_TmnCode = config('vnpay.tmn_code');
    $vnp_HashSecret = config('vnpay.hash_secret');

    $maDonHang = 'DH' . str_pad($order->id, 3, '0', STR_PAD_LEFT);

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $amount * 100,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $clientIp,
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => 'Thanh toan don hang KAIRA ma ' . $maDonHang,
        "vnp_OrderType" => "billpayment",
        "vnp_ReturnUrl" => url(config('vnpay.return_url')),
        "vnp_TxnRef" => $maDonHang,
    ];

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

    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    return $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;
}
```

#### **Step 2: Thêm migration để thêm status column vào Order**

File: `database/migrations/2026_04_XX_XXXXXX_add_status_to_donhang_table.php`
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donhang', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending')->after('trangthaidon');
        });
    }

    public function down(): void
    {
        Schema::table('donhang', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
```

#### **Step 3: Update Order Model**

File: `app/Models/Order.php`
```php
protected $fillable = [
    // ... các field cũ
    'status', // Thêm
];
```

---

## ISSUE #4: Review Validation - FIX IMPLEMENTATION

### **Giải pháp**

#### **Step 1: Tạo ReviewRequest Validation**

File: `app/Http/Requests/ReviewRequest.php`
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\OrderItem;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = Auth::id();
        $productId = $this->input('sanphamID');

        return [
            'sanphamID' => [
                'required',
                'exists:sanpham,id',
                // Custom rule: User phải đã mua sản phẩm này
                function ($attribute, $value, $fail) use ($userId) {
                    $hasPurchased = OrderItem::whereHas('order', function($q) use ($userId) {
                        $q->where('nguoidungID', $userId)
                          ->where('trangthaidon', 2); // Chỉ đơn hoàn tất
                    })
                    ->where('sanphamID', $value)
                    ->exists();

                    if (!$hasPurchased) {
                        $fail('Bạn phải mua sản phẩm này để có thể đánh giá.');
                    }
                },
            ],
            'sosao' => 'required|integer|min:1|max:5',
            'binhluan' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'sosao.required' => 'Vui lòng chọn số sao.',
            'binhluan.required' => 'Vui lòng nhập bình luận.',
        ];
    }

    /**
     * Sau khi validate, kiểm tra user chưa đánh giá sản phẩm này
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $userId = Auth::id();
            $productId = $this->input('sanphamID');

            $alreadyReviewed = Review::where('nguoidungID', $userId)
                                      ->where('sanphamID', $productId)
                                      ->exists();

            if ($alreadyReviewed) {
                $validator->errors()->add('binhluan', 'Bạn đã đánh giá sản phẩm này rồi.');
            }
        });
    }
}
```

#### **Step 2: Update ReviewController để sử dụng request này**

File: `app/Http/Controllers/ReviewController.php`
```php
use App\Http\Requests\ReviewRequest;

public function store(ReviewRequest $request) // ✓ Dùng ReviewRequest thay vì Request
{
    // Validation đã tự động chạy
    $review = Review::create([
        'nguoidungID' => Auth::id(),
        'sanphamID' => $request->sanphamID,
        'sosao' => $request->sosao,
        'binhluan' => $request->binhluan,
    ]);

    $review->load('user');
    $tenNguoiDung = $review->user->hoten ?? 'Khách hàng';

    $this->updateProductAverageRating($request->sanphamID);

    return response()->json([
        'status' => 'success',
        'message' => 'Thêm đánh giá thành công!',
        'review_data' => [
            'hoten' => $tenNguoiDung,
            'sosao' => $request->sosao,
            'binhluan' => $request->binhluan,
            'thoigian' => 'Vừa xong'
        ]
    ]);
}
```

#### **Step 3: Thêm Migration cho unique constraint**

File: `database/migrations/2026_04_XX_XXXXXX_add_unique_review_per_user_product.php`
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('danhgia', function (Blueprint $table) {
            $table->unique(['nguoidungID', 'sanphamID'], 'unique_user_product_review');
        });
    }

    public function down(): void
    {
        Schema::table('danhgia', function (Blueprint $table) {
            $table->dropUnique('unique_user_product_review');
        });
    }
};
```

---

## ISSUE #5: Phone Number Validation - QUICK FIX

### **File: `app/Http/Controllers/CheckoutController.php`**

**Thay đổi validation:**

```php
// Trước
'sodienthoai' => 'required|string|max:20',

// Sau - Validate số điện thoại VN đúng format
'sodienthoai' => [
    'required',
    'regex:/^(0|\+84)[0-9]{9}$/',
    'max:20'
],
```

### **Messages**
```php
'sodienthoai.regex' => 'Số điện thoại không đúng định dạng (0xxxxxxxxx hoặc +84xxxxxxxxx).',
```

---

## 📋 TESTING CHECKLIST

- [ ] Middleware admin check: Login user → `/admin` → 403 Forbidden
- [ ] VNPay credentials: `php artisan config:cache` → kiểm tra `.env` được load
- [ ] VNPay flow: Đặt hàng VNPAY → VNPay Return thành công → Stock trừ
- [ ] VNPay flow: Đặt hàng VNPAY → VNPay Return thất bại → Stock không trừ
- [ ] Review: User không mua → không đánh giá được
- [ ] Review: User mua rồi → có thể đánh giá
- [ ] Review: User đánh giá lần 2 → lỗi "đã đánh giá rồi"
- [ ] Phone: Nhập "abc" → validation error
- [ ] Phone: Nhập "0123456789" → OK ✓

---

*Cuộc cập nhật: 27/04/2026*
