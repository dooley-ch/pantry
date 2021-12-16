@php
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

@section('title', 'Pantry | Product')

@section('content')
    <h1 class="title pt-2">Product</h1>

    <img src="/img/product.png">

    <div class="columns pt-3">
        <div class="column is-2">
            @include('layouts.product.menu')
        </div>
        <div class="column">
            @if ($flash_show)
                <div class="notification {{ $flash_class }}">
                    <button class="delete"></button>
                    {{ $flash_content }}
                </div>
            @endif

            <nav class="pagination" role="navigation" aria-label="pagination">
                <a class="pagination-next" href="{{ route('lookup-homepage') }}">
                    <span class="icon">
                        <i class="las la-plus-circle la-lg"></i>
                    </span>
                    <span>Add Product</span>
                </a>
                <ul class="pagination-list">
                    @foreach($letters as $letter )
                        @if($letter == $current_letter)
                            <li>
                                <a class="pagination-link is-current" aria-label="Goto page A" href="{{ route('product-home', $letter) }}">
                                    {{ $letter }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="pagination-link" aria-label="Goto page A" href="{{ route('product-home', $letter) }}">
                                    {{ $letter }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
            @include('layouts.product.product_table', ['products' => $products])
        </div>
    </div>
@endsection
