    <a href="{{ route('posts.show', ['post' => $post->id]) }}" style="text-decoration: none;">
        <h2 class="text-primary">{{ $post->title }}</h2>
    </a>
    <p>Added {{ $post->created_at->diffForHumans() }} {{ __('by') }} <a
            href="{{ route('users.show', ['user' => $post->user]) }}">{{ $post->user->name }}</a>
    </p>

    @include('components.tags')

    <h5>{{ trans_choice('messages.comments', ['count' => $post->comment_count]) }}</h5>
    @auth
        @can('update', $post)
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">{{ __('Edit') }}</a>
        @endcan
    @endauth
    @auth
        @if (!$post->trashed())
            @can('delete', $post)
                <form class="d-inline " action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-primary" type="submit" name="Delete" value="{{ __('Delete!') }}">
                </form>
            @endcan
        @endif
    @endauth
