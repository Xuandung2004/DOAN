<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasAttributeAliases;

    protected $table = 'giohang';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'nguoidungID'
    ];

    protected array $attributeAliases = [
        'user_id' => 'nguoidungID',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoidungID');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'giohangID');
    }
}