@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">管理者情報一覧</li>
                    </ol>
                </nav>
                @if (!empty($keyword))
                    <h1>{{ $keyword }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
                @else
                    <h1>管理者情報一覧<span class="ms-3">{{ $total_count }}件</span></h1>
                @endif
            </div>
            <div class="row">
                <form action="{{ route('admin.masters.index') }}" method="GET" class="col-6 g-1 mb-3">
                    <div class="row">
                        <div class="col-10">
                            <input class="form-control search_input" name="keyword" placeholder="メールアドレスで検索">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="search_button">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
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
                        <th scope="col">メールアドレス</th>
                        <th scope="col">作成日時</th>
                        <th scope="col">会員種別</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($masters as $master)
                        <tr>
                            <th scope="row">{{ $master->id }}</th>
                            <td>{{ $master->email }}</td>
                            <td>{{ $master->created_at }}</td>
                            <td>
                                @if ($master->role === 'manager')
                                    <span>トップ管理者</span>
                                @else
                                    <span>店舗管理者</span>
                                @endif
                            </td>
                            <td class="d-flex">
                                @if ($master->role === 'shop_manager')
                                    <a href="{{ route('admin.shops.index', ['master' => $master->id]) }}" class="btn btn-primary btn-sm mx-1">管理店舗一覧</a>
                                @else
                                    <button href="#" class="btn btn-primary btn-sm mx-1" disabled>管理店舗一覧</button>
                                @endif
                                <button type="button" class="btn btn-warning btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#roleChange{{ $master->id }}">管理者権限変更</button>
                                <form action="{{ route('admin.masters.destroy', $master) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal" id="roleChange{{ $master->id }}" aria-labelledby="exampleModalLabel{{ $master->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="roleChange{{ $master->id }}">管理者権限を変更</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if ($master->role === 'manager')
                                            <p>現在の管理者権限：トップ管理者</p>
                                            <p>権限を店舗管理者に変更します。</p>
                                            <form action="{{ route('admin.masters.update', $master->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="role" name="role" value="shop_manager">
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-warning mt-3">管理者権限を変更</button>
                                                </div>
                                            </form>
                                        @else
                                            <p>現在の管理者権限：店舗管理者</p>
                                            <p>権限をトップ管理者に変更します。</p>
                                            <form action="{{ route('admin.masters.update', $master->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="role" name="role" value="manager">
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-warning mt-3">管理者権限を変更</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-4">
                {{ $masters->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection