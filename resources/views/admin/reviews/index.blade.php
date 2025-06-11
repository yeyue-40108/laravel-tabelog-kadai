@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                <li class="breadcrumb-item active" aria-current="page">レビュー一覧</li>
            </ol>
        </nav>
    </div>
    <h1>レビュー一覧</h1>
    @if (session('flash_message'))
        <p>{{ session('flash_message') }}</p>
    @endif
    <div class="row">
        <form action="{{ route('admin.reviews.index') }}" method="GET" class="col-6 g-1 mb-3">
            <div class="row">
                <div class="col-10">
                    <input class="form-control search_input" name="keyword" placeholder="キーワードで検索">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn search_btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="col-6"></div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ユーザー名</th>
                <th scope="col">店舗名</th>
                <th scope="col">内容</th>
                <th scope="col">スコア</th>
                <th scope="col">
                    @sortablelink('created_at', '作成日時')
                </th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection