@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <section>
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item container_img active">
                            <img src="{{ asset('img/cafe.jpg') }}" class="d-block w-100 top_img" alt="cafe" style="height: 400px;">
                        </div>
                        <div class="carousel-item container_img">
                            <img src="{{ asset('img/udon.jpg') }}" class="d-block w-100 top_img" alt="udon" style="height: 400px;">
                        </div>
                        <div class="carousel-item container_img">
                            <img src="{{ asset('img/street.jpg') }}" class="d-block w-100 top_img" alt="street" style="height: 400px;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>
            <section id="search" class="container mt-4">
                <h1 class="text-center section_title">条件を指定して店舗を探す</h1>
                <div class="d-flex justify-content-end mb-1">
                    <a href="{{ route('shops.index') }}" class="link-dark link-opacity-50-hover text-decoration-none fs-5">店舗一覧へ ></a>
                </div>
                <div class="row d-flex justify-content-around">
                    <div class="card col-lg-4">
                        <div class="card-body">
                            <h3 class="card-title mb-3">カテゴリから探す</h3>
                            @foreach ($categories as $category)
                                <a href="{{ route('shops.index', ['category' => $category->id]) }}" class="btn btn-light btn-sm"> {{ $category->name }} </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="card col-lg-3">
                        <div class="card-body">
                            <h3 class="card-title mb-3">キーワードから探す</h3>
                            <form action="{{ route('shops.index') }}" method="GET" class="row g-1">
                                <div class="col-10">
                                    <input class="form-control search_input" name="keyword">
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn search_btn">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card col-lg-4">
                        <div class="card-body">
                            <h3 class="card-title mb-2">時間・曜日から探す</h3>
                            <form action="{{ route('shops.index') }}">
                                <div class="mb-1">
                                    <label>【曜日】</label><br>
                                    @php
                                        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                                    @endphp
                                    @foreach ($weekdays as $index => $label)
                                        <label class="mx-1">
                                            <input type="radio" name="weekday" value="{{ $index }}" {{ request('weekday') == $index ? 'checked' : '' }}>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                                <div class="mb-1">
                                    <label>【時間】</label><br>
                                    <select name="time" class="form-select">
                                        @for ($i = 0; $i < 24; $i++)
                                            @php
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                            @endphp
                                            <option value="{{ $hour }}" {{ request('time') === $hour ? 'selected' : '' }}>
                                                {{ $i }}:00
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-sm search_btn">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            @if (Auth::user() && auth()->user()->role == 'free')
                <button type="button" class="recommend_button" data-bs-toggle="modal" data-bs-target="#recommendModal">有料会員登録は<br>こちらから！</button>
                <div class="modal fade" id="recommendModal" tabindex="-1" aria-labelledby="recommendModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="recommendModalLabel">有料会員登録募集中！</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                NAGOYAMESHIをもっとご活用いただくには有料会員登録がおすすめです！<br>
                                有料会員は月額300円で以下のことができるようになります。
                                <ul>
                                    <li>お店の予約</li>
                                    <li>お気に入りの追加</li>
                                    <li>レビュー投稿</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('mypage.edit_paid') }}" class="btn btn-success">有料会員登録へ ></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection