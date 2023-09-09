@extends('layout.layout')

@section('title', 'Laravel - Blog Posts')

@section('content')
    <div class="row">
        <div class="col-8">
            @foreach ($posts as $post)
                <div class="mb-3">
                    @include('posts.partial.post')
                </div>
            @endforeach
        </div>
        <div class="col-4 ">
            <div class="card mb-4" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Most Commented') }}</h5>
                    <p class="card-subtitle mb-2 text-muted">{{ __('What people are currently talking about') }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($mostCommented as $post)
                        <li class="list-group-item">
                            <a class="text-decoration-none fw-bold"
                                href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card mb-4" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Most Active') }}</h5>
                    <p class="card-subtitle mb-2 text-muted">{{ __('Writers with most posts written') }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($mostActive as $user)
                        <li class="list-group-item">
                            {{ $user->name }} {{ $user->blog_posts_count }} {{ __('Blog Posts') }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card mb-4" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Most Active Last Month') }}</h5>
                    <p class="card-subtitle mb-2 text-muted">{{ __('Users with most posts written in the month') }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($mostActiveThisMonth as $user)
                        <li class="list-group-item">
                            {{ $user->name }} {{ $user->blog_posts_count }} {{ __('Blog Posts') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
