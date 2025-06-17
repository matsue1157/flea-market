<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header-icon">
            <img src="{{ asset('images/logo.svg')}}" alt="ロゴ画像" class="logo">
        </div>

        <div class="header-search">
    <form action="{{ route('products.index') }}" method="GET">
        <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
        <button type="submit">検索</button>
    </form>
</div>

        <nav class="header-nav">
    @guest
        <a href="{{ route('login') }}">ログイン</a>
    @else
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="logout-link">ログアウト</button>
        </form>
        <a href="{{ route('mypage.index') }}">マイページ</a>
        <a href="{{ route('products.create') }}" class="sell-button">出品</a>
    @endguest
</nav>
    </header>

    <main>
        @yield('content')
        @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    </main>
    @yield('js')
</body>

</html>