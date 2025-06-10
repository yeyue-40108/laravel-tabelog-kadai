@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.shops.index') }}">店舗一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">店舗作成</li>
            </ol>
        </nav>
    </div>
    
    <h1>新しい店舗を作成</h1>
    <form action="{{ route('admin.shops.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="shop-name" class="form-label">店舗名</label>
            <input type="text" name="name" id="shop-name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="shop-category" class="form-label">カテゴリ</label>
            <select name="category_id" class="form-select" id="shop-category" aria-label="Default select example">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="shop-description" class="form-label">店舗説明</label>
            <textarea name="description" id="shop-description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="shop-postal-code" class="form-label">郵便番号</label>
            <input type="text" name="postal_code" class="form-control" placeholder="123-4567">
        </div>
        <div class="mb-3">
            <label for="shop-address" class="form-label">住所</label>
            <input type="text" name="address" class="form-control" placeholder="東京都渋谷区道玄坂2丁目11-1Gスクエア渋谷道玄坂4F">
        </div>
        <div class="mb-3">
            <label for="shop-phone" class="form-label">電話番号</label>
            <input type="text" name="phone" class="form-control" placeholder="03-1234-5678">
        </div>
        <div class="row mb-3">
            <div class="col-6 mb-2">
                <label for="open_time" class="form-label">開店時間</label>
                <input type="time" name="open_time" id="open_time" class="form-control">
            </div>
            <div class="col-6 mb-2">
                <label for="close_time" class="form-label">閉店時間</label>
                <input type="time" name="close_time" id="close_time" class="form-control">
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
            <select name="price" class="form-select" id="shop-price" aria-label="Default select example">
                <option value="~1,000">～1,000円</option>
                <option value="1,000~2,000">1,000～2,000円</option>
                <option value="2,000~3,000">2,000～3,000円</option>
                <option value="3,000~4,000">3,000～4,000円</option>
                <option value="4,000~5,000">4,000～5,000円</option>
                <option value="5,000~">5000円～</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">店舗を登録</button>
    </form>
    <a href="{{ route('admin.shops.index') }}">店舗一覧に戻る</a>
</div>
@endsection