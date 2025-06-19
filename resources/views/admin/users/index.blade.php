@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                <li class="breadcrumb-item active" aria-current="page">会員情報一覧</li>
            </ol>
        </nav>
        @if (!empty($keyword))
            <h1>{{ $keyword }}の検索結果<span class="ms-3">{{ $total_count }}件</span></h1>
        @else
            <h1>会員情報一覧<span class="ms-3">{{ $total_count }}件</span></h1>
        @endif
    </div>
    <div class="row">
        <form action="{{ route('admin.users.index') }}" method="GET" class="col-6 g-1 mb-3">
            <div class="row">
                <div class="col-10">
                    <input class="form-control search_input" name="keyword" placeholder="氏名・フリガナ・メールアドレスで検索">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn search_btn">
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
                <th scope="col">氏名</th>
                <th scope="col">フリガナ</th>
                <th scope="col">メールアドレス</th>
                <th scope="col">会員種別</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->furigana }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->role === 'paid')
                            <span>有料会員</span>
                        @else
                            <span>無料会員</span>
                        @endif
                    </td>
                    <td class="d-flex">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm my-2">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mb-4">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection