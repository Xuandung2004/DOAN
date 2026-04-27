# 📌 QUICK REFERENCE - KAIRA ISSUES BY FILE

## File-by-File Breakdown with Fixes

---

## 🔴 CRITICAL FILES

### `routes/web.php` - Line 124

**Issue**: Admin routes không có authorization check
```php
❌ Route::middleware(['auth'])->prefix('admin')->group(function () {
✅ Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
```

**Fix Time**: 5 phút | **Risk**: High

---

### `app/Http/Controllers/CheckoutController.php`

#### Issue #1: VNPay Credentials Hardcoded (Line 164-166)
```php
❌ $vnp_TmnCode = "K2EX4HKN";
❌ $vnp_HashSecret = "XU1XTXBKUK10V4RNH13TKVHZ91T9595X";

✅ $vnp_TmnCode = config('vnpay.tmn_code');
✅ $vnp_HashSecret = config('vnpay.hash_secret');
```
**Fix Time**: 10 phút | **Files to Create**: `config/vnpay.php` | **Risk**: High

#### Issue #2: Transaction Commit Too Early (Line 160)
```php
❌ DB::beginTransaction();
   // ... create order + orderitems, decrement stock
   DB::commit(); // ← QUỐC SỚM, chưa verify VNPay
   // redirect to VNPay

✅ // Chỉ commit TRONG vnpayReturn khi ResponseCode == '00'
```
**Fix Time**: 45 phút | **Complexity**: High | **Risk**: Critical

#### Issue #3: Phone Number Validation (Line 66)
```php
❌ 'sodienthoai' => 'required|string|max:20',
✅ 'sodienthoai' => 'required|regex:/^(0|\+84)[0-9]{9}$/|max:20',
```
**Fix Time**: 3 phút | **Risk**: Low

---

### `app/Http/Controllers/ReviewController.php` (Line 17-38)

**Issue**: Bất kỳ ai cũng có thể đánh giá, ai cũng có thể đánh giá 100 lần

```php
❌ public function store(Request $request)
✅ public function store(ReviewRequest $request) // Custom validation
```

**Validation cần**:
- ✓ User đã mua sản phẩm (join OrderItem)
- ✓ User chưa đánh giá sản phẩm (unique constraint)

**Fix Time**: 30 phút | **Files to Create**: `app/Http/Requests/ReviewRequest.php` + 1 migration | **Risk**: High

---

## 🟡 WARNING FILES

### `app/Http/Controllers/OrderController.php`

#### Issue #1: No State Validation (Line 34-65)
```php
❌ Admin có thể chuyển từ bất kỳ state sang bất kỳ state
✅ Tạo State Machine validation
```

**Method to add**:
```php
private function canTransitionTo($currentStatus, $newStatus) {
    $validTransitions = [
        0 => [1, 3],     // Chờ → Đang giao hoặc Hủy
        1 => [2],        // Đang giao → Hoàn tất
        2 => [],         // Hoàn tất → không thể chuyển
        3 => [],         // Hủy → không thể chuyển
    ];
    return in_array($newStatus, $validTransitions[$currentStatus] ?? []);
}
```
**Fix Time**: 20 phút | **Risk**: Medium

#### Issue #2: No Refund Logic When Cancel (Line 96-114)
```php
❌ if ($order->trangthaidon == 0) {
       $order->trangthaidon = 3;
       // ← Không hoàn tiền nếu đã thanh toán
✅ Kiểm tra trangthaithanhtoan rồi tạo Refund
```
**Fix Time**: 45 phút | **Complexity**: High | **Risk**: High

---

### `app/Http/Controllers/CartController.php`

#### Issue: N+1 Query (Line 19-31)
```php
❌ $cart = Cart::with(['cartItems.product.images'])->where(...)->first();

✓ Đã sử dụng with() đúng rồi, nhưng kiểm tra toàn bộ file xem có chỗ khác N+1 không
```
**Fix Time**: 15 phút | **Risk**: Low

#### Missing: Rate Limiting
```php
❌ Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
✅ Route::post('/cart/add', [CartController::class, 'addToCart'])
     ->middleware('throttle:10,1') // 10 requests per minute
     ->name('cart.add');
```
**Fix Time**: 5 phút | **Risk**: Low

---

### `app/Http/Controllers/CouponController.php`

**Issues**:
1. Không có `is_active` field
2. Không track coupon usage (ai dùng, khi nào, bao nhiêu?)
3. Không support category-specific coupons

**Migration cần**:
```php
Schema::table('magiamgia', function (Blueprint $table) {
    $table->boolean('is_active')->default(true)->after('giatri');
});

Schema::create('coupon_usages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('magiamgiaID')->constrained('magiamgia')->cascadeOnDelete();
    $table->foreignId('donhangID')->constrained('donhang')->cascadeOnDelete();
    $table->foreignId('nguoidungID')->constrained('nguoidung')->cascadeOnDelete();
    $table->decimal('discount_amount', 15, 2);
    $table->timestamp('ngaytao')->useCurrent();
});
```
**Fix Time**: 30 phút | **Risk**: Medium

---

### `app/Http/Controllers/ProductController.php`

