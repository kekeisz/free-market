@extends('layouts.app')
@section('title','ページ')
@section('content')
<div class="top-page">

    <h1 class="top-title">
        商品一覧
        @if($page === 'mylist')
            （マイリスト）
        @endif
    </h1>

    <div class="item-list">
        @forelse($items as $item)
            <div class="item-card">
                <a href="{{ url('/item/' . $item->id) }}" class="item-link">

                    <div class="item-name">{{ $item->name }}</div>
                    <div class="item-price">{{ number_format($item->price) }} 円</div>

                    <div class="item-meta">
                        <span class="likes-count">いいね：{{ $item->likes_count ?? 0 }}</span>
                        <span class="comments-count">/ コメント：{{ $item->comments_count ?? 0 }}</span>
                    </div>

                    @if($item->is_sold)
                        <div class="item-sold-badge">Sold</div>
                    @endif

                </a>
            </div>
        @empty
            <p class="item-empty">商品がありません。</p>
        @endforelse
    </div>

</div>
@endsection