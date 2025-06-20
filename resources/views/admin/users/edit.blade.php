@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <a href="{{ route('admin.users.show', $user->id) }}">< 会員情報詳細ページに戻る</a>
    </div>
    <h1 class="mt-3">会員情報編集</h1>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">氏名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
        </div>
        <div class="mb-3">
            <label for="furigana" class="form-label">フリガナ</label>
            <input type="text" name="furigana" id="furigana" class="form-control" value="{{ $user->furigana }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">会員種別</label>
            @php
                $selected = function ($value) use ($user) {
                    return old('role', $user->role) === $value ? 'selected' : '';
                };
            @endphp
            <select name="role" class="form-select" id="role" aria-label="Default select example">
                <option value="free" {{ $selected('free') }}>無料会員</option>
                <option value="paid" {{ $selected('paid') }}>有料会員</option>
                <option value="shop_manager" {{ $selected('shop_manager') }}>店舗管理者</option>
                <option value="manager" {{ $selected('manager') }}>トップ管理者</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">電話番号</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
        </div>
        <div class="mb-3">
            <label for="birthday" class="form-label">誕生日</label>
            <input type="date" name="birthday" id="birthday" class="form-control" value="{{ $user->birthday }}">
        </div>
        <div class="mb-3">
            <label for="work" class="form-label">職業</label>
            @php
                $selected = function ($value) use ($user) {
                    return old('work', $user->work) === $value ? 'selected' : '';
                };
            @endphp
            <select name="work" class="form-select" id="work" aria-label="Default select example">
                <option value="company" {{ $selected('company') }}>会社員</option>
                <option value="government" {{ $selected('government') }}>公務員</option>
                <option value="student" {{ $selected('student') }}>学生</option>
                <option value="house" {{ $selected('house') }}>主婦・主夫</option>
                <option value="other" {{ $selected('other') }}>その他</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">編集</button>
    </form>
</div>
@endsection