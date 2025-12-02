@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
<div class="profile-edit-page">

  <h1>プロフィールを編集</h1>

  {{-- フラッシュメッセージ --}}
  @if (session('status'))
    <div class="profile-edit-flash">
      {{ session('status') }}
    </div>
  @endif

  <form
    method="POST"
    action="{{ route('mypage.update') }}"
    enctype="multipart/form-data"
    class="profile-edit-form"
  >
    @csrf

    {{-- プロフィール画像 --}}
    <div class="form-row">
      <label for="profile_image" class="form-label">プロフィール画像</label>

      @if ($user->profile_image)
        <div class="profile-edit-current-image">
          <img
            src="{{ asset('storage/' . $user->profile_image) }}"
            alt="現在のプロフィール画像"
            width="120"
          >
        </div>
      @endif

      <input
        id="profile_image"
        type="file"
        name="profile_image"
        class="form-input"
      >

      @error('profile_image')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- ユーザー名 --}}
    <div class="form-row">
      <label for="name" class="form-label">ユーザー名</label>
      <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name', $user->name) }}"
        class="form-input"
      >
      @error('name')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- 郵便番号 --}}
    <div class="form-row">
      <label for="postcode" class="form-label">郵便番号</label>
      <input
        id="postcode"
        type="text"
        name="postcode"
        value="{{ old('postcode', $user->postcode) }}"
        class="form-input"
        placeholder="例: 123-4567"
      >
      @error('postcode')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- 住所 --}}
    <div class="form-row">
      <label for="address" class="form-label">住所</label>
      <input
        id="address"
        type="text"
        name="address"
        value="{{ old('address', $user->address) }}"
        class="form-input"
      >
      @error('address')
        <p class="form-error">{{ $message }}</p>
      @enderror
    </div>

    {{-- ボタン --}}
    <div class="form-actions">
      <button type="submit" class="form-submit-button">
        更新する
      </button>

      <a href="{{ route('mypage') }}" class="form-cancel-link">
        マイページに戻る
      </a>
    </div>

  </form>

</div>
@endsection
