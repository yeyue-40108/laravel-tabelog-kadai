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
            @if (!empty($keyword))
                <h1>{{ $keyword }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
            @elseif (!empty($start_date) || !empty($end_date))
                <h1>{{ $start_date }} ～ {{ $end_date }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
            @else
                <h1>予約一覧<span class="ms-3">{{ $total_count }}件</span></h1>
            @endif
            <hr>
            <div class="row">
                <form action="{{ route('admin.reservations.index') }}" method="GET" class="col-7 g-1 mb-3">
                    <div class="row">
                        <div class="col-10">
                            <input class="form-control search_input" name="keyword" placeholder="会員名・店舗名で検索">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="search_button">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <form action="{{ route('admin.reservations.index') }}" method="GET" class="col-7 g-1 mb-3">
                    <div class="row">
                        <label class="col-2">日付検索</label>
                        <div class="col-4">
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <span class="col-1">～</span>
                        <div class="col-4">
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="search_button">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @php
                use Carbon\Carbon;
                $now = Carbon::now();
            @endphp

            @if ($reservations->isEmpty())
                <p class="fs-6">予約はありません。</p>
            @else
                <table class="table table-striped mb-3">
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
                        @foreach ($reservations as $reservation)
                            <tr>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <div class="mb-4">
                {{ $reservations->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection