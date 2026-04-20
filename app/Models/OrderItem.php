<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasAttributeAliases;

    protected $table = 'donhangchitiet';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'donhangID',
        'sanphamID',
        'soluong',
        'gia',
    ];

    protected array $attributeAliases = [
        'order_id' => 'donhangID',
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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'donhangID');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'sanphamID');
    }
}