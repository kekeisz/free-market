@extends('layouts.app')

@section('title', '会員登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="auth-page">
        <h1 class="auth-title">会員登録</h1>

        <form
            method="POST"
            action="{{ route('register') }}"
            class="auth-form"
            novalidate
        >
            @csrf

            <div class="form-field">
                <label class="form-label" for="name">
                    ユーザー名
                </label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input"
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label class="form-label" for="email">
                    メールアドレス
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input"
                >
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
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

                @error('password')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-field">
                <label class="form-label">確認用パスワード</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-input"
                >

                @error('password_confirmation')
                    <p class="form-error">{{ $message }}</p>
                @enderror
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
