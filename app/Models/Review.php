<?php

namespace App\Models;

use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasAttributeAliases;

    protected $table = 'danhgia';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'nguoidungID',
        'sanphamID',
        'sosao',
        'binhluan',
    ];

    protected array $attributeAliases = [
        'user_id' => 'nguoidungID',
        'product_id' => 'sanphamID',
        'rating' => 'sosao',
        'comment' => 'binhluan',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    protected $casts = [
        'sosao' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoidungID');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'sanphamID');
    }
}