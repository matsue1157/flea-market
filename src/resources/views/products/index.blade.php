@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product/index.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
@endsection

@section('content')
    <!-- トップページリストエリア -->
    <div class="toppage-list">
        <a href="{{ route('products.index', ['tab' => 'default']) }}"
            class="toppage-tab osusume {{ $tab !== 'mylist' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ route('products.index', ['tab' => 'mylist']) }}"
            class="toppage-tab mylist {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>

        <div class="line-2"></div>
    </div>

    <!-- 商品カードエリア -->
    <div class="products-row">
        @forelse ($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="product-card">

                <div class="relative">
                    <x-product-image :product="$product" />

                    @if ($product->is_sold)
                        <span class="sold-badge">SOLD</span>
                    @endif
                </div>

                <div class="product-name">{{ $product->name }}</div>
            </a>
        @empty
            <p>{{ $tab === 'mylist' ? 'マイリストに商品がありません。' : '出品した商品はまだありません。' }}</p>
        @endforelse
    </div>
@endsection