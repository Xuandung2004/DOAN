<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Nhúng thêm class HasMany

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // --- Bổ sung các trường từ thiết kế DBML của bạn ---
        'phone',
        'address',
        'google_id',
        'role', // 0 = user, 1 = admin
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // KHAI BÁO CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // Dựa trên thiết kế DBML
    // ==========================================

    /**
     * Một User có thể có nhiều Đơn hàng
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Một User có thể có nhiều Giỏ hàng (hoặc 1 giỏ hàng tùy logic)
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Một User có thể có nhiều sản phẩm trong Wishlist
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Một User có thể viết nhiều Đánh giá (Reviews)
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}