@extends('layouts.app')
@section('title', 'マイページ')

@section('content')
<div class="mypage">

  <h1>マイページ</h1>

  {{-- 上部：プロフィールエリア --}}
  <div class="mypage-header">
    {{-- プロフィール画像 --}}
    <div class="mypage-header-image">
      @if ($user->profile_image)
        <img
          src="{{ asset('storage/' . $user->profile_image) }}"
          alt="プロフィール画像"
          width="120"
        >
      @else
        <div class="mypage-header-image-placeholder">
          画像なし
        </div>
      @endif
    </div>

    {{-- ユーザー名 + 編集ボタン --}}
    <div class="mypage-header-main">
      <p class="mypage-header-name">
        {{ $user->name }}
      </p>

      <a href="{{ route('mypage.edit') }}" class="mypage-header-edit-button">
        プロフィールを編集
      </a>
    </div>
  </div>
  {{-- 下部：タブ ＋ 商品リスト --}}
  <div class="mypage-body">

    {{-- タブ（出品した商品 / 購入した商品） --}}
    <nav class="mypage-tabs">
      <a
        href="{{ route('mypage', ['page' => 'sell']) }}"
        class="mypage-tab-link {{ $page === 'sell' ? 'is-active' : '' }}"
      >
        出品した商品
      </a>

      <a
        href="{{ route('mypage', ['page' => 'buy']) }}"
        class="mypage-tab-link {{ $page === 'buy' ? 'is-active' : '' }}"
      >
        購入した商品
      </a>
    </nav>

    <hr>

    {{-- デフォルト：どちらのタブも選択されていない場合は何も表示しない --}}
    @if (is_null($page))
      <div class="mypage-list-empty-state">
        {{-- 何も表示しない / メッセージを出すならここに --}}
        {{-- <p>タブを選択すると商品一覧が表示されます。</p> --}}
      </div>
    @endif

    {{-- 出品した商品タブ --}}
    @if ($page === 'sell')
      <div class="mypage-list mypage-list-sell">
        {{-- 商品画像 + 商品名のみ --}}
        @forelse ($items as $item)
          <div class="mypage-item">
            @if ($item->image)
              <div class="mypage-item-image">
                <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                  <img
                    src="{{ asset('storage/' . $item->image) }}"
                    alt="{{ $item->name }}"
                    width="120"
                  >
                </a>
              </div>
            @endif

            <div class="mypage-item-name">
              <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                {{ $item->name }}
              </a>
            </div>
          </div>
        @empty
          <p>出品した商品はありません</p>
        @endforelse
      </div>
    @endif

    {{-- 購入した商品タブ --}}
    @if ($page === 'buy')
      <div class="mypage-list mypage-list-buy">
        {{-- 商品画像 + 商品名のみ --}}
        @forelse ($boughtItems as $item)
          <div class="mypage-item">
            @if ($item->image)
              <div class="mypage-item-image">
                <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                  <img
                    src="{{ asset('storage/' . $item->image) }}"
                    alt="{{ $item->name }}"
                    width="120"
                  >
                </a>
              </div>
            @endif

            <div class="mypage-item-name">
              <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                {{ $item->name }}
              </a>
            </div>
          </div>
        @empty
          <p>購入した商品はありません</p>
        @endforelse
      </div>
    @endif

  </div>

</div>
@endsection
