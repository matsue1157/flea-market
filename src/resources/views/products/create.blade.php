@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product/create.css') }}">
    <style>
        /* プレビュー画像のサイズ調整 */
        #preview-container img {
            display: none;
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 4px;
            object-fit: contain;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="form-wrapper">
        <h2 class="section-title">商品の出品</h2>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 商品画像 -->
            <div class="image-upload-wrapper">
                <div class="image-upload-label">商品画像</div>
                <label class="file-input-button" for="image">画像を選択する</label>
                <input type="file" id="image" name="image" accept="image/*" />

                <!-- プレビュー画像 -->
                <div id="preview-container">
                    <img id="preview" style="display:none; max-width:200px; margin-top:10px;">
                </div>

                @error('image')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- 以下、商品詳細などの入力フォーム（省略可） -->
            <div class="form-group">
                <p class="section-subtitle">商品の詳細</p>
            </div>


            <div class="form-group exhibited-product-category-area">
                <label class="form-label">カテゴリー</label>
                <div class="product-category-wrapper">
                    @foreach ($categories as $category)
                        <label class="product-category-item">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('category_ids')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="condition">商品の状態 <span class="text-muted">(選択してください)</span></label>
                <div class="select-wrapper">
                    <select id="condition" name="condition">
                        <option value="">選択してください</option>
                        @foreach ($conditions as $key => $label)
                            <option value="{{ $key }}" {{ old('condition') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('condition')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" class="form-input" value="{{ old('brand') }}">
                @error('brand')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">商品説明</label>
                <textarea id="description" name="description" class="form-textarea">{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">販売価格</label>
                <div class="input-with-icon">
                    <span>¥</span>
                    <input type="number" id="price" name="price" class="form-input" value="{{ old('price') }}">
                </div>
                @error('price')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- 送信ボタン -->
            <div class="form-action">
                <button type="submit" class="submit-button">出品する</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'inline-block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>
@endsection