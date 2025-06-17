@extends('layouts.app')

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripeKey = "{{ env('STRIPE_KEY') }}";
</script>
<script src={{ asset('/js/stripe.js') }}></script>
@endpush

@section('content')
<div class="container">
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mypage') }}">有料会員登録フォーム</a></li>
                <li class="breadcrumb-item active" aria-current="page">カード情報の登録</li>
            </ol>
        </nav>
    </div>
    <h1 class="mb-3">カード情報の登録</h1>
    @if (session('subscription_message'))
        <div class="alert alert-info" role="alert">
            <p class="mb-0">{{ session('subscription_message') }}</p>
        </div>
    @endif
    <hr class="mb-4">

    <div class="alert alert-danger" id="card-error" role="alert">
        <ul class="mb-0" id="error-list"></ul>
    </div>

    <form action="{{ route('subscription.store') }}" id="card-form" method="POST">
        @csrf
        <input type="text" class="mb-3 form-control" id="card-holder-name" placeholder="カード名義人" required>
        <div class="mb-4" id="card-element"></div>
    </form>
    <button class="btn submit_btn text-white w-50" id="card-button" data-secret="{{ $intent->client_secret }}">登録</button>
</div>
@endsection