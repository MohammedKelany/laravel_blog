@extends('layout.layout')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-8">
            @if ($post->image)
                <div
                    style="background-attachment: fixed;background-repeat:no-repeat;background-size:cover;background-image: url({{ $post->image->url() }});min-height:500px;color:white;text-align:center;padding-top:100px;">
                    <h1 style="text-shadow: 1px 2px #000;">{{ $post->title }}</h1>
                </div>
            @else
                <h1>{{ $post->title }}</h1>
            @endif

            <h3 class="py-3">{{ $post->content }}</h3>
            <h6>{{ __('Added') }} {{ $post->created_at->diffForHumans() }}</h6>
            @if (now()->diffInMinutes($post->created_at) < 5)
                <div class="alert alert-primary">
                    {{ __('Brand new Post!') }}
                </div>
            @endif
            <p>
                @foreach ($post->tags as $tag)
                    <a href="#" class="badge bg-success text-decoration-none fs-6">{{ $tag->name }}</a>
                @endforeach
            </p>
            <h3 class="py-4">{{ __('Add comment') }}</h3>
            @auth
                @include('comments._form')
            @else
                <a href="{{ route('login') }}">Login To be able to create comments</a>
            @endauth
            @forelse ($post->comment as $comment)
                <h5>{{ $comment->content }}</h5>
                <p class="text-muted">added {{ $comment->created_at->diffForHumans() }} {{ __('by') }}
                    <a href="{{ route('users.show', ['user' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                </p>
            @empty
                <p>There are no comments</p>
            @endforelse
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
