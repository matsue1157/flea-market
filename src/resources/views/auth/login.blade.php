@extends('layouts.guest') {{-- 認証前用レイアウト --}}

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="auth-content">
        <h1 class="auth-title">ログイン</h1>

        @if(session('status'))
            <div class="auth-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            {{-- メールアドレス --}}
            <label for="email" class="auth-label">メールアドレス</label>
            <div class="auth-input-wrapper">
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="auth-input @error('email') auth-input-error @enderror" />
                @error('email')
                    <p class="auth-error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- パスワード --}}
            <label for="password" class="auth-label">パスワード</label>
            <div class="auth-input-wrapper">
                <input id="password" type="password" name="password"
                    class="auth-input @error('password') auth-input-error @enderror" />
                @error('password')
                    <p class="auth-error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- ログインボタン --}}
            <button type="submit" class="auth-button">ログイン</button>

            {{-- 会員登録リンク --}}
            <div class="auth-footer">
                <p>
                    アカウントをお持ちでない方は
                    <a href="{{ route('register') }}" class="auth-link">会員登録</a>
                </p>
            </div>
        </form>
    </div>
@endsection