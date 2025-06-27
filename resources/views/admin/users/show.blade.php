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
            </div>
            <h1>会員情報詳細</h1>
            <hr>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm mx-1">編集</a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('本当に退会させてもよろしいですか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm mx-1">退会</button>
                </form>
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
                        <td>{{ $user->phone ?? '未登録' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">生年月日</th>
                        <td>{{ $user->birthday ?? '未登録' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">職業</th>
                        @php
                            $workLabel = ['company' => '会社員', 'government' => '公務員', 'student' => '学生', 'house' => '主婦・主夫', 'other' => 'その他'];
                        @endphp
                        <td>{{ $workLabel[$user->work] ?? '未登録' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">登録日時</th>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">退会日時</th>
                        <td>{{ $user->deleted_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection