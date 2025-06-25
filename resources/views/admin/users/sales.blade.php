@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.web.index') }}">管理画面トップ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">売上一覧</li>
                    </ol>
                </nav>
            </div>
            <h1>売上一覧</h1>
            <hr>
            <div class="card mb-4">
                <h2 class="card-header">今月の状況</h2>
                <div class="card-body">
                    <h3 class="card-title">売上：{{ $sales }}円</h3>
                    <h3 class="card-title">有料会員数：{{ $total_count }}名</h3>
                </div>
            </div>
            <div class="row">
                <h3>条件で検索する</h3>
                <form action="{{ route('admin.users.sales') }}" method="GET" class="mb-3">
                    <div class="d-flex mb-2">
                        <label class="mx-2">期間</label>
                        <div class="d-flex">
                            <select name="start_year" class="form-select">
                                <option value="" {{ request('start_year') ? 'selected' : '' }}>- 選択 -</option>
                                @for ($y = now()->year; $y >= now()->year -2; $y--)
                                    <option value="{{ $y }}" {{ request('start_year') == $y ? 'selected' : '' }}>{{ $y }}年</option>
                                @endfor
                            </select>
                            <select name="start_month" class="form-select">
                                <option value="" {{ request('start_month') ? 'selected' : '' }}>- 選択 -</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ request('start_month') == $m ? 'selected' : '' }}>{{ $m }}月</option>
                                @endfor
                            </select>
                        </div>
                        <span class="mx-2">～</span>
                        <div class="d-flex">
                            <select name="end_year" class="form-select">
                                <option value="" {{ request('end_year') ? 'selected' : '' }}>- 選択 -</option>
                                @for ($y = now()->year; $y >= now()->year -2; $y--)
                                    <option value="{{ $y }}" {{ request('end_year') == $y ? 'selected' : '' }}>{{ $y }}年</option>
                                @endfor
                            </select>
                            <select name="end_month" class="form-select">
                                <option value="" {{ request('end_month') ? 'selected' : '' }}>- 選択 -</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ request('end_month') == $m ? 'selected' : '' }}>{{ $m }}月</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <p>※上記の期間に有料会員になった人数を検索</p>
                    <div class="d-flex mb-2">
                        <label>年代別</label>
                        <select name="age" class="form-select w-50">
                            <option value="" {{ request('age') === null ? 'selected' : '' }}>-- 選択 --</option>
                            <option value="10" {{ request('age') == 10 ? 'selected' : '' }}>10代以下</option>
                            <option value="20" {{ request('age') == 20 ? 'selected' : '' }}>20代</option>
                            <option value="30" {{ request('age') == 30 ? 'selected' : '' }}>30代</option>
                            <option value="40" {{ request('age') == 40 ? 'selected' : '' }}>40代</option>
                            <option value="50" {{ request('age') == 50 ? 'selected' : '' }}>50代</option>
                            <option value="60" {{ request('age') == 60 ? 'selected' : '' }}>60代以上</option>
                        </select>
                    </div>
                    <div class="d-flex mb-2">
                        <label>職業別</label>
                        <select name="work" class="form-select w-50">
                            <option value="" {{ request('work') === null ? 'selected' : '' }}>-- 選択 --</option>
                            <option value="company" {{ request('work') === 'company' ? 'selected' : '' }}>会社員</option>
                            <option value="government" {{ request('work') === 'government' ? 'selected' : '' }}>公務員</option>
                            <option value="student" {{ request('work') === 'student' ? 'selected' : '' }}>学生</option>
                            <option value="house" {{ request('work') === 'house' ? 'selected' : '' }}>主婦・主夫</option>
                            <option value="other" {{ request('work') === 'other' ? 'selected' : '' }}>その他</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="search_letter_button">検索</button>
                    </div>
                </form>
                <hr>
                <div>
                    @if (($start_year !== null && $start_month !== null) || ($end_year !== null && $end_month !== null))
                        <h3>> 検索結果</h3>
                        <h3>合計：<span class="text-decoration-underline">{{ $limit_count }}名</span></h3>
                    @elseif ( $age !== null || $work !== null)
                        <h3>> 検索結果</h3>
                        <h3>売上：<span class="text-decoration-underline">{{ $limit_sales }}円</span></h3>
                        <h3>合計：<span class="text-decoration-underline">{{ $limit_count }}名</span></h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection