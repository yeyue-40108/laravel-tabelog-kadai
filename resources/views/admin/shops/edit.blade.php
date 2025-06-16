@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <a href="{{ route('admin.shops.show', $shop->id) }}">< 店舗詳細ページに戻る</a>
    </div>
    
    <h1>店舗情報編集</h1>
    <form action="{{ route('admin.shops.update', $shop->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="shop-name" class="form-label">店舗名</label>
            <input type="text" name="name" id="shop-name" class="form-control" value="{{ $shop->name }}">
        </div>
        <div class="mb-3">
            <label for="shop-category" class="form-label">カテゴリ</label>
            <select name="category_id" class="form-control" id="shop-category"  aria-label="Default select example">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id === $shop->category_id ? 'selected' : (old('category->id') == $category->id ? 'selected' : '')}}>{{ $category-> name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="shop-image" class="form-label">画像ファイル</label>
            <input type="file" name="image" class="form-control" value="{{ $shop->image }}">
        </div>
        <div class="mb-3">
            <label for="shop-description" class="form-label">店舗説明</label>
            <textarea name="description" id="shop-description" class="form-control">{{ $shop->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="shop-postal-code" class="form-label">郵便番号</label>
            <input type="text" name="postal_code" class="form-control" value="{{ $shop->postal_code }}">
        </div>
        <div class="mb-3">
            <label for="shop-address" class="form-label">住所</label>
            <input type="text" name="address" class="form-control" value="{{ $shop->address }}">
        </div>
        <div class="mb-3">
            <label for="shop-phone" class="form-label">電話番号</label>
            <input type="text" name="phone" class="form-control" value="{{ $shop->phone }}">
        </div>
        <div class="row mb-3">
            <div class="col-6 mb-2">
                <label for="open_time" class="form-label">開店時間</label>
                <input type="time" name="open_time" id="open_time" class="form-control" value="{{ $shop->open_time }}">
            </div>
            <div class="col-6 mb-2">
                <label for="close_time" class="form-label">閉店時間</label>
                <input type="time" name="close_time" id="close_time" class="form-control" value="{{ $shop->close_time }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">定休日</label><br>
            @php
                $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                $selectedWeekdays = old('weekdays', $shop->holidays->pluck('weekday')->toArray());
            @endphp

            @foreach ($weekdays as $index => $label)
                <label class="mx-2">
                    <input type="checkbox" name="weekdays[]" value="{{ $index }}" {{ in_array($index, $selectedWeekdays) ? 'checked' : '' }}>
                    {{ $label }}
                </label>
            @endforeach
        </div>
        <div class="mb-3">
            <label for="shop-price" class="form-label">価格帯</label>
            <select name="price_id" class="form-control" id="shop-price"  aria-label="Default select example">
                @foreach ($prices as $price)
                    <option value="{{ $price->id }}" {{ $price->id === $shop->price_id ? 'selected' : (old('price->id') == $price->id ? 'selected' : '')}}>{{ $price-> range }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-warning">編集</button>
    </form>
</div>
@endsection