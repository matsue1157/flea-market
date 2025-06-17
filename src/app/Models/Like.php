<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    // いいねをしたユーザー（1 Like は 1 User に属す）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // いいねされた商品（1 Like は 1 Product に属す）
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
