@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product/show.css') }}">
    <style>
        #modal {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            justify-content: center;
            align-items: center;
        }

        #modal img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
        }

        #modal.show {
            display: flex;
        }

        .liked {
            color: red;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
        <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded">

            {{-- 商品名 --}}
            <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>

            {{-- 商品画像（モーダルで拡大） --}}
            <div class="mb-6 product-image">
                <x-product-image :product="$product" />
            </div>

            {{-- いいねボタン --}}
            <button id="like-button" data-product-id="{{ $product->id }}"
                class="mb-4 px-4 py-2 border rounded @if($isLiked) liked @endif">
                ❤️ いいね <span id="like-count">{{ $likeCount }}</span>
            </button>

            {{-- 購入ボタン --}}
            <<form method="GET" action="{{ route('purchases.create', $product->id) }}">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded w-full mb-6">
            購入手続きへ
        </button>
    </form>

            {{-- 商品詳細情報 --}}
            <div class="mb-6 space-y-2">
                <p><strong>ブランド:</strong> {{ $product->brand ?? 'なし' }}</p>
                <p><strong>カテゴリ:</strong> {{ $product->categories->pluck('name')->join(', ') }}</p>
                <p><strong>状態:</strong> {{ $conditions[$product->condition] ?? '不明' }}</p>
                @if ($product->condition_detail)
                    <p><strong>詳細:</strong> {{ $product->condition_detail }}</p>
                @endif
                @if ($product->color)
                    <p><strong>色:</strong> {{ $product->color }}</p>
                @endif
                <p><strong>価格:</strong> ¥{{ number_format($product->price) }}</p>
                <p><strong>説明:</strong></p>
                <p>{{ $product->description }}</p>
            </div>

            {{-- コメント一覧 --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3">コメント</h2>
                <div id="comments-list" class="space-y-2">
                    @foreach ($comments as $comment)
                        <div class="comment p-3 border rounded" data-comment-id="{{ $comment->id }}">
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-gray-500">{{ $comment->created_at->format('Y/m/d H:i') }}</small>
                            <p>{{ $comment->body }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- コメント投稿フォーム --}}
            <form id="comment-form" data-product-id="{{ $product->id }}">
                @csrf
                <textarea id="comment-text" name="comment" rows="3" class="w-full border border-gray-300 p-2 rounded mb-2"
                    placeholder="コメントを入力してください..." required></textarea>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    コメント投稿
                </button>
            </form>
        </div>

        {{-- モーダル（画像拡大） --}}
        <div id="modal">
            <img id="modal-image" src="" alt="拡大画像">
        </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // いいね処理
            const likeBtn = document.getElementById('like-button');
            likeBtn.addEventListener('click', () => {
                const productId = likeBtn.dataset.productId;

                fetch(`/products/${productId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('like-count').textContent = data.likeCount;
                            likeBtn.classList.toggle('liked', data.liked);
                        } else if (data.message) {
                            alert(data.message);
                        }
                    });
            });

            // コメント投稿処理
            const commentForm = document.getElementById('comment-form');
            commentForm.addEventListener('submit', e => {
                e.preventDefault();

                const productId = commentForm.dataset.productId;
                const commentText = document.getElementById('comment-text').value.trim();

                if (!commentText || commentText.length < 5) {
                    alert('コメントは5文字以上で入力してください。');
                    return;
                }

                fetch(`/products/${productId}/comments`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ comment: commentText }),
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const commentList = document.getElementById('comments-list');
                            const div = document.createElement('div');
                            div.className = 'comment p-3 border rounded mt-2';
                            div.dataset.commentId = data.comment.id;
                            div.innerHTML = `
                                    <strong>${data.comment.user_name}</strong>
                                    <small class="text-gray-500">${data.comment.created_at}</small>
                                    <p>${data.comment.body}</p>
                                `;
                            commentList.prepend(div);
                            document.getElementById('comment-text').value = '';

                            // フォーカスと背景ハイライト
                            div.scrollIntoView({ behavior: 'smooth' });
                            div.style.backgroundColor = '#fefcbf';
                            setTimeout(() => div.style.backgroundColor = '', 1500);
                        } else if (data.errors) {
                            alert(Object.values(data.errors).flat().join('\n'));
                        } else if (data.message) {
                            alert(data.message);
                        }
                    });
            });

            // モーダル画像拡大
            const modal = document.getElementById('modal');
            const modalImage = document.getElementById('modal-image');
            const productImage = document.querySelector('.product-image img');

            if (productImage) {
                productImage.addEventListener('click', () => {
                    modalImage.src = productImage.src;
                    modalImage.alt = productImage.alt;
                    modal.classList.add('show');
                });
            }

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('show');
                }
            });
        });
    </script>
@endsection