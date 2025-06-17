<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'comment',
    ];

    // コメントしたユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメント対象の商品
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

