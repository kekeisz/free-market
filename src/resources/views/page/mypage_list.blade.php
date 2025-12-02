@extends('layouts.app')

@section('title', '購入 / 出品一覧')

@section('content')
<div class="mypage-list">

  <h1 class="mypage-list-title">
    @if ($tab === 'sell')
      出品した商品一覧
    @else
      購入した商品一覧
    @endif
  </h1>

  {{-- タブナビゲーション --}}
  <nav class="mypage-list-tabs">
    <a
      href="{{ route('mypage.list', ['page' => 'buy']) }}"
      class="mypage-list-tab-link {{ $tab === 'buy' ? 'is-active' : '' }}"
    >
      購入した商品
    </a>
    <a
      href="{{ route('mypage.list', ['page' => 'sell']) }}"
      class="mypage-list-tab-link {{ $tab === 'sell' ? 'is-active' : '' }}"
    >
      出品した商品
    </a>
  </nav>

  {{-- 一覧本体 --}}
  @if ($items->isEmpty())
    <p class="mypage-list-empty">
      @if ($tab === 'sell')
        出品した商品はありません。
      @else
        購入した商品はありません。
      @endif
    </p>
  @else
    <ul class="mypage-list-items">
      @foreach ($items as $item)
        <li class="mypage-list-item">
          <a
            href="{{ route('item.show', ['item_id' => $item->id]) }}"
            class="mypage-list-item-link"
          >
            <div class="mypage-list-item-main">
              <span class="mypage-list-item-name">
                {{ $item->name }}
              </span>

              <span class="mypage-list-item-price">
                ¥{{ number_format($item->price) }}
              </span>
            </div>

            {{-- Soldバッジ（売り切れ表示） --}}
            @if (!empty($item->is_sold) && $item->is_sold)
              <span class="mypage-list-item-badge">
                Sold
              </span>
            @endif
          </a>
        </li>
      @endforeach
    </ul>
  @endif

</div>
@endsection
