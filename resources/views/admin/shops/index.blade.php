@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                <li class="breadcrumb-item active" aria-current="page">店舗一覧</li>
            </ol>
        </nav>
    </div>
    <h1>店舗一覧</h1>
    <div class="row justify-content-around">
        <form action="{{ route('admin.shops.index') }}" method="GET" class="col-6 g-1 mb-3">
            <div class="row">
                <div class="col-10">
                    <input class="form-control search_input" name="keyword" placeholder="店舗名で検索">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn search_btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="col-4">
            <a href="{{ route('admin.shops.create') }}" class="btn btn-success">店舗作成</a>
        </div>
    </div>
    @if (session('flash_message'))
        <p>{{ session('flash_message') }}</p>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">
                    @sortablelink('id', 'ID')
                </th>
                <th scope="col">店舗名</th>
                <th scope="col">カテゴリ</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shops as $shop)
            <tr>
                <th scope="row">{{ $shop->id }}</th>
                <td>{{ $shop->name }}</td>
                <td>{{ $shop->category->name }}</td>
                <td class="d-flex">
                    <a href="{{ route('admin.shops.show', $shop->id) }}" class="btn btn-primary btn-sm my-2">詳細</a>
                    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-warning btn-sm my-2">編集</a>
                    <form action="{{ route('admin.shops.destroy', $shop) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm my-2">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mb-4">
        {{ $shops->appends(request()->query())->links() }}
    </div>
</div>
@endsection