@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">予約一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">予約詳細</li>
                    </ol>
                </nav>
            </div>
            <h1>予約詳細</h1>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.shops.show', $reservation->shop->id) }}" class="link-dark link-opacity-50-hover text-decoration-none fs-6">店舗詳細ページ ></a>
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row">店舗名</th>
                        <td>{{ $reservation->shop->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">予約日</th>
                        <td>{{ $reservation->reservation_date }}</td>
                    </tr>
                    <tr>
                        <th scope="row">予約時間</th>
                        <td>{{ $reservation->reservation_time }}</td>
                    </tr>
                    <tr>
                        <th scope="row">予約人数</th>
                        <td>{{ $reservation->people }}</td>
                    </tr>
                    <tr>
                        <th scope="row">予約者</th>
                        <td>{{ $reservation->user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">連絡先（電話番号）</th>
                        <td>{{ $reservation->user->phone }}</td>
                    </tr>
                    <tr>
                        <th scope="row">予約作成日時</th>
                        <td>{{ $reservation->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection