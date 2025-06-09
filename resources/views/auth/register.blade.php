@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="mb-3">新規会員登録</h1>

            <hr class="mb-4">

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-5 col-form-label text-md-left fw-medium">氏名<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="名古屋飯 太郎">
                        @error ('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>氏名を入力してください</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="furigana" class="col-md-5 col-form-label text-md-left fw-medium">フリガナ<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="furigana" type="text" class="form-control @error('furigana') is-invalid @enderror" name="furigana" value="{{ old('furigana') }}" required autocomplete="furigana" placeholder="ナゴヤメシ タロウ">
                        @error ('furigana')
                            <span class="invalid-feedback" role="alert">
                                <strong>フリガナを入力してください</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-5 col-form-label text-md-left fw-medium">メールアドレス<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nagoyameshi@example.com">
                        @error ('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>メールアドレスを入力してください</strong>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-md-5 col-form-label text-md-left fw-medium">パスワード<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error ('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-5 col-form-label text-md-left fw-medium">パスワード（確認用）<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <hr class="mb-4">

                <button type="submit" class="btn submit_btn w-100 text-white">会員登録</button>
            </form>
        </div>
    </div>
</div>
@endsection
