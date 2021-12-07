@php
    if (!isset($active_page)) {
        $active_page = 'home';
    }

    if (!isset($logged_in)) {
        $logged_in = false;
    }
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>

        @include('layouts.shared.head')
    </head>
    <body>
        <header>
            @include('layouts.shared.header', ['active_page' => $active_page, 'logged_in' => $logged_in])
        </header>

        <main>
            <section class="container">
                @yield('content')
            </section>
        </main>

        <footer>
            @include('layouts.shared.footer')
        </footer>
    </body>
</html>
