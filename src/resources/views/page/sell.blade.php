@extends('layouts.app')

@section('title', '商品を出品')

@section('content')
<div class="sell-page">

  <h1>商品を出品</h1>

  {{-- フラッシュメッセージ --}}
  @if (session('status'))
    <div class="sell-flash">
      {{ session('status') }}
    </div>
  @endif

  <form
    method="POST"
    action="{{ route('sell.store') }}"
    enctype="multipart/form-data"
    class="sell-form"
  >
    @csrf

    {{-- 商品名 --}}
    <div class="form-row">
      <label for="name" class="form-label">商品名</label>
      <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name') }}"
        class="form-input"
      >
      @error('name')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- 商品説明 --}}
    <div class="form-row">
      <label for="description" class="form-label">商品説明</label>
      <textarea
        id="description"
        name="description"
        class="form-textarea"
      >{{ old('description') }}</textarea>
      @error('description')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- 価格 --}}
    <div class="form-row">
      <label for="price" class="form-label">価格（円）</label>
      <input
        id="price"
        type="number"
        name="price"
        value="{{ old('price') }}"
        class="form-input"
      >
      @error('price')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- 商品の状態（プルダウン） --}}
    <div class="form-row">
      <label for="condition_id" class="form-label">商品の状態</label>

      <select
        id="condition_id"
        name="condition_id"
        class="form-select"
      >
        <option value="">選択してください</option>

        @foreach ($conditions as $condition)
          <option
            value="{{ $condition->id }}"
            @if (old('condition_id') == $condition->id) selected @endif
          >
            {{ $condition->name }}
          </option>
        @endforeach
      </select>

      @error('condition_id')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- カテゴリ（複数選択） --}}
    <div class="form-row">
      <label class="form-label">カテゴリ</label>

      <div class="form-checkbox-group">
        @foreach ($categories as $category)
          <label class="form-checkbox-item">
            <input
              type="checkbox"
              name="categories[]"
              value="{{ $category->id }}"
              @if (is_array(old('categories')) && in_array($category->id, old('categories'))) checked @endif
            >
            {{ $category->name }}
          </label>
        @endforeach
      </div>

      @error('categories')
        <p class="form-error">{{ $message }}</p>
      @enderror
      @error('categories.*')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- 商品画像 --}}
    <div class="form-row">
      <label for="image" class="form-label">商品画像</label>
      <input
        id="image"
        type="file"
        name="image"
        class="form-input"
      >
      @error('image')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- 出品ボタン --}}
    <div class="form-actions">
      <button type="submit" class="form-submit-button">
        出品する
      </button>
    </div>

  </form>

</div>
@endsection
