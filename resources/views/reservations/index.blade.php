@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('mypage') }}">< マイページへ</a>
            </div>
            <h1>予約一覧</h1>
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
                        <p>予約のキャンセル期限は前日の23:59までです。</p>
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
                            @php
                                $tomorrow = Carbon::tomorrow();
                            @endphp
                            @if ($reservationDateTime->gte($tomorrow))
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
            @endif
        </div>
    </div>
</div>
@endsection