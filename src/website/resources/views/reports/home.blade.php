@extends('layouts.master')

@section('title', 'Pantry | Reports')

@section('content')
    <div class="columns pt-2">
        <div class="column is-narrow">
            <img src="/img/reports.png">
        </div>
        <div class="column">
            <h1 class="title pb-3">Stock Report</h1>

            <table class="table is-striped is-fullwidth">
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Updated</th>
                    <th>Amount</th>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="4">
                        </th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record->getId() }}</td>
                        <td>{{ $record->getName() }}</td>
                        <td>{{ $record->getUpdatedAt() }}</td>
                        <td>{{ $record->getAmount() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
