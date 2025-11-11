@extends('layouts.app')
@section('title','会員登録')
@section('content')
  <h1 class="text-xl font-bold mb-4">会員登録</h1>
  @if ($errors->any())
    <div style="color:red">{{ $errors->first() }}</div>
  @endif
  <form method="POST" action="/register">
    @csrf
    <div>
      <label>ユーザー名</label>
      <input type="text" name="name" required>
    </div>
    <div>
      <label>メール</label>
      <input type="email" name="email" required>
    </div>
    <div><label>パスワード</label><input type="password" name="password" required minlength="8"></div>
    <div><label>確認用パスワード</label><input type="password" name="password_confirmation" required minlength="8"></div>
    <button type="submit">登録</button>
  </form>
  <p class="mt-4"><a href="/login">ログインへ</a></p>
@endsection