#### Issue: N+1 Query (Line 70-95)
```php
❌ Review::with(['product', 'user'])  // ← mỗi review load user + product
✅ Review::with('product', 'user')->paginate(15);
```
Kiểm tra `adminIndex` function

**Fix Time**: 10 phút | **Risk**: Low

---

## 🟢 SUGGESTION FILES

### `app/Http/Controllers/DashboardController.php`

**Improvements**:
- [ ] Add caching cho revenue statistics
- [ ] Add chart filtering (week/month/year)
- [ ] Add "low stock" alerts

**Fix Time**: 30 phút | **Complexity**: Medium | **Risk**: Low

---

### `app/Http/Middleware/`

**Missing**:
- [ ] IsAdmin middleware
- [ ] VerifiedEmail middleware
- [ ] ApiRateLimit middleware

**Fix Time**: 20 phút | **Risk**: Low

---

### Database Migrations Needed

| # | Migration | Priority | Time |
|----|-----------|----------|------|
| 1 | `add_status_to_donhang_table` | 🔴 Critical | 5m |
| 2 | `add_unique_review_per_user_product` | 🔴 Critical | 5m |
| 3 | `add_is_active_to_magiamgia_table` | 🟡 Warning | 5m |
| 4 | `create_coupon_usages_table` | 🟡 Warning | 10m |
| 5 | `add_soft_delete_to_orders` | 🟢 Suggestion | 5m |
| 6 | `add_soft_delete_to_reviews` | 🟢 Suggestion | 5m |
| 7 | `add_email_verified_at_to_users` | 🔴 Critical | 5m |
| 8 | `create_admin_activity_logs_table` | 🟢 Suggestion | 10m |

---

## Config Files Needed

### `config/vnpay.php` (NEW)
```php
<?php
return [
    'tmn_code' => env('VNPAY_TMN_CODE'),
    'hash_secret' => env('VNPAY_HASH_SECRET'),
    'sandbox_url' => env('VNPAY_SANDBOX_URL'),
    'return_url' => env('VNPAY_RETURN_URL'),
];
```

### `.env` (UPDATE)
```env
VNPAY_TMN_CODE=K2EX4HKN
VNPAY_HASH_SECRET=XU1XTXBKUK10V4RNH13TKVHZ91T9595X
VNPAY_SANDBOX_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL=/vnpay-return
```

### `.env.example` (UPDATE - NO REAL CREDENTIALS)
```env
VNPAY_TMN_CODE=your_tmn_code_here
VNPAY_HASH_SECRET=your_hash_secret_here
VNPAY_SANDBOX_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL=/vnpay-return
```

---

## Request Classes Needed

### `app/Http/Requests/ReviewRequest.php` (NEW)
- Validate purchase history
- Validate unique review per user per product

### `app/Http/Requests/CheckoutRequest.php` (NEW)
- Validate phone format
- Validate stock availability
- Validate coupon validity
- Validate price integrity

---

## Middleware Needed

### `app/Http/Middleware/IsAdmin.php` (NEW)
- Check `auth()->user()->vaitro == 1`
- Return 403 if not admin

### `app/Http/Middleware/VerifiedEmail.php` (NEW)
- Check `auth()->user()->email_verified_at`
- Redirect to verify email page if not

---

## Routes Changes Needed

```php
// 1. Admin middleware
❌ Route::middleware(['auth'])->prefix('admin')->group(function () {
✅ Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

// 2. Rate limiting
Route::post('/cart/add', [...])     ->middleware('throttle:10,1');
Route::post('/reviews', [...])      ->middleware('throttle:5,1');
Route::post('/checkout/place-order', [...]) ->middleware('throttle:3,1');

// 3. Email verification
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);
});
```

---

## Code Review Checklist

### Security 🔐
- [ ] All credentials in .env
- [ ] Admin middleware applied
- [ ] CSRF tokens on forms
- [ ] Input sanitization
- [ ] Rate limiting on API endpoints
- [ ] Email verification implemented

### Business Logic ✅
- [ ] VNPay transaction flow correct
- [ ] Stock management on purchase/cancel
- [ ] Coupon validation complete
- [ ] Review only by purchasers
- [ ] State transitions validated
- [ ] Refund logic implemented

### Performance 🚀
- [ ] N+1 queries fixed
- [ ] Eager loading used
- [ ] Caching implemented
- [ ] Database indexes added
- [ ] Pagination working

### Data Integrity 📊
- [ ] Foreign keys with cascade delete
- [ ] Soft deletes for important records
- [ ] Unique constraints applied
- [ ] Audit logs maintained

---

## Priority Timeline

### Week 1 (Tối thiểu để go live)
- [x] Admin middleware
- [x] VNPay refactor
- [x] Review validation
- [x] Phone validation
- [x] Email verification setup

**Estimated**: 4-5 ngày làm việc

### Week 2 (Chất lượng)
- [ ] State machine for orders
- [ ] Coupon tracking
- [ ] Rate limiting
- [ ] N+1 query fix
- [ ] Refund logic

**Estimated**: 3-4 ngày làm việc

### Week 3 (Polish)
- [ ] Caching
- [ ] Audit logs
- [ ] Soft deletes
- [ ] UX improvements

**Estimated**: 2-3 ngày làm việc

---

*Cập nhật lần cuối: 27/04/2026*
