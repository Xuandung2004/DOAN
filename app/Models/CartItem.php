<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasAttributeAliases;

    protected $table = 'giohangchitiet';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'giohangID',
        'sanphamID',
        'soluong',
        'gia'
    ];

    protected array $attributeAliases = [
        'cart_id' => 'giohangID',
        'product_id' => 'sanphamID',
        'quantity' => 'soluong',
        'price' => 'gia',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    protected $casts = [
        'soluong' => 'integer',
        'gia' => 'decimal:2',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'giohangID');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'sanphamID');
    }
}