@extends('layouts.app')

@section('title', '購入確認')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-page">

        @if ($errors->any())
            <div class="purchase-errors">
                @foreach ($errors->all() as $error)
                    <p class="purchase-error-text">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <p class="purchase-success">{{ session('success') }}</p>
        @endif

        @php
            $paymentMethod = old('payment_method', $paymentMethod ?? '');
            $paymentMethodLabel = match ($paymentMethod) {
                'convenience' => 'コンビニ払い',
                'card' => 'クレジットカード',
                default => '選択してください',
            };
        @endphp

        <div class="purchase-layout">
            <div class="purchase-left">
                <div class="purchase-item">
                    <div class="purchase-item-image">
                        @if (!empty($item->image))
                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->name }}"
                                class="purchase-item-image-img"
                            >
                        @else
                            <div class="purchase-item-image-placeholder"></div>
                        @endif
                    </div>

                    <div class="purchase-item-info">
                        <p class="purchase-item-name">{{ $item->name }}</p>
                        <p class="purchase-item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>

                <form
                    id="purchase-form"
                    action="{{ route('purchase.exec', $item->id) }}"
                    method="POST"
                    class="purchase-form"
                >
                    @csrf

                    <div class="purchase-section purchase-section-payment">
                        <div class="purchase-section-header">
                            <p class="purchase-section-title">支払い方法</p>
                        </div>

                        <div class="purchase-payment">
                            <div class="purchase-select-wrapper">
                                <select name="payment_method" class="purchase-select" required>
                                    <option value="convenience">コンビニ払い</option>
                                    <option value="card">クレジットカード</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="purchase-section purchase-section-address">
                        <div class="purchase-section-header purchase-section-header-between">
                            <p class="purchase-section-title">配送先</p>

                            <a href="{{ route('purchase.address', $item->id) }}" class="purchase-change-link">
                                変更する
                            </a>
                        </div>

                        <div class="purchase-address">
                            <p class="purchase-address-text">
                                〒{{ $shippingAddress['postcode'] }}
                            </p>
                            <p class="purchase-address-text">
                                {{ $shippingAddress['address'] }}
                            </p>
                            @if (!empty($shippingAddress['building']))
                                <p class="purchase-address-text">
                                    {{ $shippingAddress['building'] }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="purchase-right-sp">
                        <button type="submit" class="purchase-submit">
                            購入する
                        </button>
                    </div>
                </form>
            </div>

            <div class="purchase-right">
                <div class="purchase-summary">
                    <div class="purchase-summary-row purchase-summary-row-price">
                        <p class="purchase-summary-label">商品代金</p>
                        <p class="purchase-summary-value">¥{{ number_format($item->price) }}</p>
                    </div>

                    <div class="purchase-summary-row purchase-summary-row-payment">
                        <p class="purchase-summary-label">支払い方法</p>
                        <p class="purchase-summary-value" id="purchase-payment-method-text">{{ $paymentMethodLabel }}</p>
                    </div>
                </div>

                <button type="submit" form="purchase-form" class="purchase-submit purchase-submit-desktop">
                    購入する
                </button>
            </div>
        </div>
    </div>
    <script>
        (() => {
            const labelMap = {
                convenience: 'コンビニ払い',
                card: 'クレジットカード',
            };

            const syncPaymentText = () => {
                const select = document.querySelector('select[name="payment_method"]');
                const text = document.getElementById('purchase-payment-method-text');

                if (!select || !text) {
                    return;
                }

                const value = select.value || '';
                text.textContent = labelMap[value] ?? '選択してください';
            };

            document.addEventListener('DOMContentLoaded', () => {
                const select = document.querySelector('select[name="payment_method"]');
                if (select) {
                    select.addEventListener('change', syncPaymentText);
                    select.addEventListener('input', syncPaymentText);
                }
                syncPaymentText();
            });

            window.addEventListener('pageshow', () => {
                syncPaymentText();
            });
        })();
    </script>
@endsection
