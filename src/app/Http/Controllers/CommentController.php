<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // コメント投稿
    public function store(Request $request, $productId)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $product = Product::findOrFail($productId);

        Comment::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => $request->content,
        ]);

        return redirect()->route('products.show', $product->id)->with('status', 'コメントを投稿しました。');
    }

}
