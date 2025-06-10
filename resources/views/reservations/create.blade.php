@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <!-- パンくずリスト -->
    </div>
    <div>
        <h1>新規予約</h1>
        <hr class="mt-4">
        <h2 class="mb-3">{{ $shop->name }}</h2>
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="reservation-date" class="form-label">予約日</label>
                <!-- 予約日の選択欄 -->
            </div>
            <div class="mb-3">
                <label for="reservation-time" class="form-label">予約時間</label>
                <!-- 予約時間の選択欄 -->
            </div>
            <div class="mb-3">
                <label for="reservation-people" class="form-label">予約人数</label>
                <!-- 予約人数の選択欄 -->
            </div>
            <button type="submit" class="btn btn-success">予約する</button>
        </form>
    </div>
</div>
@endsection