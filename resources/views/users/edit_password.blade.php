@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">パスワード変更</li>
                </ol>
            </nav>

            <h1 class="mb-3">パスワード変更</h1>
            <hr class="mb-4">
            <form method="POST" action="{{ route('mypage.update_password') }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="password" class="col-md-5 col-form-label text-md-left fw-medium">新しいパスワード</label>
                    <div class="col-md-7">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="password-confirm" class="col-md-5 col-form-label text-md-left fw-medium">新しいパスワード（確認用）</label>
                    <div class="col-md-7">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <hr class="mb-4">
                <button type="submit" class="btn submit_btn w-100 text-white">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection