@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
    <header class="auth-header">
        <img src="{{ asset('images/logo.png') }}" alt="CoachTech Logo" class="auth-logo">
    </header>

    <div class="verify-container">
        <p class="verify-message">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="verify-status">認証メールを再送しました。</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify-button">認証はこちらから</button>
        </form>
        <p class="resend-text">
        <a href="{{ route('verification.send') }}"
               onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
               class="resend-link">
                確認メールを再送する
            </a>
            </p>
            <form id="resend-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
            @csrf
        </form>
    </div>
@endsection