@extends('layouts.app')

@section('content')
<div class="container">
    <!-- パンくずリスト -->
    
    <h1>店舗情報更新</h1>
    <form action="{{ route('shops.update', $shop->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="shop-name">店舗名</label>
            <input type="text" name="name" id="shop-name" class="form-control" value="{{ $shop->name }}">
        </div>
        <div class="form-group">
            <label for="shop-description">店舗説明</label>
            <textarea name="description" id="shop-description" class="form-control">{{ $shop->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="shop-postal-code">郵便番号</label>
            <input type="text" name="postal_code" class="form-control" value="{{ $shop->postal_code }}">
        </div>
        <div class="form-group">
            <label for="shop-address">住所</label>
            <input type="text" name="address" class="form-control" value="{{ $shop->address }}">
        </div>
        <div class="form-group">
            <label for="shop-phone">電話番号</label>
            <input type="text" name="phone" class="form-control" value="{{ $shop->phone }}">
        </div>
        <div class="form-group">
            <label for="shop-category">カテゴリ</label>
            <select name="category_id" class="form-control" id="shop-category">
                @foreach ($categories as $category)
                    @if ($category->id === $shop->category_id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-warning">更新</button>
    </form>
    <a href="{{ route('shops.index') }}">店舗一覧に戻る</a>
</div>
@endsection