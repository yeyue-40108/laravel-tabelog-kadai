@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">管理者情報の編集</li>
                </ol>
            </nav>

            <h1 class="mb-3">管理者情報の編集</h1>
            <p>管理画面にログインする際のメールアドレスを変更します。</p>
            <hr>
            <form method="POST" action="{{ route('admin.masters.update_email') }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="email" class="col-md-5 col-form-label text-md-left fw-medium">メールアドレス<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <input id="email" type="text" class="form-control @error('email) is-invalid @enderror" name="email" value="{{ $master->email }}" required autocomplete="email" autofocus placeholder="nagoyameshi@example.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスを入力してください</strong>
                        </span>
                    @enderror
                </div>

                <hr class="mb-4">
                <button type="submit" class="btn submit_btn w-100 text-white">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection