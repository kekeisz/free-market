@extends('layouts.app')

@section('title', '会員登録')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="auth-page">
        <h1 class="auth-title">会員登録</h1>

        @if ($errors->any())
            <div class="form-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('register') }}"
            class="auth-form"
        >
            @csrf

            <div class="form-field">
                <label class="form-label">
                    ユーザー名
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="form-input"
                >
            </div>

            <div class="form-field">
                <label class="form-label">
                    メールアドレス
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="form-input"
                >
            </div>

            <div class="form-field">
                <label class="form-label">
                    パスワード
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    minlength="8"
                    class="form-input"
                >
            </div>

            <div class="form-field">
                <label class="form-label">
                    確認用パスワード
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    minlength="8"
                    class="form-input"
                >
            </div>

            <button type="submit" class="auth-submit-button">
                会員登録
            </button>
        </form>

        <p class="auth-link">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </p>
    </div>
@endsection
