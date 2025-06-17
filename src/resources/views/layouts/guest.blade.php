<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/guest.css') }}">
    @yield('css')
</head>

<body>
    <header class="w-full p-4 bg-white shadow">
        <div class="max-w-screen-xl mx-auto flex justify-center sm:justify-start">
            <img src="{{ asset('images/logo.svg')}}" alt="ロゴ画像" class="logo">
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>