@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="profile-edit-page">
        <h1 class="profile-edit-title">プロフィール設定</h1>

        <form method="POST" action="{{ route('mypage.update') }}" enctype="multipart/form-data" class="profile-edit-form">
            @csrf

            <div class="profile-edit-image-row">
                <div class="profile-edit-avatar">
                    @if ($user->profile_image)
                        <img
                            src="{{ asset('storage/' . $user->profile_image) }}"
                            alt="プロフィール画像"
                            class="profile-edit-avatar-image"
                            id="profile-preview"
                        >
                    @else
                        <img
                            src=""
                            alt="プロフィール画像"
                            class="profile-edit-avatar-image"
                            id="profile-preview"
                            style="display:none;"
                        >
                        <div class="profile-edit-avatar-placeholder" id="profile-preview-placeholder"></div>
                    @endif
                </div>

                <div class="profile-edit-image-control">
                    <label for="profile_image" class="profile-edit-image-button">画像を選択する</label>
                    <input
                        id="profile_image"
                        type="file"
                        name="profile_image"
                        class="profile-edit-image-input"
                        accept="image/*"
                    >

                    @error('profile_image')
                        <p class="profile-edit-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="profile-edit-field">
                <label for="name" class="profile-edit-label">ユーザー名</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="profile-edit-input"
                >
                @error('name')
                    <p class="profile-edit-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-edit-field">
                <label for="postcode" class="profile-edit-label">郵便番号</label>
                <input
                    id="postcode"
                    type="text"
                    name="postcode"
                    value="{{ old('postcode', $user->postcode) }}"
                    class="profile-edit-input"
                >
                @error('postcode')
                    <p class="profile-edit-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-edit-field">
                <label for="address" class="profile-edit-label">住所</label>
                <input
                    id="address"
                    type="text"
                    name="address"
                    value="{{ old('address', $user->address) }}"
                    class="profile-edit-input"
                >
                @error('address')
                    <p class="profile-edit-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-edit-field">
                <label for="building" class="profile-edit-label">建物名</label>
                <input
                    id="building"
                    type="text"
                    name="building"
                    value="{{ old('building', $user->building) }}"
                    class="profile-edit-input"
                >
                @error('building')
                    <p class="profile-edit-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-edit-actions">
                <button type="submit" class="profile-edit-submit">更新する</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('profile_image');
            const preview = document.getElementById('profile-preview');
            const placeholder = document.getElementById('profile-preview-placeholder');

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', () => {
                const file = input.files && input.files[0] ? input.files[0] : null;
                if (!file) {
                    return;
                }

                if (!file.type || !file.type.startsWith('image/')) {
                    input.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
