@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">レビュー一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">レビュー詳細</li>
                    </ol>
                </nav>
            </div>
            <h1>レビュー詳細</h1>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <hr>
            @if ($master->role === 'manager')
                <div class="d-flex justify-content-end">
                    @if ($review->display === 0)
                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="display" id="display" value="1">
                            <button type="submit" class="btn btn-danger">表示する</button>
                        </form>
                    @else
                        <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="display" id="display" value="0">
                            <button type="submit" class="btn btn-danger">非表示にする</button>
                        </form>
                    @endif
                </div>
            @endif
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>会員名</th>
                        <td>{{ $review->user->name }}</td>
                    </tr>
                    <tr>
                        <th>店舗名</th>
                        <td>{{ $review->shop->name }}</td>
                    </tr>
                    <tr>
                        <th>内容</th>
                        <td>{{ $review->content }}</td>
                    </tr>
                    <tr>
                        <th>スコア</th>
                        <td>{{ $review->score }}</td>
                    </tr>
                    <tr>
                        <th>作成日時</th>
                        <td>{{ $review->created_at }}</td>
                    </tr>
                    <tr>
                        <th>更新日時</th>
                        <td>{{ $review->updated_at }}</td>
                    </tr>
                    <tr>
                        <th>レビューの表示状況</th>
                        <td>{{ $review->display ? '表示' : '非表示' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection