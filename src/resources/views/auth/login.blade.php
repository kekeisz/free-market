@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="auth-page">
        <h1 class="auth-title">ログイン</h1>

        @if ($errors->any())
            <div class="form-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('login') }}"
            class="auth-form"
        >
            @csrf

            <div class="form-field">
                <label class="form-label">
                    メールアドレス
                </label>
                <input
                    type="email"
                    name="email"
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
                    class="form-input"
                >
            </div>

            <button type="submit" class="auth-submit-button">
                ログインする
            </button>
        </form>

        <p class="auth-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </p>
    </div>
@endsection
