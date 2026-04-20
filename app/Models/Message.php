<?php

namespace App\Models;

use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasAttributeAliases;

    protected $table = 'tinnhan';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'nguoiguiID',
        'nguoinhanID',
        'noidung',
        'dadoc',
    ];

    protected array $attributeAliases = [
        'sender_id' => 'nguoiguiID',
        'receiver_id' => 'nguoinhanID',
        'message' => 'noidung',
        'is_read' => 'dadoc',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    protected $casts = [
        'dadoc' => 'boolean',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoiguiID');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoinhanID');
    }
}