{{-- resources/views/likes/index.blade.php --}}
@extends('layouts.app')

@section('css')

@endsection
@section('content')
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('likes.index') }}" class="mb-4">
            <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}"
                class="border p-2 w-1/2 rounded" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">検索</button>
        </form>

        @if($products->isEmpty())
            <p class="text-gray-600">マイリストに商品はありません。</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </div>
@endsection