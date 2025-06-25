@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.shops.index') }}">店舗一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">店舗詳細</li>
                    </ol>
                </nav>
            </div>
            <h1>店舗詳細</h1>
            <hr>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <div>
                <div class="d-flex justify-content-end mb-2">
                    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-warning mx-1">編集</a>
                    <form action="{{ route('admin.shops.destroy', $shop) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-1">削除</button>
                    </form>
                </div>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">店舗名</th>
                            <td>{{ $shop->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">カテゴリ名</th>
                            <td>{{ $shop->category->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">画像</th>
                            <td>
                                @if ($shop->image)
                                    <img src="{{ asset('storage/' . $shop->image) }}" class="admin_shop_img">
                                @else
                                    <img src="{{ asset('img/dummy-shop.jpg') }}" class="admin_shop_img">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">店舗説明</th>
                            <td>{{ $shop->description }}</td>
                        </tr>
                        <tr>
                            <th scope="row">郵便番号</th>
                            <td>{{ $shop->postal_code }}</td>
                        </tr>
                        <tr>
                            <th scope="row">住所</th>
                            <td>{{ $shop->address }}</td>
                        </tr>
                        <tr>
                            <th scope="row">電話番号</th>
                            <td>{{ $shop->phone }}</td>
                        </tr>
                        <tr>
                            <th scope="row">営業時間</th>
                            <td>{{ $shop->open_time }} <span>～</span> {{ $shop->close_time }}</td>
                        </tr>
                        <tr>
                            <th scope="row">定休日</th>
                            @php
                                $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                            @endphp
                            <td>
                                @forelse ($shop->holidays as $holiday)
                                    <span>{{ $weekdays[$holiday->weekday] ?? '不明' }}</span>
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
                            <th scope="row">店舗管理者（メールアドレス）</th>
                            <td>{{ $shop->master->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection