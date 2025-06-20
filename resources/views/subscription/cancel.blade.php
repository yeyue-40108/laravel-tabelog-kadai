@extends('layouts.app')

@section('content')
<div>
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                <li class="breadcrumb-item active" aria-current="page">有料会員の解約</li>
            </ol>
        </nav>
    </div>
    <h1 class="mb-3">有料会員の解約</h1>
    <hr class="mb-4">
    <label class="mb-3">
        <input type="checkbox" id="cancel_confirm">
        有料会員を解約すると有料会員限定の機能を使用できなくなります。本当によろしいですか？
    </label>
    <form action="{{ route('subscription.destroy') }}" id="card-form" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger w-50" id="cancel_button" disabled>解約</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('cancel_confirm');
            const button = document.getElementById('cancel_button');

            checkbox.addEventListener('change', function() {
                button.disabled = !this.checked;
            });
        });
    </script>
</div>
@endsection