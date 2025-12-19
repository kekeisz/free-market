@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@endsection

@section('content')
    <div class="top-page">
        <nav class="top-tabs">
            <a
                href="{{ route('top', array_filter(['keyword' => $keyword])) }}"
                class="top-tab-link {{ $page === null ? 'is-active' : '' }}"
            >
                おすすめ
            </a>

            <a
                href="{{ route('top', array_filter(['page' => 'mylist', 'keyword' => $keyword])) }}"
                class="top-tab-link {{ $page === 'mylist' ? 'is-active' : '' }}"
            >
                マイリスト
            </a>
        </nav>

        <hr class="top-divider">

        <div class="top-item-grid">
            @forelse ($items as $item)
                <div class="top-item-card">
                    <a
                        href="{{ route('item.show', ['item_id' => $item->id]) }}"
                        class="top-item-link"
                    >
                        @if (!empty($item->image))
                            <div class="top-item-image-wrapper">
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->name }}"
                                    class="top-item-image"
                                >
                            </div>
                        @else
                            <div class="top-item-image-wrapper top-item-image-placeholder">
                                <span class="top-item-image-placeholder-text">No Image</span>
                            </div>
                        @endif

                        <div class="top-item-info">
                            <div class="top-item-name">
                                {{ $item->name }}
                            </div>

                            @if (!empty($item->is_sold))
                                <span class="top-item-badge">SOLD</span>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <p class="top-empty">商品がありません</p>
            @endforelse
        </div>
    </div>
@endsection
