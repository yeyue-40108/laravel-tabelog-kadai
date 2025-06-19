@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2">
            @component('components.sidebar', ['categories' => $categories, 'prices' => $prices])
            @endcomponent
        </div>
        <div class="col-9">
            <div class="container">
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('top') }}">トップ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">店舗一覧</li>
                    </ol>
                </nav>
                @if ($category !== null)
                    <h1>{{ $category->name }}の店舗一覧<span class="ms-3">{{ $total_count }}件</span></h1>
                @elseif ($price !== null)
                    <h1>{{ $price->range }}の店舗一覧<span class="ms-3">{{ $total_count }}件</span></h1>
                @elseif ($keyword !== null)
                    <h1>{{ $keyword }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
                @else
                    <h1>店舗一覧<span class="ms-3">{{ $total_count }}件</span></h1>
                @endif
                <div class="d-flex align-items-center mb-4">
                    <span class="small me-2">並び替え</span>
                    <form method="GET" action="{{ route('shops.index') }}">
                        @if ($category)
                            <input type="hidden" name="category" value="{{ $category->id }}">
                        @endif
                        @if ($price)
                            <input type="hidden" name="price" value="{{ $price->id }}">
                        @endif
                        @if ($keyword)
                            <input type="hidden" name="keyword" value="{{ $keyword }}">
                        @endif
                        <select class="form-select form-select-sm" name="select_sort" onChange="this.form.submit();">
                            @foreach ($sorts as $key => $value)
                                @if ($sorted === $value)
                                    <option value="{{ $value }}" selected>{{ $key }}</option>
                                @else
                                    <option value="{{ $value }}">{{ $key }}</option>
                                @endif
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <div class="row d-flex justify-content-around">
                @foreach ($shops as $shop)
                    <div class="col-md-5 shop_outline mb-3">
                        <div class="row">
                            <h2 class="col-8">{{ $shop->name }}</h2>
                            <h3 class="col-4 category_label text-center">{{ $shop->category->name }}</h3>
                        </div>
                        <img src="{{ asset('img/dummy-shop.jpg') }}" class="img-thumbnail d-block mx-auto shop_index_img">
                        @php
                            $score = $shop->average_score ?? 0;
                            $percent = ($score / 5) * 100;
                        @endphp

                        <div class="star_rating">
                            <div class="stars">
                                <div class="star_base">★★★★★</div>
                                <div class="star_overlay" style="width: {{ $percent }}%">★★★★★</div>
                            </div>
                            <span class="score_text">{{ number_format($score, 1) }}</span>
                        </div>
                        <p>{{ $shop->price->range }}</p>
                        <p>{{ $shop->address }}</p>
                        <div class="row justify-content-around">
                            <div class="col-6">
                                <a class="btn btn-outline-warning" href="{{ route('shops.show', $shop->id) }}">詳細</a>
                            </div>
                            <div class="col-6">
                                @if (auth()->user()->role === 'paid')
                                    @if (Auth::user()->favorite_shops()->where('shop_id', $shop->id)->exists())
                                        <a href="{{ route('favorites.destroy', $shop->id) }}" class="btn favorite_btn" onclick="event.preventDefault(); document.getElementById('favorites-destroy-form').submit();">
                                            <i class="fa-solid fa-heart"></i>
                                            お気に入り解除
                                        </a>
                                        <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $shop->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <a href="{{ route('favorites.store', $shop->id) }}" class="btn favorite_btn" onclick="event.preventDefault(); document.getElementById('favorites-store-form').submit();">
                                            <i class="fa-solid fa-heart"></i>
                                            お気に入り
                                        </a>
                                        <form id="favorites-store-form" action="{{ route('favorites.store', $shop->id) }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    @endif
                                @else
                                    <button type="button" class="btn favorite_btn" data-bs-toggle="modal" data-bs-target="#favoriteModal">
                                        <i class="fa-solid fa-heart"></i>
                                        お気に入り
                                    </button>
                                    <div class="modal fade" id="favoriteModal" tabindex="-1" aria-labelledby="favoriteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="favoriteModalLabel">有料会員向け機能</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    お気に入り登録機能は有料会員向けの機能になります。<br>
                                                    有料会員は月額300円で以下のことができるようになります。
                                                    <ul>
                                                        <li>お店の予約</li>
                                                        <li>お気に入りの追加</li>
                                                        <li>レビュー投稿</li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('mypage.edit_paid') }}" class="btn btn-success">有料会員登録</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="mb-4">
        {{ $shops->appends(request()->query())->links() }}
    </div>
</div>
@endsection