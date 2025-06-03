@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- パンくずリスト -->
        <!-- 並び替え -->
        <!-- 検索欄 -->
    </div>

    <div class="row">
        @foreach ($shops as $shop)
            <div class="col-md-4 shop_outline">
                <h2>{{ $shop->name }}</h2>
                <!-- カテゴリ名 -->
                <!-- 画像 -->
                <!-- レビュー -->
                <!-- 価格帯 -->
                <p>{{ $shop->postal_code }}</p>
                <p>{{ $shop->address }}</p>
                <div class="row">
                    <div class="col-4">
                        <button class="btn btn-outline-warning">詳細</button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-outline-primary">予約</button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-outline-danger">お気に入り</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mb-4">
        <!-- ページネーション -->
    </div>
</div>
@endsection