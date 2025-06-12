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
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="monday" id="monday">
                <label class="form-check-label" for="monday">月</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="tuesday" id="tuesday">
                <label class="form-check-label" for="tuesday">火</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="wednesday" id="wednesday">
                <label class="form-check-label" for="wednesday">水</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="thursday" id="thursday">
                <label class="form-check-label" for="thursday">木</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="friday" id="friday">
                <label class="form-check-label" for="friday">金</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="saturday" id="saturday">
                <label class="form-check-label" for="saturday">土</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="sunday" id="sunday">
                <label class="form-check-label" for="sunday">日</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="holiday[]" value="none" id="none">
                <label class="form-check-label" for="none">定休日なし</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="shop-price" class="form-label">価格帯</label>
            @php
                $selected = function ($value) use ($shop) {
                    return old('price', $shop->price) === $value ? 'selected' : '';
                };
            @endphp
            <select name="price" class="form-select" id="shop-price" aria-label="Default select example">
                <option value="~1,000" {{ $selected('~1,000') }}>～1,000円</option>
                <option value="1,000~2,000" {{ $selected('1,000~2,000') }}>1,000～2,000円</option>
                <option value="2,000~3,000" {{ $selected('2,000~3,000') }}>2,000～3,000円</option>
                <option value="3,000~4,000" {{ $selected('3,000~4,000') }}>3,000～4,000円</option>
                <option value="4,000~5,000" {{ $selected('4,000~5,000') }}>4,000～5,000円</option>
                <option value="5,000~" {{ $selected('5,000~') }}>5,000円～</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">編集</button>
    </form>
</div>
@endsection