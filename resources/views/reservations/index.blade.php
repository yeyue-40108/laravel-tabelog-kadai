@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <a href="{{ route('mypage') }}">< マイページへ</a>
    </div>
    <div>
        <h1 class="mt-4">予約一覧</h1>
        @if (session('flash_message'))
            <p>{{ session('flash_message') }}</p>
        @endif
        <hr>
        @php
            use Carbon\Carbon;
            $now = Carbon::now();
            $hasFuture = false;
            $hasPast = false;
        @endphp

        @if ($reservations->isEmpty())
            <p class="fs-6">予約はありません。</p>
        @else
            @foreach ($reservations as $reservation)
                @php
                    $reservationDateTime = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
                @endphp

                @if ($reservationDateTime->isFuture() && !$hasFuture)
                    <h2 class="mt-4">現在の予約</h2>
                    @php $hasFuture = true; @endphp
                @endif

                @if ($reservationDateTime->isPast() && !$hasPast && $hasFuture)
                    <h2 class="mt-4">過去の予約</h2>
                    @php $hasPast = true; @endphp
                @endif

                <div class="card mb-3" {{ $reservationDateTime->isPast() ? 'text-muted' : '' }}>
                    <div class="card-body">
                        <h3>店舗名：{{ $reservation->shop->name }}</h3>
                        <p class="fs-6">予約日時：{{ $reservation->reservation_date }} {{ $reservation->reservation_time }} </p>
                        <p class="fs-6">予約人数：{{ $reservation->people }} 名</p>
                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('本当にキャンセルしてもよろしいですか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm my-2">キャンセル</button>
                        </form>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('shops.show', $reservation->shop->id) }}" class="link-dark link-opacity-50-hover text-decoration-none">店舗詳細ページへ ></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection