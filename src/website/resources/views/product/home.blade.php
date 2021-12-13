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

    <div class="columns">
        <div class="column is-2">
            <aside class="menu box">
                <p class="menu-label">
                    Find Product
                </p>
                <ul class="menu-list">
                    <li><a href="{{ route('product-find-by-id') }}">By Name</a></li>
                    <li><a href="{{ route('product-find-by-barcode') }}">By Barcode</a></li>
                    <li><a href="{{ route('product-find-by-name') }}">By Id</a></li>
                </ul>
            </aside>
        </div>
        <div class="column">
            @if ($flash_show)
                <div class="notification {{ $flash_class }}">
                    <button class="delete"></button>
                    {{ $flash_content }}
                </div>
            @endif

            <nav class="pagination" role="navigation" aria-label="pagination">
                <a class="pagination-previous is-hidden">Previous</a>
                <a class="pagination-next" href="{{ route('product-home', 'B') }}">Next page</a>
                <ul class="pagination-list">
                    <li>
                        <a class="pagination-link is-current" aria-label="Goto page A" href="{{ route('product-home', 'A') }}">A</a>
                    </li>
                    <li>
                        <a class="pagination-link" aria-label="Goto page B" href="{{ route('product-home', 'B') }}">B</a>
                    </li>
                    <li>
                        <a class="pagination-link" aria-label="Goto page C" href="{{ route('product-home', 'C') }}">C</a>
                    </li>

                    <li>
                        <span class="pagination-ellipsis">&hellip;</span>
                    </li>
                    <li>
                        <a class="pagination-link" aria-label="Goto page Z" href="{{ route('product-home', 'Z') }}">Z</a>
                    </li>
                    <li>
                        <a class="pagination-link" aria-label="Goto page 0" href="{{ route('product-home', '0') }}">0</a>
                    </li>

                    <li>
                        <span class="pagination-ellipsis">&hellip;</span>
                    </li>
                    <li>
                        <a class="pagination-link" aria-label="Goto page 9" href="{{ route('product-home', '9') }}">9</a>
                    </li>
                </ul>
            </nav>

            <div class="table-container">
                <table class="table is-bordered is-striped is-fullwidth">
                    <thead>
                        <th>Id</th>
                        <th>Barcode</th>
                        <th>Name</th>
                        <th>Updated</th>
                        <th>Amount</th>
                        <th>
                        </th>
                    </thead>
                    <tfoot>
                        <td colspan="6">
                            <div class="buttons is-right">
                                <a class="button is-success" href="{{ route('lookup-homepage') }}">
                                    <span class="icon">
                                        <i class="las la-plus-circle la-lg"></i>
                                    </span>
                                    <span>Add Product</span>
                                </a>
                            </div>
                        </td>
                    </tfoot>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->getId() }}</td>
                            <td>{{ $product->getBarcode() }}</td>
                            <td>{{ $product->getName() }}</td>
                            <td>{{ $product->getUpdatedAt() }}</td>
                            <td>{{ $product->getAmount() }}</td>
                            <td>
                                <div class="buttons is-centered">
                                    <a class="button is-info" href="{{ route('product-detail', $product->getId()) }}">
                                        <span class="icon">
                                            <i class="las la-pen la-lg"></i>
                                        </span>
                                    </a>
                                    <a class="button is-danger" href="{{ route('product-delete', $product->getId()) }}">
                                        <span class="icon">
                                            <i class="las la-trash la-lg"></i>
                                        </span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
