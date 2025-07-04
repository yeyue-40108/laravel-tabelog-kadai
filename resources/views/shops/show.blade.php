@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('top') }}">トップ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shops.index') }}">店舗一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">店舗詳細</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row d-flex justify-content-between mb-3">
                        <div class="col-4">
                            <h2>{{ $shop->category?->name }}</h2>
                            <h1>{{ $shop->name }}</h1>
                            @php
                                $percent = ($averageScore / 5) * 100;
                            @endphp

                            <div class="star_rating">
                                <div class="stars">
                                    <div class="star_base">★★★★★</div>
                                    <div class="star_overlay" style="width: {{ $percent }}%">★★★★★</div>
                                </div>
                                <span class="score_text">{{ number_format($averageScore, 1) }}</span>
                            </div>
                        </div>
                        <div class="col-4 shop_show_button">
                            @if (auth()->user()->role === 'paid')
                                @if (Auth::user()->favorite_shops()->where('shop_id', $shop->id)->exists())
                                    <a href="{{ route('favorites.destroy', $shop->id) }}" class="favorite_button mx-1" onclick="event.preventDefault(); document.getElementById('favorites-destroy-form').submit();">
                                        <i class="fa-solid fa-heart"></i>
                                        お気に入り解除
                                    </a>
                                @else
                                    <a href="{{ route('favorites.store', $shop->id) }}" class="favorite_button mx-1" onclick="event.preventDefault(); document.getElementById('favorites-store-form').submit();">
                                        <i class="fa-solid fa-heart"></i>
                                        お気に入り
                                    </a>
                                @endif
                                <a href="{{ route('reservations.create', ['shop' => $shop->id]) }}" class="reservation_button text-white mx-1">予約</a>
                            @else
                                <button type="button" class="favorite_button mx-1" data-bs-toggle="modal" data-bs-target="#paidModal">
                                    <i class="fa-solid fa-heart"></i>
                                    お気に入り
                                </button>
                                <button class="reservation_button text-white mx-1" data-bs-toggle="modal" data-bs-target="#paidModal">予約</button>
                                <div class="modal fade" id="paidModal" tabindex="-1" aria-labelledby="paidModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="paidModalLabel">有料会員向け機能</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                こちらは有料会員向けの機能になります。<br>
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
                    <form id="favorites-destroy-form" action="{{ route('favorites.destroy', $shop->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    <form id="favorites-store-form" action="{{ route('favorites.store', $shop->id) }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <div>
                        @if ($shop->image)
                            <img src="{{ asset('storage/' . $shop->image) }}" class="img-thumbnail shop_show_img mb-2">
                        @else
                            <img src="{{ asset('img/dummy-shop.jpg') }}" class="img-thumbnail shop_show_img mb-2">
                        @endif
                    </div>
                    <div>
                        <p>{{ $shop->description }}</p>
                    </div>
                    <hr>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">営業時間</th>
                                <td>{{ $shop->open_time }}<span>～</span>{{ $shop->close_time }}</td>
                            </tr>
                            <tr>
                                <th scope="row">定休日</th>
                                <td>
                                    @php
                                        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                                    @endphp
                                    
                                    @forelse ($shop->holidays as $holiday)
                                        <span>{{ $weekdays[$holiday->weekday] }}</span>
                                    @empty
                                        <span>なし</span>
                                    @endforelse
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">価格帯</th>
                                <td>{{ $shop->price->range }}</td>
                            </tr>
                            <tr>
                                <th scope="row">住所</th>
                                <td>
                                    {{ $shop->postal_code }} <br>
                                    {{ $shop->address }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">電話番号</th>
                                <td>{{ $shop->phone }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="row">
                        <h3>カスタマーレビュー</h3>
                        @if (session('flash_message'))
                            <p>{{ session('flash_message') }}</p>
                        @endif
                        <div class="col-md-6">
                            @if ($reviews->isEmpty())
                                <p>レビューはまだありません。</p>
                            @else
                                @foreach($reviews as $review)
                                    <div>
                                        <h3 class="review_star">{{ str_repeat('★', $review->score) }}</h3>
                                        <p>{{ $review->content }}</p>
                                        @if ($review->user->name == auth()->user()->name)
                                            <div class="d-flex mx-2">
                                                <button type="button" class="btn btn-warning btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editReview{{ $review->id }}">編集</button>
                                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                                                </form>
                                            </div>
                                            <div class="modal" id="editReview{{ $review->id }}" aria-labelledby="exampleModalLabel{{ $review->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h2 class="modal-title" id="editReviewLabel{{ $review->id }}">レビューを編集</h2>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <p>評価</p>
                                                                @php
                                                                    $selected = function ($value) use ($review) {
                                                                        return old('score', $review->score) === $value ? 'selected' : '';
                                                                    };
                                                                @endphp
                                                                <select name="score" class="form-control m-2 review_star" aria-label="Default select example">
                                                                    <option value="5" class="review_star" {{ $selected('5') }}>★★★★★</option>
                                                                    <option value="4" class="review_star" {{ $selected('4') }}>★★★★</option>
                                                                    <option value="3" class="review_star" {{ $selected('3') }}>★★★</option>
                                                                    <option value="2" class="review_star" {{ $selected('2') }}>★★</option>
                                                                    <option value="1" class="review_star" {{ $selected('1') }}>★</option>
                                                                </select>
                                                                <p>レビュー内容</p>
                                                                @error ('content')
                                                                    <strong>レビュー内容を入力してください。</strong>
                                                                @enderror
                                                                <textarea name="content" class="form-control m-2">{{ $review->content }}</textarea>

                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" class="btn btn-warning mt-3">レビューを編集</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <p>{{ $review->created_at }} {{ $review->user->name }}</p>
                                    </div>
                                @endforeach
                                <div class="mb-4">
                                    {{ $reviews->links() }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h3>レビューを投稿する</h3>
                            @if (auth()->user()->role === 'paid')
                                <form method="POST" action="{{ route('reviews.store') }}">
                                    @csrf
                                    <p>評価</p>
                                    <select name="score" class="form-control m-2 review_star" aria-label="Default select example">
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
                                    <button type="submit" class="submit_button ml-2 text-white">レビューを投稿</button>
                                </form>
                            @else
                                <p>レビュー投稿は有料会員向けの機能です。</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection