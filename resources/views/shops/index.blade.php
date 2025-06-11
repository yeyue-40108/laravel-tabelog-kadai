@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2">
            @component('components.sidebar', ['categories' => $categories])
            @endcomponent
        </div>
        <div class="col-9">
            <div class="container">
                @if ($category !== null)
                    <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('top') }}">トップ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        </ol>
                    </nav>
                    <h1>{{ $category->name }}の店舗一覧<span class="ms-3">{{ $total_count }}件</span></h1>
                @elseif ($keyword !== null)
                    <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('top') }}">トップ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">店舗一覧</li>
                        </ol>
                    </nav>
                    <h1>{{ $keyword }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
                @else
                    <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('top') }}">トップ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">店舗一覧</li>
                        </ol>
                    </nav>
                    <h1>店舗一覧<span class="ms-3">{{ $total_count }}件</span></h1>
                @endif
                <div class="d-flex align-items-center mb-4">
                    <span class="small me-2">並び替え</span>
                    <form method="GET" action="{{ route('shops.index') }}">
                        @if ($category)
                            <input type="hidden" name="category" value="{{ $category->id }}">
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

            <div class="row">
                @foreach ($shops as $shop)
                    <div class="col-md-4 shop_outline m-3">
                        <div class="row">
                            <h2 class="col-9">{{ $shop->name }}</h2>
                            <h3 class="col-3 category_label text-center">{{ $shop->category->name }}</h3>
                        </div>
                        <img src="{{ asset('img/dummy-shop.jpg') }}" class="img-thumbnail">
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
                        <p>{{ $shop->price }} <span>円</span></p>
                        <p>{{ $shop->address }}</p>
                        <div class="row justify-content-around">
                            <div class="col-6">
                                <a class="btn btn-outline-warning" href="{{ route('shops.show', $shop->id) }}">詳細</a>
                            </div>
                            <div class="col-6">
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
                            </div>
                        </div>
                    </div>
                @endforeach
                <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $shop->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
                <form id="favorites-store-form" action="{{ route('favorites.store', $shop->id) }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <div class="mb-4">
        {{ $shops->appends(request()->query())->links() }}
    </div>
</div>
@endsection