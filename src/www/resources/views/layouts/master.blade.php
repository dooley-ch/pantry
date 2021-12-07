<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>

        @include('layouts.shared.head')
    </head>
    <body>
        <header>
            @include('layouts.shared.header')
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            @include('layouts.shared.footer')
        </footer>
    </body>
</html>
