@php
    if (!isset($products))
        $products = [];
@endphp

@if (count($products) > 0)
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
@endif
