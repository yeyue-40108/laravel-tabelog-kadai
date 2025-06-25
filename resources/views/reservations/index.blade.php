@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('mypage') }}">< マイページへ</a>
            </div>
            <h1>予約一覧</h1>
            <hr>
            <p>予約のキャンセル期限は前日の23:59までです。</p>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ $type === 'future' ? 'active' : '' }}" href="{{ route('reservations.index', ['type' => 'future']) }}">現在の予約</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $type === 'past' ? 'active' : '' }}" href="{{ route('reservations.index', ['type' => 'past']) }}">過去の予約</a>
                </li>
            </ul>
            @if ($reservations->isEmpty())
                <p class="fs-6">予約はありません。</p>
            @else
                @foreach ($reservations as $reservation)
                    @php
                        $now = \Carbon\Carbon::now();
                        $reservationDateTime = \Carbon\Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
                    @endphp
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3>店舗名：{{ $reservation->shop->name }}</h3>
                            <p class="fs-6">予約日時：{{ $reservation->reservation_date }} {{ $reservation->reservation_time }} </p>
                            <p class="fs-6">予約人数：{{ $reservation->people }} 名</p>
                            @if ($reservationDateTime->gte(\Carbon\Carbon::tomorrow()))
                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('本当にキャンセルしてもよろしいですか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm my-2">キャンセル</button>
                                </form>
                            @endif
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('shops.show', $reservation->shop->id) }}" class="link-dark link-opacity-50-hover text-decoration-none">店舗詳細ページへ ></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mb-4">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection