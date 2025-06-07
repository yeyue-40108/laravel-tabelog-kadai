@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2">
            <form action="{{ route('shops.index') }}" method="GET" class="row g-1 mb-3">
                <div class="col-10">
                    <input class="form-control search_input" name="keyword">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn search_btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
            @foreach ($categories as $c)
                <label class="sidebar_label"><a href="{{ route('shops.index', ['category' => $c->id]) }}">{{ $c->name }}</a></label>
            @endforeach
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
                        <!-- レビュー -->
                        <!-- 価格帯 -->
                        <p>{{ $shop->postal_code }}</p>
                        <p>{{ $shop->address }}</p>
                        <div class="row">
                            <div class="col-4">
                                <a class="btn btn-outline-warning" href="{{ route('shops.show', $shop) }}">詳細</a>
                            </div>
                            <div class="col-4">
                                <button class="btn reservation_btn text-white">予約</button>
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