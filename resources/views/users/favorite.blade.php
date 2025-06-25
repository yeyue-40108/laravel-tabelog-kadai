@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('mypage') }}">< マイページへ</a>
            </div>
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
                            <h5>{{ $favorite_shop->name }}</a></h5>
                            <a href="{{ route('shops.show', $favorite_shop->id) }}" class="link-dark link-opacity-50-hover fs-6">店舗詳細ページへ ></a>
                        </div>
                        <div class="col-md-2">
                            <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $favorite_shop->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">削除</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="mb-4">
                {{ $favorite_shops->links() }}
            </div>
        </div>
    </div>
</div>
@endsection