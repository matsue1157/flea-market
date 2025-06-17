<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return view('likes.index', ['products' => collect()]); // 空のコレクション
        }

        $query = $user->likes()->with('product');

        if ($request->filled('keyword')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        }

        $products = $query->get()->pluck('product')->filter();

        return view('likes.index', compact('products'));
    }
    // いいね追加・解除（Ajax等想定）
    public function toggle(Request $request, $productId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'ログインが必要です'], 401);
        }

        $product = Product::findOrFail($productId);

        $like = Like::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($like) {
            // いいね解除
            $like->delete();
            $liked = false;
        } else {
            // いいね追加
            Like::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $liked = true;
        }

        $likeCount = $product->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likeCount' => $likeCount,
        ]);
    }

}
