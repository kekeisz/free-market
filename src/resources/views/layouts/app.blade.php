<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'coachtech')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        @yield('css')
    </head>

    <body class="app-body">
        <header class="app-header">
            <div class="app-header-inner">
                <a href="{{ route('top') }}" class="app-logo">
                    <img
                        src="{{ asset('images/logos/coachtech-logo.png') }}"
                        alt="ヘッダーロゴ"
                        class="app-logo-img"
                    >
                </a>

                @unless (request()->routeIs('login', 'register', 'verification.notice'))
                    <form
                        method="GET"
                        action="{{ route('top') }}"
                        class="app-search-form"
                    >
                        @if (request()->query('page') === 'mylist')
                            <input type="hidden" name="page" value="mylist">
                        @endif

                        <input
                            type="text"
                            name="keyword"
                            value="{{ request()->query('keyword') }}"
                            placeholder="なにをお探しですか？"
                            class="app-search-input"
                        >
                    </form>

                    <nav class="app-nav">
                        @auth
                            <form
                                method="POST"
                                action="{{ url('/logout') }}"
                                class="app-logout-form"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="app-nav-link app-logout-button"
                                >
                                    ログアウト
                                </button>
                            </form>

                            <a href="{{ route('mypage') }}" class="app-nav-link">
                                マイページ
                            </a>

                            <a href="{{ route('sell.create') }}" class="app-nav-sell-btn">
                                出品
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="app-nav-link">
                                ログイン
                            </a>

                            <a href="{{ route('register') }}" class="app-nav-link">
                                会員登録
                            </a>
                        @endauth
                    </nav>
                @endunless
            </div>
        </header>

        <main class="app-main">
            @yield('content')
        </main>
    </body>
</html>
