@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <!-- パンくずリスト -->
    </div>
    <div>
        <h1>予約一覧</h1>
        @if (session('flash_message'))
            <p>{{ session('flash_message') }}</p>
        @endif
    </div>
</div>
@endsection