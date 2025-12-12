@extends('layouts.app')
@section('title', '送付先住所の変更')

@section('content')
<div class="address-page">

    <h1>送付先住所の変更</h1>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div class="address-errors">
            @foreach ($errors->all() as $error)
                <p style="color:red;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <p style="color:green;">
            {{ session('success') }}
        </p>
    @endif

    <form action="{{ route('purchase.address.update', $item->id) }}" method="POST">
        @csrf

        <div class="address-field">
            <label for="name">お名前</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name', $shippingAddress['name']) }}"
            >
        </div>

        <div class="address-field">
            <label for="postcode">郵便番号（例：123-4567）</label>
            <input
                id="postcode"
                type="text"
                name="postcode"
                value="{{ old('postcode', $shippingAddress['postcode']) }}"
            >
        </div>

        <div class="address-field">
            <label for="address">住所</label>
            <input
                id="address"
                type="text"
                name="address"
                value="{{ old('address', $shippingAddress['address']) }}"
            >
        </div>

        <div class="address-field">
            <label for="building">建物名（任意）</label>
            <input
                id="building"
                type="text"
                name="building"
                value="{{ old('building') }}"
            >
        </div>

        <div class="address-actions">
            <button type="submit">
                この住所を保存して購入確認に戻る
            </button>
        </div>
    </form>

    <div class="address-back-link">
        <a href="{{ route('purchase.confirm', $item->id) }}">
            変更せずに購入確認に戻る
        </a>
    </div>

</div>
@endsection
