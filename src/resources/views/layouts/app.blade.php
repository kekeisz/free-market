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
                {{-- ロゴ --}}
                <a href="{{ route('top') }}" class="app-logo">
                    <img
                        src="{{ asset('images/logos/coachtech-logo.png') }}"
                        alt="ヘッダーロゴ"
                        class="app-logo-img"
                    >
                </a>

                {{-- 検索フォーム（ログイン/会員登録画面以外で表示） --}}
                @if (!request()->routeIs('login', 'register'))
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
                @endif

                {{-- 右側ナビゲーション --}}
                <nav class="app-nav">
                    @auth
                        {{-- ① ログアウト --}}
                        <form
                            method="post"
                            action="/logout"
                            class="app-logout-form"
                        >
                            @csrf
                            <button type="submit" class="app-nav-link app-logout-button">
                                ログアウト
                            </button>
                        </form>

                        {{-- ② マイページ --}}
                        <a href="/mypage" class="app-nav-link">マイページ</a>

                        {{-- ③ 出品（白ボタン） --}}
                        <a href="/sell" class="app-nav-sell-btn">出品</a>
                    @else
                        <a href="/login" class="app-nav-link">ログイン</a>
                        <a href="/register" class="app-nav-link">会員登録</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="app-main">
            @yield('content')
        </main>
    </body>
</html>
