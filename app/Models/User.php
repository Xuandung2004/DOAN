<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\HasAttributeAliases;
use Illuminate\Database\Eloquent\Relations\HasMany; // Nhúng thêm class HasMany

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasAttributeAliases;

    protected $table = 'nguoidung';
    public const CREATED_AT = 'ngaytao';
    public const UPDATED_AT = 'ngaycapnhat';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'hoten',
        'name',  // Alias
        'email',
        'matkhau',
        'password',  // Alias
        'sodienthoai',
        'phone',  // Alias
        'diachi',
        'address',  // Alias
        'googleID',
        'google_id',  // Alias
        'vaitro',
        'role',  // Alias
        'trangthai',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'matkhau',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'matkhau' => 'hashed',
        'vaitro' => 'integer',
        'trangthai' => 'integer',
    ];

    protected array $attributeAliases = [
        'name' => 'hoten',
        'password' => 'matkhau',
        'phone' => 'sodienthoai',
        'address' => 'diachi',
        'google_id' => 'googleID',
        'role' => 'vaitro',
        'created_at' => 'ngaytao',
        'updated_at' => 'ngaycapnhat',
    ];

    // ==========================================
    // KHAI BÁO CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // Dựa trên thiết kế DBML
    // ==========================================

    /**
     * Một User có thể có nhiều Đơn hàng
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'nguoidungID');
    }

    /**
     * Một User có thể có nhiều Giỏ hàng (hoặc 1 giỏ hàng tùy logic)
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'nguoidungID');
    }

    /**
     * Một User có thể có nhiều sản phẩm trong Wishlist
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'nguoidungID');
    }

    /**
     * Một User có thể viết nhiều Đánh giá (Reviews)
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'nguoidungID');
    }

    /**
     * Một User có thể gửi nhiều tin nhắn
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'nguoiguiID');
    }

    /**
     * Một User có thể nhận nhiều tin nhắn
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'nguoinhanID');
    }

    /**
     * Override getAuthPassword() để dùng column 'matkhau' thực tế
     */
    public function getAuthPassword()
    {
        return $this->matkhau;
    }
}