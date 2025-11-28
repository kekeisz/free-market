@extends('layouts.app')

@section('title', 'この商品は購入できません')

@section('content')
    <div class="purchase-sold">
        <div class="purchase-sold-card">
            {{-- 商品画像（あれば） --}}
            @if (!empty($item->image))
                <div class="purchase-sold-image">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                </div>
            @endif
            {{-- 商品名 --}}
            <h1 class="purchase-sold-title">
                {{ $item->name }}
            </h1>
            {{-- メッセージ --}}
            <p class="purchase-sold-message">
                この商品は既に購入されています。
            </p>
            {{-- ボタン群 --}}
            <div class="purchase-sold-actions">
                <a href="{{ route('top') }}" class="btn-link">
                    商品一覧へ
                </a>
                <a href="{{ route('top', ['page' => 'mylist']) }}" class="btn-link">
                    マイリストへ
                </a>
            </div>
        </div>
    </div>
@endsection