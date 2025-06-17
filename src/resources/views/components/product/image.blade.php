@props(['product', 'showSold' => false])

@php
    use Illuminate\Support\Str;
    // 画像パスが外部URLか判定
    $isExternal = Str::startsWith($product->image, ['http://', 'https://']);
    // URLをセット。外部ならそのまま、内部ならstorageリンク経由でパス生成
    $imageUrl = $isExternal ? $product->image : asset('storage/' . $product->image);
@endphp

<div class="product-image" style="position: relative;">
    @if ($showSold && ($product->is_sold ?? false))
        <div class="sold-label" style="
            position: absolute;
            top: 8px;
            left: 8px;
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            font-weight: bold;
            border-radius: 4px;
            z-index: 10;
        ">SOLD</div>
    @endif

    <div class="rectangle" style="overflow: hidden; border-radius: 8px;">
        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" style="width: 100%; height: auto; display: block;">
    </div>
</div>