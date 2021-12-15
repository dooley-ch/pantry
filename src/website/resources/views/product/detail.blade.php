@php
    if (empty($product))
        $product = null;

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

    // Handle the product
    $thumb_images = [];
    $transactions = [];
    $final_balance = 0;
    $summary_id = 0;

    if ($product) {
        // Get the thumb image links
        foreach ($product->getProductImages() as $product_image) {
            foreach ($product_image->getImages() as $image) {
                if ($image->getImageType() == 'T') {
                    $thumb_images []= $image->getUrl();
                }
            }
        }

        // Get the transactions
        foreach ($product->getStockSummary()->getTransactions() as $transaction) {
            $item = new stdClass();

            $item->id = $transaction->getId();
            $item->created_at = $transaction->getCreatedAt();

            $item->in = '';
            $item->out = '';
            if ($transaction->getOperation() == 'A') {
                $final_balance += $transaction->getAmount();
                $item->in = strval($transaction->getAmount());
            } else {
                $final_balance -= $transaction->getAmount();
                $item->out = strval($transaction->getAmount());
            }

            $item->balance = strval($final_balance);

            $transactions []= $item;
        }

        // Summary ID
        $summary_id = $product->getStockSummary()->getId();
    }

@endphp

@extends('layouts.master')

@section('title', 'Pantry | Product Details')

@section('content')
    <h1 class="title pt-2 pb-1">Product Details</h1>

    <div class="columns">
        <div class="column is-2"></div>
        <div class="column">
            @if ($flash_show)
                <div class="notification {{ $flash_class }}">
                    <button class="delete"></button>
                    {{ $flash_content }}
                </div>
            @endif

            @if (isset($product))
            <div class="columns">
                <div class="column">
                    <!-- First Line -->
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
                            <div class="field">
                                <p class="control">
                                    <input class="input" type="text" value="{{ $product->getBarcode() }}" readonly>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Second Line -->
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

                    <!-- Third Line -->
                    <div class="field is-horizontal pb-2">
                        <div class="field-label is-normal">
                            <label class="label">Description</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded">
                                    <input class="input" type="text" value="{{ $product->getDescription() }}" readonly>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions -->
                    <div class="content box">
                        <p><strong>Transactions</strong></p>

                        <!-- Transaction Table -->
                        <table class="table is-striped is-fullwidth">
                            <thead>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Checked In</th>
                                <th>Checked Out</th>
                                <th>Balance</th>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="5">
                                        <p class="is-pulled-right">
                                            <span>Current Balance: {{ $final_balance }}</span>
                                        </p>
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($transactions as $trans)
                                <tr>
                                    <td>{{ $trans->id }}</td>
                                    <td>{{ $trans->created_at }}</td>
                                    <td>{{ $trans->in }}</td>
                                    <td>{{ $trans->out }}</td>
                                    <td>{{ $trans->balance }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div class="buttons is-right">
                        <a class="button is-success" href="{{ route('transactions-add', $summary_id) }}">
                            <span class="icon">
                                <i class="las la-plus-circle la-lg"></i>
                            </span>
                            <span>Add</span>
                        </a>
                        <a class="button is-warning" href="{{ route('transactions-remove', $summary_id) }}">
                            <span class="icon">
                                <i class="las la-minus-circle la-lg"></i>
                            </span>
                            <span>Remove</span>
                        </a>
                        <a class="button is-danger" href="{{ route('transactions-clear', $summary_id) }}">
                            <span class="icon">
                                <i class="las la-trash-alt la-lg"></i>
                            </span>
                            <span>Clear</span>
                        </a>
                    </div>
                </div>

                <div class="column is-narrow">
                    @foreach($thumb_images as $url)
                    <p class="pb-2">
                        <figure class="image is-96x96">
                            <img src="{{ $url  }}">
                        </figure>
                    </p>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="column is-2"></div>
    </div>
@endsection
