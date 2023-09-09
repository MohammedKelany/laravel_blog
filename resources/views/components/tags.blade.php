<p>
    @foreach ($post->tags as $tag)
        <a href="{{ route('posts.tags.index', ['id' => $tag->id]) }}"
            class="badge bg-success text-decoration-none fs-6">{{ $tag->name }}</a>
    @endforeach
</p>
