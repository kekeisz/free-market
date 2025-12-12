@extends('layouts.app')
@section('title', '購入確認')

@section('content')
<div class="purchase-page">

    <h1>購入確認</h1>

    @if ($errors->any())
        <div class="purchase-errors">
            @foreach ($errors->all() as $error)
                <p style="color:red;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <div class="purchase-item">
        <p>商品名：{{ $item->name }}</p>
        <p>価格：{{ number_format($item->price) }} 円</p>
    </div>

    <div class="purchase-address">
        <h2>送付先住所</h2>

        <p>
            お名前：{{ $shippingAddress['name'] }}<br>
            郵便番号：{{ $shippingAddress['postcode'] }}<br>
            住所：{{ $shippingAddress['address'] }}
        </p>

        <a href="{{ route('purchase.address', $item->id) }}">
            住所を変更する
        </a>
    </div>

    <form action="{{ route('purchase.exec', $item->id) }}" method="POST">
        @csrf

        <div class="purchase-payment">
            <label for="payment_method">支払い方法</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">選択してください</option>
                <option value="convenience">コンビニ払い</option>
                <option value="card">クレジットカード</option>
            </select>
        </div>

        <button type="submit">購入する</button>
    </form>

</div>
@endsection
