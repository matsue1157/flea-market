@extends('layouts.guest')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="auth-container">
        <h1 class="auth-title">会員登録</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name" class="auth-label">ユーザー名</label>
            <input type="text" name="name" id="name" class="auth-input" value="{{ old('name') }}">
            @error('name') <div class="auth-error">{{ $message }}</div> @enderror

            <label for="email" class="auth-label">メールアドレス</label>
            <input type="email" name="email" id="email" class="auth-input" value="{{ old('email') }}">
            @error('email') <div class="auth-error">{{ $message }}</div> @enderror

            <label for="password" class="auth-label">パスワード</label>
            <input type="password" name="password" id="password" class="auth-input">
            @error('password') <div class="auth-error">{{ $message }}</div> @enderror

            <label for="password_confirmation" class="auth-label">確認用パスワード</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="auth-input">

            <button type="submit" class="auth-button">登録</button>

            <div class="auth-footer">
                <a href="{{ route('login') }}">ログインはこちら</a>
            </div>
        </form>
    </div>
@endsection