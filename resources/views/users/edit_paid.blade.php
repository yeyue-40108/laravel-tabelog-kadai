@extends('layouts.app')

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('stripe-public-key');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');
</script>
<script src={{ asset('/js/stripe/js') }}></script>
@endpush

@section('content')
<div class="container pt-2">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">有料会員登録</li>
                </ol>
            </nav>

            <h1 class="mb-3">有料会員登録</h1>
            <hr>
            <form method="POST" action="{{ route('users.update_paid_users') }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="phone" class="col-md-5 col-form-label text-md-left fw-medium">電話番号<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <div class="col-md-7">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required autocomplete="phone" autofocus placeholder="0123-45-6789">
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
                        <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" required autocomplete="birthday">
                        @error ('birthday')
                            <span class="invalid-feedback" role="alert">
                                <strong>生年月日を入力してください</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="work" class="col-md-5 col-form-label text-md-left fw-medium">職業<span class="ms-1 require_label"><span class="require_label_text">必須</span></span></label>
                    <select name="work" class="form-select" id="work" aria-label="Default select example">
                        <option value="company">会社員</option>
                        <option value="government">公務員</option>
                        <option value="student">学生</option>
                        <option value="house">主夫・主婦</option>
                        <option value="other">その他</option>
                    </select>
                </div>
                <hr>

                <div>
                    <!-- カード登録 -->
                    <label for="card-holder-name">カード番号</label>
                    <input id="card-holder-name" type="text">

                    <!-- ストライプ要素のプレースホルダ -->
                    <div id="card-element"></div>
                </div>

                <input type="hidden" name="role" id="role" value="paid">

                <hr class="mb-4">
                <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn submit_btn w-100 text-white">有料会員登録</button>
            </form>
        </div>
    </div>
</div>
@endsection