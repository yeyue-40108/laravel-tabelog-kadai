@extends('layouts.app')

@section('content')
<div class="container">
    <!-- パンくずリスト -->
    
    <h1>新しい店舗を追加</h1>
    <form action="{{ route('shops.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="shop-name">店舗名</label>
            <input type="text" name="name" id="shop-name" class="form-control">
        </div>
        <div class="form-group">
            <label for="shop-description">店舗説明</label>
            <textarea name="description" id="shop-description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="shop-postal-code">郵便番号</label>
            <input type="text" name="postal_code" class="form-control">
        </div>
        <div class="form-group">
            <label for="shop-address">住所</label>
            <input type="text" name="address" class="form-control">
        </div>
        <div class="form-group">
            <label for="shop-phone">電話番号</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="shop-category">カテゴリ</label>
            <select name="category_id" class="form-control" id="shop-category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-warning">店舗を登録</button>
    </form>
    <a href="{{ route('shops.index') }}">店舗一覧に戻る</a>
</div>
@endsection