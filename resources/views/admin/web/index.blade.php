@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
            <div class="row justify-content-between">
                <div class="col-md-5">
                    <a href="{{ route('admin.shops.index') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-shop fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>店舗管理</h3>
                                <p class="mb-0">店舗情報の閲覧や編集ができます</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-5">
                    <a href="{{ route('admin.reservations.index') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-calendar-days fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>予約管理</h3>
                                <p class="mb-0">予約情報の確認ができます</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-5">
                    <a href="{{ route('admin.reviews.index') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-comment fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>レビュー管理</h3>
                                <p class="mb-0">レビューの確認・削除ができます</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @if (auth('admin')->user()?->role == 'manager')
                    <div class="col-md-5">
                        <a href="{{ route('admin.users.index') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                            <div class="row justify-content-between align-items-center py-4">
                                <div class="col-1 ps-0 me-3">
                                    <i class="fa-solid fa-user fa-2x"></i>
                                </div>
                                <div class="col-9 d-flex flex-column">
                                    <h3>会員情報管理</h3>
                                    <p class="mb-0">会員情報の閲覧ができます</p>
                                </div>
                                <div class="col text-end">
                                    <i class="fa-solid fa-chevron-right fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('admin.categories.index') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                            <div class="row justify-content-between align-items-center py-4">
                                <div class="col-1 ps-0 me-3">
                                    <i class="fa-solid fa-tag fa-2x"></i>
                                </div>
                                <div class="col-9 d-flex flex-column">
                                    <h3>カテゴリ管理</h3>
                                    <p class="mb-0">カテゴリの閲覧・編集ができます</p>
                                </div>
                                <div class="col text-end">
                                    <i class="fa-solid fa-chevron-right fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('admin.users.sales') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                            <div class="row justify-content-between align-items-center py-4">
                                <div class="col-1 ps-0 me-3">
                                    <i class="fa-solid fa-chart-pie fa-2x"></i>
                                </div>
                                <div class="col-9 d-flex flex-column">
                                    <h3>売上管理</h3>
                                    <p class="mb-0">売上の確認・集計ができます</p>
                                </div>
                                <div class="col text-end">
                                    <i class="fa-solid fa-chevron-right fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('admin.masters.index') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                            <div class="row justify-content-between align-items-center py-4">
                                <div class="col-1 ps-0 me-3">
                                    <i class="fa-solid fa-pen fa-2x"></i>
                                </div>
                                <div class="col-9 d-flex flex-column">
                                    <h3>管理者について</h3>
                                    <p class="mb-0">管理者の登録や削除、管理者権限の変更ができます</p>
                                </div>
                                <div class="col text-end">
                                    <i class="fa-solid fa-chevron-right fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection