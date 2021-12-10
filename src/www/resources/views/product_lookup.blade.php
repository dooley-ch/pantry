@extends('layouts.master')

@section('title', 'Pantry | Home')

@section('content')
    <h1 class="title pt-2">Product Lookup</h1>

    <div class="columns">
        <div class="column"></div>
        <div class="column">
            <form action="{{ route('lookup-search') }}" method="post">
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
        <div class="column"></div>
    </div>
@endsection
