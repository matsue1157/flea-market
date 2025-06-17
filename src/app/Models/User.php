<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // このユーザーが出品した商品
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // このユーザーが購入した商品（productsテーブルのbuyer_idで判定）
    public function boughtProducts()
    {
        return $this->hasMany(Product::class, 'buyer_id');
    }

    // このユーザーがいいねした商品
    public function likes()
    {
        return $this->belongsToMany(Product::class, 'likes')->latest('likes.created_at');
    }
}