@extends('layouts.app')

@section('title', '送付先住所の変更')

@section('css')
    <link
        rel="stylesheet"
        href="{{ asset('css/address.css') }}"
    >
@endsection

@section('content')
    <div class="address-edit-page">
        <h1 class="address-edit-title">
            住所の変更
        </h1>

        @if (session('success'))
            <p class="address-edit-success">
                {{ session('success') }}
            </p>
        @endif

        <form
            method="POST"
            action="{{ route('purchase.address.update', $item->id) }}"
            class="address-edit-form"
        >
            @csrf

            <div class="address-edit-field">
                <label
                    for="postcode"
                    class="address-edit-label"
                >
                    郵便番号
                </label>

                <input
                    id="postcode"
                    type="text"
                    name="postcode"
                    value="{{ old('postcode', $shippingAddress['postcode'] ?? '') }}"
                    class="address-edit-input"
                    placeholder="例：123-4567"
                >

                @error('postcode')
                    <p class="address-edit-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="address-edit-field">
                <label
                    for="address"
                    class="address-edit-label"
                >
                    住所
                </label>

                <input
                    id="address"
                    type="text"
                    name="address"
                    value="{{ old('address', $shippingAddress['address'] ?? '') }}"
                    class="address-edit-input"
                >

                @error('address')
                    <p class="address-edit-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="address-edit-field">
                <label
                    for="building"
                    class="address-edit-label"
                >
                    建物名
                </label>

                <input
                    id="building"
                    type="text"
                    name="building"
                    value="{{ old('building', $shippingAddress['building'] ?? '') }}"
                    class="address-edit-input"
                >

                @error('building')
                    <p class="address-edit-error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="address-edit-actions">
                <button
                    type="submit"
                    class="address-edit-submit"
                >
                    更新する
                </button>
            </div>
        </form>
    </div>
@endsection
