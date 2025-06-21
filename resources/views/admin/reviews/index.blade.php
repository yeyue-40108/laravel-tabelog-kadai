@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">レビュー一覧</li>
                    </ol>
                </nav>
                @if (!empty($keyword))
                    <h1>{{ $keyword }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
                @elseif (!empty($start_date) || !empty($end_date))
                    <h1>{{ $start_date }} ～ {{ $end_date }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
                @else
                    <h1>レビュー一覧<span class="ms-3">{{ $total_count }}件</span></h1>
                @endif
            </div>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <div class="row">
                <form action="{{ route('admin.reviews.index') }}" method="GET" class="col-7 g-1 mb-3">
                    <div class="row">
                        <div class="col-10">
                            <input class="form-control search_input" name="keyword" placeholder="会員名・店舗名・内容で検索">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn search_btn">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <form action="{{ route('admin.reviews.index') }}" method="GET" class="col-7 g-1 mb-3">
                    <div class="row">
                        <label class="col-2">日付検索</label>
                        <div class="col-4">
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <span class="col-1">～</span>
                        <div class="col-4">
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn search_btn">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ユーザー名</th>
                        <th scope="col">店舗名</th>
                        <th scope="col">内容</th>
                        <th scope="col">
                            @sortablelink('score', 'スコア')
                        </th>
                        <th scope="col">
                            @sortablelink('created_at', '作成日時')
                        </th>
                        <th scope>レビューの表示状況</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <th>{{ $review->id }}</th>
                            <td>{{ $review->user->name }}</td>
                            <td>{{ $review->shop->name }}</td>
                            <td>{{ $review->content }}</td>
                            <td>{{ $review->score }}</td>
                            <td>{{ $review->created_at }}</td>
                            <td>{{ $review->display ? '表示' : '非表示' }}</td>
                            <td>
                                <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-primary btn-sm">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection