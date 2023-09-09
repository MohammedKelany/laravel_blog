@extends('layout.layout')

@section('title', 'Laravel - Create Post')

@section('content')
    <div>
        <form action="{{ route('posts.update', ['post' => $post]) }}" method="POST">
            @csrf
            @method('PUT')
            @include('posts.partial.form')
            <div class="d-grid">
                <input class="p-3 mt-3 btn btn-lg btn-primary" type="submit" name="Update" value="{{ __('Update!') }}">
            </div>
        </form>
    </div>
@endsection
