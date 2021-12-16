@php
    // Products list
    if (!isset($products))
        $products = [];

    // Handle the action
    if (!isset($action_url))
        $action_url = '';

    // Handle the title
    if (!isset($find_by_title))
        $find_by_title = '';

    // Handle the menu
    if (!isset($active_search))
        $active_search = '';

    $menu_by_name = '';
    $menu_by_barcode = '';
    $menu_by_id = '';

    if ($find_by_title === 'Id')
        $menu_by_id = 'is-active';

    if ($find_by_title === 'Barcode')
        $menu_by_barcode = 'is-active';

    if ($find_by_title === 'Name')
        $menu_by_name = 'is-active';

    // Handles any page flash message
    $flash_show = false;
    $flash_class = '';
    $flash_content = '';

    if (isset($message)) {
        $flash_show = true;
        $flash_content = $message->content;

        switch ($message->type) {
            case 0:
                $flash_class = 'is-info';
                break;
            case 1:
                $flash_class = 'is-success';
                break;
             case 2:
                $flash_class = 'is-warning';
                break;
            case 3:
                $flash_class = 'is-danger';
                break;
        }
    }
@endphp

@extends('layouts.master')

@section('title', 'Pantry | Find Product')

@section('content')
    <h1 class="title pt-2">Find Product by {{ $find_by_title }}</h1>

    <img src="/img/find.png">

    <div class="columns pt-3">
        <div class="column is-2">
            @include('layouts.product.menu', ['active' => $find_by_title])
        </div>
        <div class="column is-offset-1">
            @if ($flash_show)
                <div class="notification {{ $flash_class }}">
                    <button class="delete"></button>
                    {{ $flash_content }}
                </div>
            @endif

            <form action="{{ $action_url }}" method="post" class="pb-6">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="field has-addons">
                    <p class="control is-expanded">
                        <input id="search-value" name="search-value" class="input" type="text" placeholder="Enter Search Criteria">
                    </p>
                    <p class="control">
                        <input type="submit"  class="button is-info" value="Search">
                    </p>
                </div>
            </form>

            @include('layouts.product.product_table', ['products' => $products])
        </div>
        <div class="column is-3"></div>
    </div>
@endsection
