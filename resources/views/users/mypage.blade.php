@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-5">
            <h1 class="mb-4">マイページ</h1>

            <hr>
            <div class="container">
                <a href="{{ route('mypage.edit') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                    <div class="row justify-content-between align-items-center py-4">
                        <div class="col-1 ps-0 me-3">
                            <i class="fa-solid fa-user fa-2x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3>会員情報の編集</h3>
                            <p class="mb-0">氏名やメールアドレスを変更できます</p>
                        </div>
                        <div class="col text-end">
                            <i class="fa-solid fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </div>
            <hr>
            <div class="container">
                <a href="#" class="link-dark link-opacity-50-hover text-decoration-none">
                    <div class="row justify-content-between align-items-center py-4">
                        <div class="col-1 ps-0 me-3">
                            <i class="fa-solid fa-lock fa-2x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3>パスワード変更</h3>
                            <p class="mb-0">ログイン時のパスワードを変更します</p>
                        </div>
                        <div class="col text-end">
                            <i class="fa-solid fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </div>
            <hr>
            <div class="container">
                <a href="#" class="link-dark link-opacity-50-hover text-decoration-none">
                    <div class="row justify-content-between align-items-center py-4">
                        <div class="col-1 ps-0 me-3">
                            <i class="fa-solid fa-calendar-days fa-2x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3>予約履歴</h3>
                            <p class="mb-0">過去の予約を確認できます</p>
                        </div>
                        <div class="col text-end">
                            <i class="fa-solid fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </div>
            <hr>
            <div class="container">
                <a href="{{ route('logout') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                    <div class="row justify-content-between align-items-center py-4">
                        <div class="col-1 ps-0 me-3">
                            <i class="fa-solid fa-right-from-bracket fa-2x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3>ログアウト</h3>
                            <p class="mb-0">NAGOYAMESHIからログアウトします</p>
                        </div>
                        <div class="col text-end">
                            <i class="fa-solid fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection