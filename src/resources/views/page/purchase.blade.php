@extends('layouts.app')
@section('title', '購入確認')

@section('content')
  <div class="purchase-page">

    <h1>購入確認</h1>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
      <div class="purchase-errors">
        @foreach ($errors->all() as $error)
          <p style="color:red;">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <div class="purchase-item">
      <p>商品名：{{ $item->name }}</p>
      <p>価格：{{ number_format($item->price) }} 円</p>
    </div>

    <div class="purchase-address">
      <h2>送付先住所</h2>
      <p>{{ $user->address ?? '住所未登録' }}</p>

      {{-- 住所変更 --}}
      <a href="{{ route('purchase.address', $item->id) }}">
        住所を変更する
      </a>
    </div>

    <form action="{{ route('purchase.exec', $item->id) }}" method="POST">
      @csrf

      {{-- 支払い方法 --}}
      <div class="purchase-payment">
        <label for="payment_method">支払い方法</label>
        <select id="payment_method" name="payment_method" required>
          <option value="">選択してください</option>
          <option value="convenience" @selected(old('payment_method') === 'convenience')>
            コンビニ払い
          </option>
          <option value="card" @selected(old('payment_method') === 'card')>
            クレジットカード
          </option>
        </select>
      </div>

      <button type="submit">購入する</button>
    </form>

  </div>
@endsection