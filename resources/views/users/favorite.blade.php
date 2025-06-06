@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>お気に入り</h1>

            <hr class="my-4">

            @if ($favorite_shops->isEmpty())
                <div class="row">
                    <p class="mb-0">お気に入りはまだ追加されていません。</p>
                </div>
            @else
                @foreach ($favorite_shops as $favorite_shop)
                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <a href="{{ route('shops.show', $favorite_shop->id) }}">
                                <img src="{{ asset('img/dummy-shop.jpg') }}" class="img-thumbnail">
                            </a>
                        </div>
                        <div class="col-md-7">
                            <h5><a href="{{ route('shops.show', $favorite_shop->id) }}" class="link-dark">{{ $favorite_shop->name }}</a></h5>
                        </div>
                        <div class="col-md-2">
                            <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $favorite_shop->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link link-dark text-decoration-none">削除</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif

            <hr class="my-4">
            <div class="mb-4">
                <!-- ページネーション -->
            </div>
        </div>
    </div>
</div>
@endsection