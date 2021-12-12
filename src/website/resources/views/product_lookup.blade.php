@php
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
        </div>
        <div class="column is-one-fifth"></div>
    </div>
@endsection
