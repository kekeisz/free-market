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

    <div class="product-list">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ url('/item/' . $product->id) }}" class="product-link">

                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">{{ number_format($product->price) }} 円</div>

                    <div class="product-meta">
                        <span class="likes-count">いいね：{{ $product->likes_count ?? 0 }}</span>
                        <span class="comments-count">/ コメント：{{ $product->comments_count ?? 0 }}</span>
                    </div>

                    @if($product->is_sold)
                        <div class="product-sold-badge">Sold</div>
                    @endif

                </a>
            </div>
        @empty
            <p class="product-empty">商品がありません。</p>
        @endforelse
    </div>

</div>
@endsection