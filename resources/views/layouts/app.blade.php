<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/dfff6b3710.js" crossorigin="anonymous"></script>
        <!-- CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Noto+Sans+JP&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="app" class="wrapper">
            @component('components.header')
            @endcomponent

            <main class="py-4 mb-5">
                @yield('content')
                <a id="back_button" class="text-center" href="#">
                    <i class="fa-solid fa-angles-up fa-2x"></i>
                    <p>TOP</p>
                </a>
                <script>
                    const backBtn = document.getElementById('back_button');
                    window.addEventListener('scroll', () => {
                        const scrollValue = document.scrollingElement.scrollTop;

                        if (scrollValue >= 300) {
                            backBtn.style.display = 'inline';
                        } else {
                            backBtn.style.display = 'none';
                        }
                    });
                </script>
            </main>

            @component('components.footer')
            @endcomponent
        </div>
        
        @stack('scripts')
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
