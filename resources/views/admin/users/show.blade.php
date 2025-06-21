@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">会員情報一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">会員情報詳細</li>
                    </ol>
                </nav>
                <h1>会員情報詳細</h1>
            </div>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm my-2">編集</a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('本当に退会させてもよろしいですか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm my-2">退会</button>
                </form>
                <!-- パスワード再設定メール送信 -->
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th scope="row">氏名</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">フリガナ</th>
                        <td>{{ $user->furigana }}</td>
                    </tr>
                    <tr>
                        <th scope="row">メールアドレス</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">会員種別</th>
                        <td>
                            @if ($user->role === 'paid')
                                <span>有料会員</span>
                            @else
                                <span>無料会員</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">電話番号</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th scope="row">生年月日</th>
                        <td>{{ $user->birthday }}</td>
                    </tr>
                    <tr>
                        <th scope="row">職業</th>
                        <td>{{ $user->work }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection