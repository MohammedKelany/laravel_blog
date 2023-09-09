@extends('layout.layout')

@section('content')
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : '' }}" class="img-thumbnail avatar w-75" />
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>
            @include('comments._user_form')
            @forelse ($user->comment as $comment)
                <h5>{{ $comment->content }}</h5>
                <p class="text-muted">{{ __('Added') }} {{ $comment->created_at->diffForHumans() }} {{ __('by') }}
                    {{ $comment->user->name }}</p>
            @empty
                <p>{{ trans_choice('messages.comments', 0) }}</p>
            @endforelse
        </div>
    </div>
@endsection
