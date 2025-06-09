@extends('layouts.app')

@section('content')
<section>
    <div id="carouselExampleAutoplaying" class="carousel slide main_visual" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="{{ asset('img/cafe.jpg') }}" class="d-block img-fluid top_img" alt="cafe">
            </div>
            <div class="carousel-item">
            <img src="{{ asset('img/udon.jpg') }}" class="d-block img-fluid top_img" alt="udon">
            </div>
            <div class="carousel-item">
            <img src="{{ asset('img/street.jpg') }}" class="d-block img-fluid top_img" alt="street">
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
<section id="features">
    <h1 class="text-center section_title">特集</h1>
    <!-- カルーセル？で特集を３つほど表示 -->
</section>
<section id="search" class="container">
    <h1 class="text-center section_title">条件を指定して店舗を探す</h1>
    <div class="row">
        <div class="card col-md-4">
            <div class="card-body">
                <h3 class="card-title">カテゴリから探す</h3>
                @foreach ($categories as $category)
                    <a href="{{ route('shops.index', ['category' => $category->id]) }}" class="btn btn-light btn-sm"> {{ $category->name }} </a>
                @endforeach
            </div>
        </div>
        <div class="card col-md-4">
            <div class="card-body">
                <h3 class="card-title">キーワードから探す</h3>
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
        <div class="card col-md-4">
            <div class="card-body">
                <h3 class="card-title">エリアから探す</h3>
                <!-- エリア -->
            </div>
        </div>
    </div>
</section>
@endsection