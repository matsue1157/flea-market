<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 自分が出品した全商品（売れた・売れてない含む）
        $soldProducts = Product::where('user_id', $user->id)->get();

        // 自分が購入した商品（buyer_idカラムがproductsテーブルにある場合）
        $boughtProducts = Product::where('buyer_id', $user->id)->get();

        // タブ切替用パラメータ（URL ?tab=osusume or ?tab=mylist）
        $tab = $request->query('tab', 'osusume');

      //  dd($soldProducts);

        return view('user.profile', compact('user', 'tab', 'soldProducts', 'boughtProducts'));
    }
}