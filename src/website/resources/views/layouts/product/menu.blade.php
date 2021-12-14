@php
    if (!isset($active))
        $active = '';

    $menu_by_name = '';
    $menu_by_barcode = '';
    $menu_by_id = '';

    if ($active === 'Id')
        $menu_by_id = 'is-active';

    if ($active === 'Barcode')
        $menu_by_barcode = 'is-active';

    if ($active === 'Name')
        $menu_by_name = 'is-active';
@endphp

<aside class="menu box">
    <p class="menu-label">
        Find Product
    </p>
    <ul class="menu-list">
        <li><a class="{{ $menu_by_name }}" href="{{ route('product-find-by-name') }}">By Name</a></li>
        <li><a class="{{ $menu_by_barcode }}" href="{{ route('product-find-by-barcode') }}">By Barcode</a></li>
        <li><a class="{{ $menu_by_id }}" href="{{ route('product-find-by-id') }}">By Id</a></li>
    </ul>
</aside>
