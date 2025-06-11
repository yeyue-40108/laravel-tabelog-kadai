@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                <li class="breadcrumb-item active" aria-current="page">カテゴリ一覧</li>
            </ol>
        </nav>
    </div>
    <h1>カテゴリ一覧</h1>
    <div class="d-flex flex-row-reverse">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCategory">新しいカテゴリを作成</button>
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
                <th scope="col">カテゴリ名</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <th>{{ $category->id }}</th>
                    <td>{{ $category->name }}</td>
                    <td class="d-flex">
                        <a href="{{ route('admin.shops.index', ['category' => $category->id]) }}" class="btn btn-primary btn-sm my-2">店舗一覧</a>
                        <button type="button" class="btn btn-warning btn-sm my-2" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}">編集</button>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm my-2">削除</button>
                        </form>
                    </td>
                </tr>
                <div class="modal" id="editCategory{{ $category->id }}" aria-labelledby="exampleModalLabel{{ $category->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="editCategoryLabel{{ $category->id }}">カテゴリ名を編集</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label for="name" class="form-label">カテゴリ名</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-warning mt-3">カテゴリ名を編集</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal" id="createCategory" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">新しいカテゴリを作成</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <label for="category-name" class="form-label">カテゴリ名</label>
                    <input type="text" name="name" id="category-name" class="form-control">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success mt-3">カテゴリを作成</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection