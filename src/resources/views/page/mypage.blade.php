@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage">
        @if (session('status'))
            <div class="profile-edit-flash">
                {{ session('status') }}
            </div>
        @endif
        <div class="mypage-header">
            <div class="mypage-header-left">
                <div class="mypage-header-image">
                    @if ($user->profile_image)
                        <img
                            src="{{ asset('storage/' . $user->profile_image) }}"
                            alt="プロフィール画像"
                            class="mypage-header-image-img"
                        >
                    @else
                        <div class="mypage-header-image-placeholder">
                            No Image
                        </div>
                    @endif
                </div>

                <p class="mypage-header-name">
                    {{ $user->name }}
                </p>
            </div>

            <div class="mypage-header-right">
                <a href="{{ route('mypage.edit') }}" class="mypage-header-edit-button">
                    プロフィールを編集
                </a>
            </div>
        </div>


        <div class="mypage-body">
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

            <hr class="mypage-divider">

            @if (is_null($page))
                <div class="mypage-list-empty-state"></div>
            @endif

            @if ($page === 'sell')
                <div class="mypage-list mypage-list-sell">
                    @forelse ($items as $item)
                        <div class="mypage-item">
                            @if ($item->image)
                                <div class="mypage-item-image">
                                    <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                                        <img
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->name }}"
                                            class="mypage-item-image-img"
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
                        <p class="mypage-list-empty-message">
                            出品した商品はありません
                        </p>
                    @endforelse
                </div>
            @endif

            @if ($page === 'buy')
                <div class="mypage-list mypage-list-buy">
                    @forelse ($boughtItems as $item)
                        <div class="mypage-item">
                            @if ($item->image)
                                <div class="mypage-item-image">
                                    <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                                        <img
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->name }}"
                                            class="mypage-item-image-img"
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
                        <p class="mypage-list-empty-message">
                            購入した商品はありません
                        </p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
@endsection
