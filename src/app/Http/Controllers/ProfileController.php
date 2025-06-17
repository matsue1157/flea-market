<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProfileController extends Controller
{
    /**
     * プロフィール設定画面を表示
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * プロフィール情報を更新
     */
    public function update(Request $request)
    {
        $request->validate([
            'nickname' => ['required', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'self_intro' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        $user->nickname = $request->nickname;
        $user->birthdate = $request->birthdate;
        $user->gender = $request->gender;
        $user->self_intro = $request->self_intro;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'プロフィールを更新しました。');
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('tab', 'osusume');

        // 売れた商品
        $soldProducts = $user->products()
            ->where('is_sold', true)
            ->get();

        $boughtProducts = \App\Models\Product::where('buyer_id', $user->id)->get();

        return view('user.profile', compact('user', 'soldProducts', 'boughtProducts', 'tab'));
    }

    // 購入商品一覧
    public function purchasedProducts()
    {
        $user = Auth::user();

        // 購入した商品を buyer_id で絞り込み、seller情報も取得
        $products = Product::with('seller')
            ->where('buyer_id', $user->id)
            ->paginate(10);

        return view('profile.purchases', compact('products'));
    }

}