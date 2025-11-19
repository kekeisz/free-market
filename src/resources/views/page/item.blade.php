@extends('layouts.app')
@section('title','ページ')
@section('content')
  <div class="item-page">

    {{-- 商品メイン情報 --}}
    <div class="item-header">
      <h1 class="item-title">
        {{ $product->name }}
      </h1>

      <p class="item-price">
        価格：{{ number_format($product->price) }} 円
      </p>

      <p class="item-seller">
        出品者：{{ $product->user->name ?? '不明' }}
      </p>

      <p class="item-categories">
        カテゴリ：
        @foreach($product->categories as $category)
          <span class="item-category">
            {{ $category->name }}
          </span>
        @endforeach
      </p>

      <p class="item-stats">
        いいね：{{ $product->likes_count }}

        コメント：{{ $product->comments_count }}
      </p>
    </div>

    {{-- コメント一覧 --}}
    <div class="item-comments">
      <h2 class="item-comments-title">
        コメント
      </h2>

      @forelse($product->comments as $comment)
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
