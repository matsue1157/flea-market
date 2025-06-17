@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user/edit.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">

        {{-- プロフィール画像エリア --}}
        @if ($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}"
                class="profile-image"
                alt="プロフィール画像">
        @else
            <div class="profile-image-placeholder"></div>
        @endif

        {{-- 見出し --}}
        <h2 class="profile-edit-title">プロフィール設定</h2>

        {{-- プロフィールフォーム --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-edit-form">
            @csrf

            {{-- 「画像を選択する」ボタン --}}
            <div class="image-select-wrapper">
                <label class="image-select-button">
                    <input type="file" name="profile_image" class="hidden-file-input">
                </label>
                @error('profile_image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- ユーザー名 --}}
            <div class="form-group">
                <label class="form-label">ユーザー名</label>
                <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}"
                    class="form-input @error('nickname') input-error @enderror">
                @error('nickname')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- 郵便番号 --}}
            <div class="form-group">
                <label class="form-label">郵便番号</label>
                <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}"
                    class="form-input @error('postcode') input-error @enderror">
                @error('postcode')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- 住所 --}}
            <div class="form-group">
                <label class="form-label">住所</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                    class="form-input @error('address') input-error @enderror">
                @error('address')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div class="form-group">
                <label class="form-label">建物名</label>
                <input type="text" name="building" value="{{ old('building', $user->building) }}"
                    class="form-input @error('building') input-error @enderror">
                @error('building')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- 更新ボタン --}}
            <div class="submit-button-wrapper">
                <button type="submit" class="submit-button">
                    更新する
                </button>
            </div>
        </form>
    </div>

@endsection