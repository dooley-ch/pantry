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

    // Handles the display of the product if found
    $show_product = false;

    if (isset($product)) {
        $show_product = true;
    }
@endphp

@extends('layouts.master')

@section('title', 'Pantry | Product Lookup')

@section('content')
    <h1 class="title pt-2">Product Lookup</h1>

    <div class="columns">
        <div class="column is-one-fifth"></div>
        <div class="column">
            @if ($flash_show)
            <div class="notification {{ $flash_class }}">
                <button class="delete"></button>
                {{ $flash_content }}
            </div>
            @endif

            <form action="{{ route('lookup-search') }}" method="post">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="field has-addons">
                    <p class="control">
                    <span class="select">
                      <select id="search-type" name="search-type">
                        <option>Code</option>
                        <option>Barcode</option>
                      </select>
                    </span>
                    </p>
                    <p class="control is-expanded">
                        <input id="search-value" name="search-value" class="input" type="text" placeholder="Enter Code/Barcode">
                    </p>
                    <p class="control">
                        <input type="submit"  class="button is-info" value="Search">
                    </p>
                </div>
            </form>

            @if ($show_product)
                <div class="content pb-6">
                    <!-- Padding -->
                </div>
                <div class="columns">
                    <div class="column is-2">
                    </div>
                    <div class="column box">
                        <div class="content">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Code</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" value="{{ $product->getId() }}" readonly>
                                        </p>
                                    </div>
                                    <div class="field-label is-normal">
                                        <label class="label">Barcode</label>
                                    </div>
                                    <div class="field is-expanded">
                                        <p class="control">
                                            <input class="input" type="text" value="{{ $product->getBarcode() }}" readonly>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Name</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control is-expanded">
                                            <input class="input" type="text" value="{{ $product->getName() }}" readonly>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Country:</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" value="{{ $product->getCountry() }}" readonly>
                                        </p>
                                    </div>
                                    <div class="field-label is-normal">
                                        <label class="label">Status</label>
                                    </div>
                                    <div class="field is-expanded">
                                        <p class="control">
                                            <input class="input" type="text" value="{{ $product->getStatus() }}" readonly>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if ($can_add)
                            <div class="field is-grouped">
                                <div class="control">
                                    <a class="button is-link is-success" href="{{ route('product-add', $product->getBarcode()) }}">Add Product</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="column is-2">
                    </div>
                </div>
            @endif

        </div>
        <div class="column is-one-fifth"></div>
    </div>
@endsection
