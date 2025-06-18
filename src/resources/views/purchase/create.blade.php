@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-xl bg-white shadow rounded">
        <h2 class="text-2xl font-bold mb-4">購入手続き</h2>

        <!-- 商品情報の表示 -->
        <div class="mb-6 border p-4 rounded bg-gray-50">
            <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
            <p class="text-gray-600">価格: ¥{{ number_format($product->price) }}</p>
            <p class="text-sm text-gray-500 mt-1">出品者: {{ $product->seller->name }}</p>
        </div>

        <!-- エラーメッセージの表示 -->
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>・{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 購入フォーム -->
        <form action="{{ route('purchase.checkout', $product->id) }}" method="POST">
            @csrf

            <!-- 支払い方法 -->
            <div class="mb-4">
                <label for="payment_method_id" class="block font-semibold mb-1">支払い方法</label>
                <select name="payment_method_id" id="payment_method_id" class="w-full border rounded px-3 py-2">
                    <option value="">選択してください</option>
                    @foreach ($paymentMethods as $method)
                        <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 配送先住所 -->
            <div class="mb-4">
                <label for="shipping_address" class="block font-semibold mb-1">配送先住所</label>
                <input type="text" name="shipping_address" id="shipping_address"
                    value="{{ old('shipping_address', $address) }}" class="w-full border rounded px-3 py-2"
                    placeholder="例: 東京都渋谷区〇〇1-2-3">
            </div>

            <!-- 購入ボタン -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 w-full">
                    購入する
                </button>
            </div>
        </form>

        <!-- 戻る -->
        <div class="mt-4 text-center">
            <a href="{{ route('products.show', $product->id) }}" class="text-blue-500 hover:underline">
                ← 商品詳細に戻る
            </a>
        </div>
    </div>
@endsection