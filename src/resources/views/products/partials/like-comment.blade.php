<div class="like-comment-section">
  {{-- いいねボタン --}}
  <button id="like-button" class="{{ $liked ? 'liked' : 'not-liked' }}">
    <i id="like-icon" class="fa fa-heart"></i>
    <span id="like-count">{{ $likeCount }}</span>
  </button>

  {{-- コメント数 --}}
  <span>コメント数: {{ $commentCount }}</span>

  {{-- コメント投稿フォーム --}}
  @auth
      <form method="POST" action="{{ route('comments.store', $product->id) }}">
        @csrf
        <textarea name="content" placeholder="コメントを入力"></textarea>
        <button type="submit">投稿</button>
      </form>
  @endauth
</div>