@extends('layout.layout')

@section('title', 'Home')

@section('content')
    <div class="container">
        <h1>
            {{ __('meseges.welcome') }}
        </h1>
        <h1>
            {{ trans_choice('meseges.comment', 0) }}
        </h1>
        <h1>
            {{ trans_choice('meseges.comment', 1) }}
        </h1>
        <h1>
            {{ trans_choice('meseges.comment', 2) }}
        </h1>
        <h1>
            From JSON: {{ __('Welcome To Laravel') }}
        </h1>
        <h1>
            From JSON: {{ __('Welcome :name', ['name' => 'Mohammed']) }}
        </h1>
    </div>
@endsection
