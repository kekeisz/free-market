<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>@yield('title','coachtech')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-50">
<header class="border-b bg-white">
  <div class="mx-auto max-w-screen-xl px-4 py-3 flex items-center justify-between">
    <a href="/" class="font-bold">
      coachtech
    </a>
    <form action="/" method="get" class="hidden md:block">
      <input name="q" placeholder="商品名で検索" class="border rounded px-3 py-1">
    </form>
    <nav class="flex gap-4">
      @auth
        <a href="/sell">出品</a>
        <a href="/?page=mylist">マイリスト</a>
        <a href="/mypage">マイページ</a>
        <form method="post" action="/logout" class="inline">
          @csrf
          <button>ログアウト</button>
        </form>
      @else
        <a href="/login">ログイン</a>
        <a href="/register">会員登録</a>
      @endauth
    </nav>
  </div>
</header>
<main class="mx-auto max-w-screen-xl px-4 py-8">
  @yield('content')
</main>
</body>
</html>
