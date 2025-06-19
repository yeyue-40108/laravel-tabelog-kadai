@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">会員情報の編集</li>
                </ol>
            </nav>

            <h1 class="mb-3">会員情報の編集</h1>
            <hr>
            <form method="POST" action="{{ route('mypage') }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="name" class="col-md-5 col-form-label text-md-left fw-medium">氏名<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="名古屋飯 太郎">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>氏名を入力してください</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="furigana" class="col-md-5 col-form-label text-md-left fw-medium">フリガナ<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="furigana" type="text" class="form-control @error('furigana') is-invalid @enderror" name="furigana" value="{{ $user->furigana }}" required autocomplete="furigana" placeholder="ナゴヤメシ タロウ">
                        @error ('furigana')
                            <span class="invalid-feedback" role="alert">
                                <strong>フリガナを入力してください</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-5 col-form-label text-md-left fw-medium">メールアドレス<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <input id="email" type="text" class="form-control @error('email) is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" placeholder="nagoyameshi@example.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスを入力してください</strong>
                        </span>
                    @enderror
                </div>
                @if (auth()->user()->role === 'paid')
                    <div class="row mb-3">
                        <label for="phone" class="col-md-5 col-form-label text-md-left fw-medium">電話番号<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                        <div class="col-md-7">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="phone" autofocus placeholder="0123-45-6789">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>電話番号を入力してください</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="birthday" class="col-md-5 col-form-label text-md-left fw-medium">生年月日<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                        <div class="col-md-7">
                            <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ $user->birthday }}" required autocomplete="birthday">
                            @error ('birthday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>生年月日を入力してください</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="work" class="col-md-5 col-form-label text-md-left fw-medium">職業<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                        @php
                            $selected = function ($value) use ($user) {
                                return old('work', $user->work) === $value ? 'selected' : '';
                            };
                        @endphp
                        <select name="work" class="form-select" id="work" aria-label="Default select example">
                            <option value="company" {{ $selected('company') }}>会社員</option>
                            <option value="government" {{ $selected('government') }}>公務員</option>
                            <option value="student" {{ $selected('student') }}>学生</option>
                            <option value="house" {{ $selected('house') }}>主夫・主婦</option>
                            <option value="other" {{ $selected('other') }}>その他</option>
                        </select>
                    </div>
                @endif

                <hr class="mb-4">
                <button type="submit" class="btn submit_btn w-100 text-white">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection