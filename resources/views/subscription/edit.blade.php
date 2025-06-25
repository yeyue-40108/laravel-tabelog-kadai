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
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">お支払い方法の変更</li>
                    </ol>
                </nav>
            </div>
            <h1 class="mb-3">お支払方法（カード情報）の変更</h1>
            <hr class="mb-4">

            <div class="mb-4">
                <div class="row">
                    <p class="fs-5">【現在のお支払情報】</p>
                    <div>
                        <label class="col-3 text-left fw-medium">カード種別</label>
                        <span class="col-2">{{ $user->pm_type }}</span>
                    </div>
                    <div>
                        <label class="col-3 text-left fw-medium">カード名義人</label>
                        <span>{{ $user->DefaultPaymentMethod()->billing_details->name }}</span>
                    </div>
                    <div>
                        <label class="col-3 text-left fw-medium">カード番号</label>
                        <span>**** **** **** {{ $user->pm_last_four }}</span>
                    </div>
                </div>
            </div>
            <div class="alert alert-danger card_error" id="card-error" role="alert">
                <ul class="mb-0" id="error-list"></ul>
            </div>

            <form action="{{ route('subscription.update') }}" id="card-form" method="POST">
                @csrf
                @method('PUT')
                <input type="text" class="card_name mb-3" id="card-holder-name" placeholder="カード名義人" required>
                <div class="card_element mb-4" id="card-element"></div>
            </form>
            <hr>
            <button class="submit_button text-white w-100" id="card-button" data-secret="{{ $intent->client_secret }}">変更</button>
        </div>
    </div>
</div>
@endsection