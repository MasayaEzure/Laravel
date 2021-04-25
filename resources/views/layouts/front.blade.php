<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- titleというセクション内容を各ページごとに表示 -->
    <title>@yield('title')</title>

    <!-- js/app.jsというパスを生成 -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- css/app.cssというパスを生成 -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- css/front.cssというパスを生成 -->
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary navbar-laravel">
            <div class="container">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <!-- app.phpのnameにアクセス -->
                    {{ config('app.name', 'Laravel')}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collpase navbar-collpase" id="navbarSupportedContent">
                    <!-- ナビバー左 -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- ナビバー右 -->
                    <ul class="navbar-nav ml-auto">
                        <!-- @guest~@else~@endguest：ログイン状態によって表示を切り替える -->
                        <!-- ログインしていなかったらログイン画面へのリンクを表示 -->
                        @guest
                        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <!-- ログインしていたらユーザー名とログアウトボタンを表示 -->
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <!-- contentというセクションの内容を各ページごとに表示 -->
            @yield('content')
        </main>
    </div>

</body>

</html>