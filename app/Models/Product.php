<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasAttributeAliases;

    protected $table = 'sanpham';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'danhmucID',
        'ten',
        'duongdan',
        'mota',
        'gia',
        'giagiam',
        'soluong',
        'trangthai',
        'diemtrungbinh',
    ];

    protected array $attributeAliases = [
        'category_id' => 'danhmucID',
        'name' => 'ten',
        'slug' => 'duongdan',
        'description' => 'mota',
        'price' => 'gia',
        'discount_price' => 'giagiam',
        'stock' => 'soluong',
        'status' => 'trangthai',
        'average_rating' => 'diemtrungbinh',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    protected $casts = [
        'gia' => 'decimal:2',
        'giagiam' => 'decimal:2',
        'soluong' => 'integer',
        'trangthai' => 'integer',
        'diemtrungbinh' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'danhmucID');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'sanphamID');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'sanphamID');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'sanphamID');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'sanphamID');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'sanphamID');
    }
}