@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">予約一覧</li>
                    </ol>
                </nav>
            </div>
            <h1>予約一覧</h1>
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

                    <table class="table table-striped mb-3" {{ $reservationDateTime->isPast() ? 'text-muted' : '' }}>
                        <thead>
                            <tr>
                                <th scope="col">店舗名</th>
                                <th scope="col">予約日</th>
                                <th scope="col">予約時間</th>
                                <th scope="col">予約人数</th>
                                <th scope="col">予約者</th>
                                <th scope="col">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>{{ $reservation->shop->name }}</td>
                            <td>{{ $reservation->reservation_date }}</td>
                            <td>{{ $reservation->reservation_time }}</td>
                            <td>{{ $reservation->people }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td class="d-flex">
                                <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-primary btn-sm my-2">予約詳細</a>
                                <div class="d-flex align-items-center mx-3">
                                    <a href="{{ route('admin.shops.show', $reservation->shop->id) }}" class="link-dark link-opacity-50-hover text-decoration-none">店舗詳細ページへ ></a>
                                </div>
                            </td>
                        </tbody>
                    </table>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection