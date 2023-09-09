@extends('layout.layout')

@section('title', 'Laravel - Create Post')

@section('content')
    <div>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('posts.partial.form')
            <div class="d-grid">
                <input class="p-3 mt-3 btn btn-lg btn-primary" type="submit" name="Create" value="{{ __('Create!') }}">
            </div>
        </form>
    </div>
@endsection
