@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-5">
            <h1>マイページ</h1>
            @if (session('flash_message'))
                <p>{{ session('flash_message') }}</p>
            @endif
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
                <a href="{{ route('mypage.edit_password') }}" class="link-dark link-opacity-50-hover text-decoration-none">
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
            @if (auth()->user()->role === 'free')
                <div class="container">
                    <a href="{{ route('mypage.edit_paid') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-arrow-trend-up fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>有料会員への移行</h3>
                                <p class="mb-0">有料会員への移行ができます。</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <hr>
            @endif
            @if (auth()->user()->role === 'paid')
                <div class="container">
                    <a href="{{ route('subscription.edit') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-credit-card fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>お支払い方法変更</h3>
                                <p class="mb-0">有料会員プランのお支払いカード情報を変更します</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <hr>
                <div class="container">
                    <a href="{{ route('mypage.favorite') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-heart fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>お気に入り一覧</h3>
                                <p class="mb-0">お気に入りに登録した店舗を確認できます</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <hr>
                <div class="container">
                    <a href="{{ route('reservations.index') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-calendar-days fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>予約一覧</h3>
                                <p class="mb-0">予約状況を確認できます</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <hr>
                <div class="container">
                    <a href="{{ route('subscription.cancel') }}" class="link-dark link-opacity-50-hover text-decoration-none">
                        <div class="row justify-content-between align-items-center py-4">
                            <div class="col-1 ps-0 me-3">
                                <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                            </div>
                            <div class="col-9 d-flex flex-column">
                                <h3>有料会員解約</h3>
                                <p class="mb-0">有料会員を解約し無料会員に移行します。</p>
                            </div>
                            <div class="col text-end">
                                <i class="fa-solid fa-chevron-right fa-2x"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <hr>
            @endif
            <div class="container">
                <a href="{{ route('logout') }}" class="link-dark link-opacity-50-hover text-decoration-none" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
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
            <hr>
            @if (auth()->user()->role === 'free')
                <div class="d-flex flex-row-reverse">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#destroyModal">退会する</button>
                </div>
                <div class="modal fade" id="destroyModal" tabindex="-1" aria-labelledby="destroyModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="destroyModalLabel">退会フォーム</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                一度退会すると、データはすべて削除され復旧はできません。<br>本当に退会しますか？
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">キャンセル</button>
                                <form action="{{ route('mypage.destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">退会する</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection