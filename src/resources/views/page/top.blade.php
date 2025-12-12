@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@endsection

@section('content')
<div class="top-page">
  {{-- タブ（おすすめ / マイリスト） --}}
  <nav class="top-tabs">
    <a
      href="{{ route('top') }}"
      class="top-tab-link {{ $page === null ? 'is-active' : '' }}"
    >
      おすすめ
    </a>

    <a
      href="{{ route('top', ['page' => 'mylist']) }}"
      class="top-tab-link {{ $page === 'mylist' ? 'is-active' : '' }}"
    >
      マイリスト
    </a>
  </nav>

  <hr class="top-divider">

  {{-- 商品グリッド --}}
  <div class="top-item-grid">
    @forelse ($items as $item)
      <div class="top-item-card">

        <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="top-item-link">

          {{-- 画像：290pxの正方形 --}}
          @if ($item->image)
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

          {{-- 商品名 + Soldバッジ --}}
          <div class="top-item-info">
            <div class="top-item-name">
              {{ $item->name }}
            </div>

            @if (!empty($item->is_sold) && $item->is_sold)
              <span class="top-item-badge">Sold</span>
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
