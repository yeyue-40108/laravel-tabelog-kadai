@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <a href="{{ route('shops.show', $shop->id) }}">< 店舗詳細ページに戻る</a>
    </div>
    <div>
        <h1>新規予約</h1>
        <hr class="mt-4">
        <h2 class="mb-3">{{ $shop->name }}</h2>
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="reservation-date" class="form-label">予約日</label>
                <input type="date" name="date" class="form-control"></input>
            </div>
            <div class="mb-3">
                <label for="reservation-time" class="form-label">予約時間</label>
                <input type="time" name="time" class="form-control" step="1800">
            </div>
            <div class="mb-3">
                <label for="people" class="form-label">予約人数</label>
                <input type="number" name="people" class="form-control"> <span>名</span>
            </div>
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <label class="mb-3">
                <input type="checkbox" id="reservation-confirm">
                ご登録いただいている氏名と電話番号を予約店舗へ共有させていただきます。同意いただける場合はチェックをしてください。
            </label>
            <br>
            <button type="submit" class="btn btn-success" id="submit-button" disabled>予約する</button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('reservation-confirm');
                const button = document.getElementById('submit-button');

                checkbox.addEventListener('change', function() {
                    button.disabled = !this.checked;
                });
            });
        </script>
    </div>
</div>
@endsection