@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <a href="{{ route('reservations.index') }}">予約一覧ページに戻る</a>
    </div>
    <div>
        <h1>予約詳細</h1>
        <hr>
        <h3>{{ $shop->id->name }}</h3>
        <a href="{{ route('shops.show', $shop->id) }}">店舗詳細ページへ</a>
        <p>{{ $reservation->reservation_date }} <span>{{ $reservation->reservation_time }}</span></p>
        <p>"予約人数：. {{ $reservation->people }} . 名"</p>
        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('本当に予約をキャンセルしてもよろしいですか？')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm my-2">キャンセル</button>
        </form>
    </div>
</div>
@endsection