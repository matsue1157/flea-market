@props(['product'])

@php
    use Illuminate\Support\Str;
    $isExternal = Str::startsWith($product->image, ['http://', 'https://']);
@endphp

<div class="product-image" style="position: relative;">
    @if ($product->is_sold ?? false)
        <div class="sold-label">SOLD</div>
    @endif

    <img src="{{ $isExternal ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
        style="cursor: pointer; border-radius: 8px; max-width: 100%; max-height: 100%;">
</div>