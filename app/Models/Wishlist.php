<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasAttributeAliases;

    protected $table = 'yeuthich';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'nguoidungID',
        'sanphamID',
    ];

    protected array $attributeAliases = [
        'user_id' => 'nguoidungID',
        'product_id' => 'sanphamID',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
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