<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>@yield('title','coachtech')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
  </head>
  <body class="app-body">
    <header class="app-header">
      <div class="app-header-inner">
        <a href="/" class="app-logo">
          coachtech
        </a>

        @if (!request()->routeIs('login', 'register'))
          <form
            method="GET"
            action="{{ route('top') }}"
            class="app-search-form"
          >
            @if(request()->query('page') === 'mylist')
              <input type="hidden" name="page" value="mylist">
            @endif

            <input
              type="text"
              name="keyword"
              value="{{ request()->query('keyword') }}"
              placeholder="商品名で検索"
              class="app-search-input"
            >
          </form>
        @endif

        <nav class="app-nav">
          @auth
            <a href="/sell" class="app-nav-link">出品</a>
            <a href="/?page=mylist" class="app-nav-link">マイリスト</a>
            <a href="/mypage" class="app-nav-link">マイページ</a>

            <form
              method="post"
              action="/logout"
              class="app-logout-form"
            >
              @csrf
              <button type="submit" class="app-logout-button">
                ログアウト
              </button>
            </form>
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
