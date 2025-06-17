<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'buyer_id',
        'name',
        'brand',
        'description',
        'price',
        'condition',
        'is_sold',
        'image',
    ];

    // 出品者（Userモデル）
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 購入者（Userモデル）
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // 商品をいいねしたユーザー一覧（多対多）
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    // 商品へのコメント
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 商品のカテゴリ（多対多）
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withTimestamps();
    }

    // 画像URLのアクセサ（storage/app/public配下に画像保存している場合）
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/no-image.png');
        }

        // http(s) で始まるならそのまま返す（外部画像URL）
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        ;
    }
}