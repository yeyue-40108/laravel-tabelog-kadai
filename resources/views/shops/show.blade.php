@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- パンくずリスト -->
    </div>
    <div class="row">
        <div class="col">
            <div>
                <!-- カテゴリ名 -->
                <h1>{{ $shop->name }}</h1>
                <!-- レビュー（星と数字） -->
                <button class="btn">お気に入り</button>
                <button class="btn">予約</button>
            </div>
            <div>
                <!-- 画像 -->
            </div>
            <div>
                <h3>{{ $shop->description }}</h3>
            </div>
            <div class="row">
                <div class="col-6">
                    <!-- 営業時間 -->
                    <!-- 定休日 -->
                    <!-- 価格帯 -->
                    <p>住所：{{ $shop->postal_code }} <br>{{ $shop->address }}</p>
                    <p>電話番号：{{ $shop->phone }}</p>
                </div>
                <div class="col-6">
                    <!-- マップ -->
                </div>
            </div>
            <div>
                <!-- レビュー -->
            </div>
        </div>
    </div>
</div>
@endsection