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

                <hr class="mb-4">
                <button type="submit" class="btn submit_btn w-100 text-white">保存</button>
            </form>
        </div>
    </div>
</div>
@endsection