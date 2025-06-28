@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">店舗一覧</li>
                    </ol>
                </nav>
            </div>
            @if (!empty($filter_master_id))
                @php
                    $filterMaster = \App\Models\Master::find($filter_master_id);
                @endphp
                @if ($filterMaster)
                    <h2>{{ $filterMaster->email }}の店舗一覧</h2>
                @endif
            @elseif (isset($category))
                <h1>{{ $category->name }}の店舗一覧<span class="ms-3">{{ $total_count }}件</span></h1>
            @elseif (!empty($keyword))
                <h1>{{ $keyword }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
            @else
                <h1>店舗一覧<span class="ms-3">{{ $total_count }}件</span></h1>
            @endif
            <hr>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <div class="row">
                <form action="{{ route('admin.shops.index') }}" method="GET" class="col-6 g-1 mb-3">
                    <div class="row">
                        <div class="col-10">
                            <input class="form-control search_input" name="keyword" placeholder="店舗名で検索">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="search_button">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('admin.shops.create') }}" class="btn btn-success">店舗作成</a>
            </div>
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
                        @if ($master->role === 'manager')
                            <tr>
                                <th scope="row">{{ $shop->id }}</th>
                                <td>{{ $shop->name }}</td>
                                <td>{{ $shop->category?->name }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('admin.shops.show', $shop->id) }}" class="btn btn-primary btn-sm mx-1">詳細</a>
                                    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-warning btn-sm mx-1">編集</a>
                                    <form action="{{ route('admin.shops.destroy', $shop) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @elseif ($master->role === 'shop_manager' && auth('admin')->user()->id === $shop->master_id)
                            <tr>
                                <th scope="row">{{ $shop->id }}</th>
                                <td>{{ $shop->name }}</td>
                                <td>{{ $shop->category?->name }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('admin.shops.show', $shop->id) }}" class="btn btn-primary btn-sm mx-1">詳細</a>
                                    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-warning btn-sm mx-1">編集</a>
                                    <form action="{{ route('admin.shops.destroy', $shop) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="mb-4">
                {{ $shops->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection