@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="auth-page">
        <h1 class="auth-title">ログイン</h1>

        <form
            method="POST"
            action="{{ route('login') }}"
            class="auth-form"
            novalidate
        >
            @csrf

            <div class="form-field">
                <label class="form-label">
                    メールアドレス
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input"
                >
                @error('email')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-field">
                <label class="form-label">
                    パスワード
                </label>
                <input
                    type="password"
                    name="password"
                    class="form-input"
                >
                @error('password')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror
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
