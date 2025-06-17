<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;       // 追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if ($product->user_id === Auth::id()) {
            return redirect()->back()->with('error', '自分の商品は購入できません。');
        }

        if ($product->is_sold ?? false) {
            return redirect()->back()->with('error', 'この商品はすでに売り切れです。');
        }

        $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'shipping_address' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($product, $request) {
            $product->buyer_id = Auth::id();
            $product->is_sold = true;
            $product->save();

            Purchase::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'payment_method_id' => $request->payment_method_id,
                'shipping_address' => $request->shipping_address,
                'purchased_at' => now(),
            ]);
        });

        return redirect()->route('products.show', $product->id)->with('success', '購入手続きが完了しました。');
    }

    public function create(Product $product)
    {
        $product->load('seller');
        $paymentMethods = PaymentMethod::all();
        $address = auth()->user()->address ?? '';
        
    return view('purchase.create', compact('product', 'paymentMethods'));

    }
}