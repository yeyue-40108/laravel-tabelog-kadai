@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <!-- パンくずリスト -->
    </div>
    <div>
        <h1>予約一覧</h1>
        @if (session('flash_message'))
            <p>{{ session('flash_message') }}</p>
        @endif
        <hr>
        <h2>現在の予約</h2>
        <div>
            @foreach ($reservations as $reservation)
                <h3>{{ $shop->id->name }}</h3>
                <p>{{ $reservation->reservation_date }} <span>{{ $reservation->reservation_time }}</span></p>
                <p>"予約人数：. {{ $reservation->people }} . 名"</p>
            @endforeach
        </div>
        <hr>
        <h2>過去の予約</h2>
    </div>
</div>
@endsection