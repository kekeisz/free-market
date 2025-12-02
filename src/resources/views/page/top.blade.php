@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
<div class="top-page">

  <h1>商品一覧</h1>

  <div class="top-body">

    {{-- タブ（おすすめ / マイリスト） --}}
    <nav class="top-tabs">
      {{-- おすすめ（全商品）：クエリに page を付けない --}}
      <a
        href="{{ route('top', $keyword ? ['keyword' => $keyword] : []) }}"
        class="top-tab-link {{ $page !== 'mylist' ? 'is-active' : '' }}"
      >
        おすすめ
      </a>

      {{-- マイリスト（いいねした商品）：?page=mylist --}}
      <a
        href="{{ route('top', array_filter(['page' => 'mylist', 'keyword' => $keyword])) }}"
        class="top-tab-link {{ $page === 'mylist' ? 'is-active' : '' }}"
      >
        マイリスト
      </a>
    </nav>

    <hr>

    {{-- 見出し（文言だけ切り替え） --}}
    <h2 class="top-section-title">
      @if ($page === 'mylist')
        マイリスト
      @else
        おすすめ
      @endif
    </h2>

    {{-- 商品一覧（中身は $items をそのまま使う） --}}
    <div class="top-list">
      @forelse ($items as $item)
        <div class="top-item">
          {{-- 商品画像 --}}
          @if ($item->image)
            <div class="top-item-image">
              <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                <img
                  src="{{ asset('storage/' . $item->image) }}"
                  alt="{{ $item->name }}"
                  width="160"
                >
              </a>
            </div>
          @endif

          {{-- 商品名 --}}
          <div class="top-item-name">
            <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
              {{ $item->name }}
            </a>
          </div>
        </div>
      @empty
        <p>
          @if ($page === 'mylist')
            マイリストに登録された商品はありません
          @else
            商品がありません
          @endif
        </p>
      @endforelse
    </div>

  </div>

</div>
@endsection
