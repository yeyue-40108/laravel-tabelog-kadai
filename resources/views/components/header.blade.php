<nav class="navbar navbar-expand shadow-sm header_container">
    <div class="container">
        @if (Auth::guard('admin')->check())
            <a class="navbar-brand" href="{{ route('admin.web.index') }}">NAGOYAMESHI</a>
        @else
            <a class="navbar-brand" href="{{ url('/') }}">NAGOYAMESHI</a>
        @endif
        <div class="d-flex justify-content-end">
            <ul class="navbar-nav">
                @if (Auth::guard('admin')->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('admin-logout-form').submit();">ログアウト</a>
                                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    @guest
                        @if (!Request::is('admin/*'))
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">会員登録</a>
                                </li>
                            @endif
                        @endif
                    @else
                        @if (auth()->user()->role === 'paid')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('mypage.favorite') }}">
                                    <i class="fa-solid fa-heart"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reservations.index') }}">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('mypage') }}">マイページ</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                @endif
            </ul>
        </div>
    </div>
</nav>