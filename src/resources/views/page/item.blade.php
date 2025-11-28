@extends('layouts.app')
@section('title','商品詳細')
@section('content')
  <div class="item-page">

    {{-- 商品メイン情報 --}}
    <div class="item-header">
      <h1 class="item-title">
        {{ $item->name }}
      </h1>

      <p class="item-price">
        価格：{{ number_format($item->price) }} 円
      </p>

      <p class="item-seller">
        出品者：{{ $item->user->name ?? '不明' }}
      </p>

      <p class="item-categories">
        カテゴリ：
        @foreach($item->categories as $category)
          <span class="item-category">
            {{ $category->name }}
          </span>
        @endforeach
      </p>

      <p class="item-stats">
        いいね：{{ $item->likes_count }}

        コメント：{{ $item->comments_count }}
      </p>
    </div>

    {{-- 購入ボタン --}}
    @auth
      @if (!$item->is_sold)
        <a href="{{ route('purchase.confirm', $item->id) }}" class="btn-purchase">
          購入する
        </a>
      @else
        <p class="sold-label">Sold</p>
      @endif
    @else
      <a href="{{ route('login') }}" class="btn-login-required">
        ログインして購入する
      </a>
    @endauth

    {{-- コメント一覧 --}}
    <div class="item-comments">
      <h2 class="item-comments-title">
        コメント
      </h2>

      @forelse($item->comments as $comment)
        <div class="item-comment">
          <div class="item-comment-author">
            {{ $comment->user->name ?? '不明' }}
          </div>
          <div class="item-comment-body">
            {{ $comment->body }}
          </div>
        </div>
      @empty
        <p class="item-comments-empty">
          コメントはまだありません。
        </p>
      @endforelse
    </div>

  </div>
@endsection
