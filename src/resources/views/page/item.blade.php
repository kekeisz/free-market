@extends('layouts.app')
@section('title', '商品詳細')

{{-- itemページ専用CSSを読み込む（layouts.app に @yield("css") がある前提） --}}
@section('css')
  <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
  <div class="item-page">

    {{-- 上段：左=画像 / 右=商品情報＋コメントまで全部 --}}
    <div class="item-layout">

      {{-- 左：商品画像エリア --}}
      <div class="item-image-area">
        @if (!empty($item->image))
          <img
            src="{{ asset('storage/' . $item->image) }}"
            alt="{{ $item->name }}"
            class="item-image"
          >
        @else
          <div class="item-image item-image--placeholder">
            画像なし
          </div>
        @endif
      </div>

      {{-- 右：商品情報エリア（商品情報＋コメントも全部ここに入れる） --}}
      <div class="item-info-area">

        {{-- 商品名 & ブランド --}}
        <div class="item-title-block">
          <h1 class="item-title">
            {{ $item->name }}
          </h1>

          {{-- ブランド名：カラムがある前提。無ければこの@ifごと消してOK --}}
          @if (!empty($item->brand))
            <p class="item-brand">
              {{ $item->brand }}
            </p>
          @endif
        </div>

        {{-- 価格（+ 税込） --}}
        <div class="item-price-row">
          <span class="item-price">
              ¥{{ number_format($item->price) }}
          </span>
          <span class="item-price-tax">
            (税込)
          </span>
        </div>

        {{-- いいね＆コメントアイコン行 --}}
        <div class="item-social-row">

          {{-- いいね --}}
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
                  alt="いいね（ログインが必要です）"
                  class="item-social-icon"
                >
              </div>
            @endauth

            <span class="item-social-count">
              {{ $item->likes_count }}
            </span>
          </div>

          {{-- コメントアイコン --}}
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

        {{-- 購入ボタン --}}
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
                Sold
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

        {{-- 商品説明 --}}
        <div class="item-section">
          <h2 class="item-section-title">
            商品説明
          </h2>
          <p class="item-description">
            {{ $item->description }}
            {{-- 改行を反映したい場合は↓に差し替え
            {!! nl2br(e($item->description)) !!}
            --}}
          </p>
        </div>

        {{-- 商品の情報 --}}
        <div class="item-section">
          <h2 class="item-section-title">
            商品の情報
          </h2>

          {{-- カテゴリー --}}
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

          {{-- 商品の状態 --}}
          <div class="item-info-row">
            <span class="item-info-label">商品の状態</span>
            <span class="item-info-value">
              {{ $item->condition->name ?? '未設定' }}
            </span>
          </div>
        </div>

        {{-- ★ ここからコメントエリアも右ブロック内に含める --}}
        <div class="item-comments-block">

          {{-- コメント一覧タイトル --}}
          <h2 class="item-section-title item-section-title-comment">
            コメント（{{ $item->comments_count }}）
          </h2>

          {{-- コメント一覧 --}}
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
                  <div class="item-comment-meta">
                    <div class="item-comment-author">
                      {{ $comment->user->name ?? '不明' }}
                    </div>
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

          {{-- コメント投稿フォーム --}}
          <div class="item-comment-form-block">
            <h2 class="item-section-title item-section-title-comment_form">
              商品へのコメント
            </h2>

            @auth
              @if ($errors->has('body'))
                <p class="item-comment-error">
                  {{ $errors->first('body') }}
                </p>
              @endif

              <form
                action="{{ route('item.comment.store', $item->id) }}"
                method="POST"
                class="item-comment-form"
              >
                @csrf

                <div class="item-comment-form-field">
                  <textarea
                    name="body"
                    rows="4"
                    class="item-comment-textarea"
                    placeholder="コメントを入力してください（255文字まで）"
                  >{{ old('body') }}</textarea>
                </div>

                <div class="item-comment-form-actions">
                  <button type="submit" class="btn-comment-submit">
                    コメントを送信する
                  </button>
                </div>
              </form>
            @else
              <p class="item-comment-login-required">
                コメントするには
                <a href="{{ route('login') }}">ログイン</a>
                してください。
              </p>
            @endauth
          </div>

        </div>{{-- /.item-comments-block --}}

      </div>{{-- /.item-info-area --}}

    </div>{{-- /.item-layout --}}

  </div>
@endsection
