<?php

namespace App\Models;

use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasAttributeAliases;

    protected $table = 'magiamgia';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'ma',
        'loai',
        'giatri',
        'giatridontoithieu',
        'gioihansudung',
        'dasudung',
        'hethan',
    ];

    protected array $attributeAliases = [
        'code' => 'ma',
        'type' => 'loai',
        'value' => 'giatri',
        'min_order_amount' => 'giatridontoithieu',
        'usage_limit' => 'gioihansudung',
        'used' => 'dasudung',
        'expires_at' => 'hethan',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    protected $casts = [
        'giatri' => 'decimal:2',
        'giatridontoithieu' => 'decimal:2',
        'gioihansudung' => 'integer',
        'dasudung' => 'integer',
        'hethan' => 'datetime',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'magiamgiaID');
    }
}