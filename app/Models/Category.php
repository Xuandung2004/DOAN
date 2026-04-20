<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasAttributeAliases;

    protected $table = 'danhmuc';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    protected $fillable = [
        'ten',
        'duongdan'
    ];

    protected array $attributeAliases = [
        'name' => 'ten',
        'slug' => 'duongdan',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'danhmucID');
    }
}