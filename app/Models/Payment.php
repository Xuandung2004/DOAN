<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasAttributeAliases;

    protected $table = 'thanhtoan';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'donhangID',
        'magiaodich',
        'sotien',
        'manganhang',
        'maphanhoi',
        'thoigianthanhtoan',
    ];

    protected array $attributeAliases = [
        'order_id' => 'donhangID',
        'transaction_id' => 'magiaodich',
        'amount' => 'sotien',
        'bank_code' => 'manganhang',
        'response_code' => 'maphanhoi',
        'payment_time' => 'thoigianthanhtoan',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    protected $casts = [
        'sotien' => 'decimal:2',
        'thoigianthanhtoan' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'donhangID');
    }
}