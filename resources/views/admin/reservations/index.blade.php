@extends('layouts.app')

@section('content')
<div>
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                <li class="breadcrumb-item active" aria-current="page">予約一覧</li>
            </ol>
        </nav>
    </div>
    <h1>予約一覧</h1>
    <hr>
</div>
@endsection