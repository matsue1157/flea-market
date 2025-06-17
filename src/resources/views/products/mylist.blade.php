@extends('layouts.app')

@section('content')
    @if(Auth::check())
        <div class="products-row">
@forelse ($likedProducts as $product)
    <div class="product-image">
        <a href="{{ route('products.show', $product->id) }}">
            <x-product-image :product="$product" />
        </a>
        <div class="product-name">{{ $product->name }}</div>
    </div>
@empty
    <p>いいねした商品はありません。</p>
@endforelse
        </div>
    @else
        <p>マイリストはログインユーザーのみ表示されます。</p>
    @endif
@endsection