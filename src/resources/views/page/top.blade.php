@extends('layouts.app')
@section('title', '商品一覧')

@section('content')
<div class="top-page">

  <h1>商品一覧</h1>

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

  <hr>

  {{-- 商品一覧 --}}
  <div class="top-items">

    @forelse ($items as $item)

      <div class="top-item">

        {{-- ★ 画像（FN029 ＋ ダミー画像対応） --}}
        @php
          $imageUrl = $item->image
            ? asset('storage/' . $item->image)
            : null;
        @endphp

        @if ($imageUrl)
          <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
            <img
              src="{{ $imageUrl }}"
              alt="{{ $item->name }}"
              class="top-item-image"
            >
          </a>
        @endif

        {{-- 商品名 --}}
        <div class="top-item-name">
          <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
            {{ $item->name }}
          </a>
        </div>

        {{-- ★ Sold バッジ（要件 FN014-3 / FN015-3） --}}
        @if (!empty($item->is_sold) && $item->is_sold)
          <span class="top-item-badge">Sold</span>
        @endif

      </div>

    @empty
      <p>商品がありません</p>
    @endforelse

  </div>

</div>
@endsection
