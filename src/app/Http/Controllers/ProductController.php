<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    // 商品一覧（自分の出品を除く全商品、もしくはいいね済み一覧）
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('tab', 'default');

        if ($tab === 'mylist' && $user) {
            $products = Product::whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->withCount('likes', 'comments')
                ->paginate(10)
                ->appends(['tab' => 'mylist']);

            return view('products.index', compact('products', 'tab'));
        }

        $query = Product::query()
            ->withCount('likes', 'comments')
            ->where('is_sold', false);

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        /*
        if ($user && !$user->is_admin) {
            $query->where('user_id', '!=', $user->id);
        }
        */
        $products = $query->paginate(10);

        return view('products.index', compact('products', 'tab'));
    }

    // 商品詳細
    public function show($id)
    {
        $product = Product::with(['likes', 'comments.user', 'categories'])->findOrFail($id);
        $likeCount = $product->likes->count();
        $commentCount = $product->comments->count();

        $isLiked = auth()->check()
            ? $product->likes->contains('user_id', auth()->id())
            : false;

        $categories = $product->categories;
        $comments = $product->comments; // ✅ これを追加！

        $conditions = [
            '1' => '新品・未使用',
            '2' => '未使用に近い',
            '3' => '目立った傷や汚れなし',
            '4' => 'やや傷や汚れあり',
            '5' => '傷や汚れあり',
            '6' => '全体的に状態が悪い',
        ];

        return view('products.show', compact(
            'product',
            'likeCount',
            'commentCount',
            'isLiked',
            'categories',
            'conditions',
            'comments' // ✅ 忘れずに渡す
        ));
    }

    // 出品フォーム表示
    public function create()
    {

      //  dd(auth()->check(), auth()->user());

        $categories = Category::all();
        $conditions = [
            '1' => '新品・未使用',
            '2' => '未使用に近い',
            '3' => '目立った傷や汚れなし',
            '4' => 'やや傷や汚れあり',
            '5' => '傷や汚れあり',
            '6' => '全体的に状態が悪い',
        ];

        return view('products.create', compact('categories', 'conditions'));
    }

    // 出品処理
    public function store(ProductStoreRequest $request)
{
       // dd($request->all()


    $product = new Product();
    $product->user_id = Auth::id();
    $product->name = $request->name;
    $product->brand = $request->brand;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->condition = $request->condition;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }

    $product->save();

    // フォームのチェックボックス名に合わせる
        $product->categories()->sync($request->input('category_ids'));

    return redirect()->route('products.show', $product->id)
        ->with('success', '商品を出品しました。');
}

    // いいねトグル（Ajax）
    public function toggleLike($id): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'ログインしてください'], 401);
        }

        $product = Product::findOrFail($id);

        if ($product->likes()->where('user_id', $user->id)->exists()) {
            $product->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $product->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        $likeCount = $product->likes()->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likeCount' => $likeCount,
        ]);
    }

    // コメント投稿（Ajax）
    public function addComment(Request $request, $id): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'ログインしてください'], 401);
        }

        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $product = Product::findOrFail($id);

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->product_id = $product->id;
        $comment->body = $request->comment;
        $comment->save();

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'user_name' => $comment->user->name,
                'created_at' => $comment->created_at->format('Y/m/d H:i'),
                'body' => $comment->body,
            ],
        ]);
    }
}