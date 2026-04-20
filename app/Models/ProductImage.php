<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasAttributeAliases;

    protected $table = 'anhsanpham';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'sanphamID',
        'duongdananh'
    ];

    protected array $attributeAliases = [
        'product_id' => 'sanphamID',
        'image_url' => 'duongdananh',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'sanphamID');
    }
}