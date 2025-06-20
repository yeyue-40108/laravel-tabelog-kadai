<div class="footer_container py-3">
    <h2 class="my-3 text-center">
        <a href="{{ url('/') }}"></a>
        NAGOYAMESHI
    </h2>
    <div class="py-2">
        <div class="d-flex justify-content-center">
            <i class="fa-solid fa-location-dot"></i>
            <p class="mx-2">東京都渋谷区道玄坂2丁目11-1Gスクエア渋谷道玄坂4F</p>
        </div>
        <div class="d-flex justify-content-center">
            <i class="fa-solid fa-phone"></i>
            <p class="mx-2">03-1234-5678</p>
        </div>
        <div class="d-flex justify-content-center">
            <i class="fa-solid fa-envelope"></i>
            <p class="mx-2">nagoyameshi@example.com</p>
        </div>
        @if (Auth::guard('admin')->check())
            <a href="{{ route('login') }}" class="d-flex justify-content-center link-dark link-opacity-50-hover">会員ログインはこちら→</a>
        @else
            <a href="{{ route('admin.login') }}" class="d-flex justify-content-center link-dark link-opacity-50-hover">管理者ログインはこちら→</a>
        @endif
    </div>
    <p class="text-center copyright">&copy;NAGOYAMESHI All right reserved.</p>
</div>