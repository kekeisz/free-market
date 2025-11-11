@extends('layouts.app')
@section('title','ログイン')
@section('content')
  <h1 class="text-xl font-bold mb-4">ログイン</h1>
  @if ($errors->any())
    <div style="color:red">
      {{ $errors->first() }}
    </div>
  @endif
  <form method="POST" action="/login">
    @csrf
    <div>
      <label>メール</label>
      <input type="email" name="email" required>
    </div>
    <div>
      <label>パスワード</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit">ログイン</button>
  </form>
  <p class="mt-4"><a href="/register">会員登録へ</a></p>
@endsection
