@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="text-center mb-3">会員登録ありがとうございます！</h1>
            <p class="text-center lh-lg mb-5">
                現在、仮会員の状態です。ただいま、ご入力いただいたメールアドレス宛に<br>ご本人確認用のメールをお送りしました。<br>メール本文内のURLをクリックすると本会員登録が完了となります。
            </p>
            <div class="text-center">
                <a href="{{ url('/') }}" class="submit_button w-75 text-white">トップページへ</a>
            </div>
        </div>
    </div>
</div>
@endsection