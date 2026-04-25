<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasAttributeAliases;

    protected $table = 'donhang';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'nguoidungID',
        'tennguoinhan',    // <-- THÊM MỚI
        'sodienthoai',     // <-- THÊM MỚI
        'tongtien',
        'diachigiaohang',
        'phuongthucthanhtoan',
        'trangthaithanhtoan',
        'trangthaidon',
        'magiamgiaID',
        'sotiengiam',
    ];

    protected array $attributeAliases = [
        'user_id' => 'nguoidungID',
        'receiver_name' => 'tennguoinhan',  // <-- THÊM MỚI
        'receiver_phone' => 'sodienthoai',  // <-- THÊM MỚI
        'total_price' => 'tongtien',
        'shipping_address' => 'diachigiaohang',
        'payment_method' => 'phuongthucthanhtoan',
        'payment_status' => 'trangthaithanhtoan',
        'order_status' => 'trangthaidon',
        'coupon_id' => 'magiamgiaID',
        'discount_amount' => 'sotiengiam',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    protected $casts = [
        'tongtien' => 'decimal:2',
        'sotiengiam' => 'decimal:2',
        'trangthaithanhtoan' => 'integer',
        'trangthaidon' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoidungID');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'magiamgiaID');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'donhangID');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'donhangID');
    }
}