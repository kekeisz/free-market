@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
    <div class="item-page">
        <div class="item-layout">
            <div class="item-image-area">
                @if (!empty($item->image))
                    <img
                        src="{{ asset('storage/' . $item->image) }}"
                        alt="{{ $item->name }}"
                        class="item-image"
                    >
                @else
                    <div class="item-image item-image--placeholder">
                        No Image
                    </div>
                @endif
            </div>

            <div class="item-info-area">
                <div class="item-title-block">
                    <h1 class="item-title">
                        {{ $item->name }}
                    </h1>

                    @if (!empty($item->brand))
                        <p class="item-brand">
                            {{ $item->brand }}
                        </p>
                    @endif
                </div>

                <div class="item-price-row">
                    <span class="item-price">
                        ¥{{ number_format($item->price) }}
                    </span>
                    <span class="item-price-tax">
                        (税込)
                    </span>
                </div>

                <div class="item-social-row">
                    <div class="item-social-group">
                        @auth
                            @php
                                $userLiked = $item->likes->contains('user_id', auth()->id());
                            @endphp

                            @if ($userLiked)
                                <form
                                    action="{{ route('item.unlike', $item->id) }}"
                                    method="POST"
                                    class="item-like-form"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="item-social-button">
                                        <img
                                            src="{{ asset('images/item/heart-pink.png') }}"
                                            alt="いいね解除"
                                            class="item-social-icon"
                                        >
                                    </button>
                                </form>
                            @else
                                <form
                                    action="{{ route('item.like', $item->id) }}"
                                    method="POST"
                                    class="item-like-form"
                                >
                                    @csrf

                                    <button type="submit" class="item-social-button">
                                        <img
                                            src="{{ asset('images/item/heart-default.png') }}"
                                            alt="いいね"
                                            class="item-social-icon"
                                        >
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="item-social-button-wrapper">
                                <img
                                    src="{{ asset('images/item/heart-default.png') }}"
                                    alt="いいね"
                                    class="item-social-icon"
                                >
                            </div>
                        @endauth

                        <span class="item-social-count">
                            {{ $item->likes_count }}
                        </span>
                    </div>

                    <div class="item-social-group">
                        <div class="item-social-button-wrapper">
                            <img
                                src="{{ asset('images/item/comment.png') }}"
                                alt="コメント"
                                class="item-social-icon"
                            >
                        </div>
                        <span class="item-social-count">
                            {{ $item->comments_count }}
                        </span>
                    </div>
                </div>

                <div class="item-purchase-row">
                    @auth
                        @if (! $item->is_sold)
                            <a
                                href="{{ route('purchase.confirm', $item->id) }}"
                                class="btn-purchase-main"
                            >
                                購入手続きへ
                            </a>
                        @else
                            <p class="sold-label">
                                SOLD
                            </p>
                        @endif
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="btn-purchase-main btn-purchase-main--login"
                        >
                            ログインして購入手続きへ
                        </a>
                    @endauth
                </div>

                <div class="item-section">
                    <h2 class="item-section-title item-section-title-description">
                        商品説明
                    </h2>
                    <p class="item-description">
                        {!! nl2br(e($item->description)) !!}
                    </p>
                </div>

                <div class="item-section">
                    <h2 class="item-section-title">
                        商品の情報
                    </h2>

                    <div class="item-info-row">
                        <span class="item-info-label">カテゴリー</span>
                        <div class="item-category-list">
                            @foreach ($item->categories as $category)
                                <span class="item-category-pill">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="item-info-row">
                        <span class="item-info-label">商品の状態</span>
                        <span class="item-info-value">
                            {{ $item->condition->name ?? '未設定' }}
                        </span>
                    </div>
                </div>

                <div class="item-comments-block">
                    <h2 class="item-section-title item-section-title-comment">
                        コメント（{{ $item->comments_count }}）
                    </h2>

                    <div class="item-comments">
                        @forelse ($item->comments as $comment)
                            <div class="item-comment">
                                <div class="item-comment-header">
                                    <div class="item-comment-avatar">
                                        @if (!empty($comment->user->profile_image))
                                            <img
                                                src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                                alt="{{ $comment->user->name }}"
                                                class="item-comment-avatar-image"
                                            >
                                        @else
                                            <div class="item-comment-avatar-placeholder">
                                                {{ mb_substr($comment->user->name ?? '？', 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="item-comment-author">
                                        {{ $comment->user->name ?? '不明' }}
                                    </div>
                                </div>

                                <div class="item-comment-body-box">
                                    <p class="item-comment-body-text">
                                        {{ $comment->body }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="item-comments-empty">
                                コメントはまだありません。
                            </p>
                        @endforelse
                    </div>

                    <div class="item-comment-form-block">
                        <h2 class="item-section-title item-section-title-comment_form">
                            商品へのコメント
                        </h2>

                        <form
                            action="{{ route('item.comment.store', $item->id) }}"
                            method="POST"
                            class="item-comment-form js-comment-form"
                        >
                            @csrf

                            <div class="item-comment-form-field">
                                <textarea
                                    name="body"
                                    rows="4"
                                    class="item-comment-textarea"
                                    placeholder="コメントを入力してください（255文字まで）"
                                >{{ old('body') }}</textarea>

                                @error('body')
                                    <p class="item-comment-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="item-comment-form-actions">
                                <button
                                    type="submit"
                                    class="btn-comment-submit js-comment-submit"
                                >
                                    コメントを送信する
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('.js-comment-form');
        const button = document.querySelector('.js-comment-submit');

        if (!form || !button) {
            return;
        }

        let hasSubmitted = false;

        form.addEventListener('submit', (event) => {
            if (hasSubmitted) {
                event.preventDefault();
                return;
            }

            hasSubmitted = true;
            button.disabled = true;
        });
    });
</script>
@endsection
