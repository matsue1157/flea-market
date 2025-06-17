<!-- resources/views/components/search-form.blade.php -->
<div class="search-form">
    <form action="{{ route('products.index') }}" method="GET">
        <select name="category_id">
            <option value="">すべてのカテゴリ</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">検索</button>
    </form>
</div>

<x-search-form />