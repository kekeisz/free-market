@extends('layouts.app')

@section('title', 'メール認証')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
    <div class="verify-email-page">
        <div class="verify-email-card">
            <p class="verify-email-text">
                登録していただいたメールアドレスに認証メールを送信しました。<br>
                メール認証を完了してください。
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="verify-email-status">
                    認証メールを再送しました。
                </p>
            @endif

            <div class="verify-email-actions">
                <a
                    href="{{ config('app.mailhog_url', 'http://localhost:8025') }}"
                    class="verify-email-button"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    認証はこちらから
                </a>

                <form method="POST" action="{{ route('verification.send') }}" class="verify-email-resend-form">
                    @csrf
                    <button type="submit" class="verify-email-resend-link">
                        認証メールを再送する
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
