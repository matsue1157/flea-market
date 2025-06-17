@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user/profile.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
@endsection


@section('content')
    <div class="user-info">
        <div class="profile-wrapper">
            <div class="ellipse"></div>
            <img src="{{ asset('storage/' . ($user->profile_image ?? 'default_profile.png')) }}" class="profile-image"
                alt="プロフィール画像">
        </div>
        <div class="user-name">{{ $user->name }}</div>
        <a href="{{ route('profile.edit') }}" class="edit-button-wrapper">
            <div class="edit-button-rectangle">
                <div class="edit-button-text">プロフィールを編集</div>
            </div>
        </a>
    </div>

    <div class="toppage-list">
        <div class="toppage-tab osusume {{ $tab !== 'mylist' ? 'active' : '' }}">出品した商品</div>
        <div class="toppage-tab mylist {{ $tab === 'mylist' ? 'active' : '' }}">購入した商品</div>
    </div>

    <!-- 出品した商品 -->
    <div class="products-row" id="osusume-products" style="display: {{ $tab === 'mylist' ? 'none' : 'flex' }}; gap: 16px;">
        @forelse ($soldProducts as $product)
            <a href="{{ route('products.show', $product->id) }}">
                <x-product.image :product="$product" :showSold="true" />
            </a>
        @empty
            <p>出品した商品はまだありません。</p>
        @endforelse
    </div>

    <!-- 購入した商品 -->
    <div class="products-row" id="mylist-products" style="display: {{ $tab === 'mylist' ? 'flex' : 'none' }}; gap: 16px;">
        @forelse ($boughtProducts as $product)
            <a href="{{ route('products.show', $product->id) }}">
                <x-product.image :product="$product" />
            </a>
        @empty
            <p>購入した商品はまだありません。</p>
        @endforelse
    </div>


    <script>
        document.querySelectorAll('.toppage-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const tabType = tab.classList.contains('mylist') ? 'mylist' : 'osusume';
                const url = new URL(window.location.href);
                url.searchParams.set('tab', tabType);
                window.location.href = url.toString();
            });
        });
    </script>
@endsection