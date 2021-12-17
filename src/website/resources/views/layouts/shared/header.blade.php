@php
    if (!isset($active_page)) {
        $active_page = 'home';
    }

    if (!isset($logged_in)) {
        $logged_in = false;
    }

    $home_is_active = '';
    $product_is_active = '';
    $lockup_is_active = '';
    $user_is_active = '';
    $reports_is_active = '';
    $setup_is_active = '';
    $usage_is_active = '';
    $about_is_active = '';

    if ($active_page === 'home')
        $home_is_active = 'is-active';

    if ($active_page === 'product')
        $product_is_active = 'is-active';

    if ($active_page === 'lookup')
        $lockup_is_active = 'is-active';

    if ($active_page === 'user')
        $user_is_active = 'is-active';

    if ($active_page === 'reports')
        $reports_is_active = 'is-active';

    if ($active_page === 'usage')
        $usage_is_active = 'is-active';

    if ($active_page === 'about')
        $about_is_active = 'is-active';

    if ($active_page === 'setup')
        $setup_is_active = 'is-active';
@endphp

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}">
            <img src="/img/logo.png" width="112" height="28">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item {{ $home_is_active }}" href="{{ route('home') }}">
                Home
            </a>

            <a class="navbar-item {{ $product_is_active }}" href="{{ route('product-home') }}">
                Product
            </a>

            <a class="navbar-item {{ $lockup_is_active }}" href="{{ route('lookup-homepage') }}">
                Look Up
            </a>

            <a class="navbar-item {{ $user_is_active }}" href="{{ route('user-home') }}">
                User
            </a>

            <a class="navbar-item {{ $reports_is_active }}" href="{{ route('reports-home') }}">
                Stock Report
            </a>

            <a class="navbar-item {{ $usage_is_active }}" href="{{ route('usage') }}">
                Site Usage
            </a>

            <a class="navbar-item {{ $about_is_active }}" href="{{ route('about') }}">
                About
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-success">
                        <span class="icon">
                            <i class="las la-key la-lg"></i>
                        </span>
                        <span>Log in</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
