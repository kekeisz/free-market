@extends('layouts.app')

@section('title', '商品の出品')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell-page">
        <h1 class="sell-title">商品の出品</h1>

        @if ($errors->any())
            <div class="sell-errors">
                @foreach ($errors->all() as $error)
                    <p class="sell-error-text">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('sell.store') }}" enctype="multipart/form-data" class="sell-form">
            @csrf

            <div class="sell-block">
                <p class="sell-block-title">商品画像</p>

                <div class="sell-image-box">
                    <img
                        id="sell-image-preview"
                        class="sell-image-preview"
                        src=""
                        alt="商品画像プレビュー"
                        style="display:none;"
                    >

                    <div id="sell-image-placeholder" class="sell-image-placeholder">
                        <label for="image" class="sell-image-button">画像を選択する</label>
                    </div>

                    <input
                        id="image"
                        type="file"
                        name="image"
                        class="sell-image-input"
                        accept="image/*"
                    >
                </div>

                @error('image')
                    <p class="sell-field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell-section">
                <p class="sell-section-title">商品の詳細</p>
                <hr class="sell-divider">

                <div class="sell-field">
                    <p class="sell-label">カテゴリー</p>

                    <div class="sell-category-list">
                        @php
                            $selectedCategoryIds = old('categories', []);
                            $selectedCategoryIdsStr = array_map('strval', $selectedCategoryIds);
                        @endphp

                        @foreach ($categories as $category)
                            @php
                                $isChecked = in_array((string) $category->id, $selectedCategoryIdsStr, true);
                            @endphp

                            <input
                                id="category-{{ $category->id }}"
                                type="checkbox"
                                name="categories[]"
                                value="{{ $category->id }}"
                                class="sell-category-input"
                                {{ $isChecked ? 'checked' : '' }}
                            >
                            <label for="category-{{ $category->id }}" class="sell-category-pill">
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>

                    @error('categories')
                        <p class="sell-field-error">{{ $message }}</p>
                    @enderror
                    @error('categories.*')
                        <p class="sell-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sell-field">
                    <label for="condition_id" class="sell-label">商品の状態</label>

                    <div class="sell-select-wrapper">
                        <select id="condition_id" name="condition_id" class="sell-select" required>
                            <option value="">選択してください</option>
                            @foreach ($conditions as $condition)
                                <option
                                    value="{{ $condition->id }}"
                                    {{ (string) old('condition_id') === (string) $condition->id ? 'selected' : '' }}
                                >
                                    {{ $condition->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @error('condition_id')
                        <p class="sell-field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sell-section">
                <p class="sell-section-title">商品名と説明</p>
                <hr class="sell-divider">

                <div class="sell-field">
                    <label for="name" class="sell-label">商品名</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="sell-input"
                    >
                    @error('name')
                        <p class="sell-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sell-field">
                    <label for="brand" class="sell-label">ブランド名</label>
                    <input
                        id="brand"
                        type="text"
                        name="brand"
                        value="{{ old('brand') }}"
                        class="sell-input"
                    >
                    @error('brand')
                        <p class="sell-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sell-field">
                    <label for="description" class="sell-label">商品の説明</label>
                    <textarea
                        id="description"
                        name="description"
                        class="sell-textarea"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="sell-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sell-field">
                    <label
                        for="price"
                        class="sell-label"
                    >
                        販売価格
                    </label>

                    <div class="sell-price-wrapper">
                        <span class="sell-price-yen">
                            ¥
                        </span>

                        <input
                            id="price"
                            type="text"
                            name="price"
                            value="{{ old('price') }}"
                            class="sell-input sell-input-price"
                            inputmode="numeric"
                        >
                    </div>

                    @error('price')
                        <p class="sell-field-error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="sell-actions">
                <button type="submit" class="sell-submit">出品する</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('image');
            const preview = document.getElementById('sell-image-preview');
            const placeholder = document.getElementById('sell-image-placeholder');

            if (!input || !preview || !placeholder) {
                return;
            }

            const resetPreview = () => {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'flex';
            };

            input.addEventListener('change', () => {
                const file = input.files && input.files[0] ? input.files[0] : null;

                if (!file) {
                    resetPreview();
                    return;
                }

                if (!file.type || !file.type.startsWith('image/')) {
                    input.value = '';
                    resetPreview();
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
