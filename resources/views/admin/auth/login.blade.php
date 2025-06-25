@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="mb-3">管理者ログイン</h1>

            @if (session('warning'))
                <div class="alert alert-danger">
                    {{ session('warning') }}
                </div>
            @endif

            <hr class="mb-4">

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">
                    @error ('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスが正しくない可能性があります。</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="パスワード">
                    @error ('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>パスワードが正しくない可能性があります。</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input id="remember" type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label checkbox w-100" for="remember">
                            次回から自動的にログインする
                        </label>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="submit_button w-100 text-white mb-4">ログイン</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection