@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">トップ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shops.index') }}">店舗一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">店舗詳細</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col">
            <div class="row d-flex justify-content-between">
                <div class="col-4">
                    <h2>{{ $shop->category->name }}</h2>
                    <h1>{{ $shop->name }}</h1>
                    <!-- レビュー（星と数字） -->
                </div>
                <div class="col-4">
                    @if (Auth::user()->favorite_shops()->where('shop_id', $shop->id)->exists())
                        <a href="{{ route('favorites.destroy', $shop->id) }}" class="btn favorite_btn" onclick="event.preventDefault(); document.getElementById('favorites-destroy-form').submit();">
                            <i class="fa-solid fa-heart"></i>
                            お気に入り解除
                        </a>
                    @else
                        <a href="{{ route('favorites.store', $shop->id) }}" class="btn favorite_btn" onclick="event.preventDefault(); document.getElementById('favorites-store-form').submit();">
                            <i class="fa-solid fa-heart"></i>
                            お気に入り
                        </a>
                    @endif
                    <button class="btn reservation_btn text-white">予約</button>
                </div>
            </div>
            <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $shop->id) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
            <form id="favorites-store-form" action="{{ route('favorites.store', $shop->id) }}" method="POST" class="d-none">
                @csrf
            </form>
            <div>
                <img src="{{ asset('img/dummy-shop.jpg') }}" class="img-thumbnail shop_show_img">
            </div>
            <div>
                <p>{{ $shop->description }}</p>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <p class="col-2">営業時間</p>
                        <p class="col-10">{{ $shop->open_time }}<span>～</span>{{ $shop->close_time }}</p>
                    </div>
                    <div class="row">
                        <p class="col-2">定休日</p>
                        <div class="col-10">
                            @foreach ($holidays as $holiday)
                                <span>{{ $holiday }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <p class="col-2">価格帯</p>
                        <p class="col-10">{{ $shop->price }}<span>円</span></p>
                    </div>
                    <div class="row">
                        <p class="col-2">住所</p>
                        <div class="col-10">
                            <p class="mb-0">{{ $shop->postal_code }}</p>
                            <p>{{ $shop->address }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <p class="col-2">電話番号</p>
                        <p class="col-10">{{ $shop->phone }}</p>
                    </div>
                </div>
                <div class="col-6">
                    <!-- マップ -->
                </div>
            </div>
            <hr>
            <div class="row">
                <h3>カスタマーレビュー</h3>
                <div class="col-md-6">
                    @foreach($reviews as $review)
                        <div>
                            <h3 class="review_star">{{ str_repeat('★', $review->score) }}</h3>
                            <p>{{ $review->content }}</p>
                            <p>{{ $review->created_at }} {{ $review->user->name }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <h3>レビューを投稿する</h3>
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <p>評価</p>
                        <select name="score" class="form-control m-2 review_star">
                            <option value="5" class="review_star">★★★★★</option>
                            <option value="4" class="review_star">★★★★</option>
                            <option value="3" class="review_star">★★★</option>
                            <option value="2" class="review_star">★★</option>
                            <option value="1" class="review_star">★</option>
                        </select>
                        <p>レビュー内容</p>
                        @error ('content')
                            <strong>レビュー内容を入力してください。</strong>
                        @enderror
                        <textarea name="content" class="form-control m-2"></textarea>
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <button type="submit" class="btn submit_btn ml-2 text-white">レビューを投稿</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection