@php
    $show_message = false;

    if (isset($message)) {
        $show_message = true;
        $message_type = $message['type'];
        $message_content = $message['message'];
    }
@endphp

@extends('layouts.master')

@section('title', 'Pantry | Home')

@section('content')
    <p>Product Lookup</p>
@endsection
