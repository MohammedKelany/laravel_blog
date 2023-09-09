<style>
    body {
        font-family: Arial, Helvetica, sans-serif
    }
</style>

<p>Hi {{ $comment->user->name }}</p>

<p>
    Someone one has commented on your blog post
    <a href="{{ route('posts.show', ['post' => $comment->commentable->id]) }}">
        {{ $comment->user->name }}
    </a>
</p>

<p>
    That Someone is
    <a href="{{ route('users.show', ['user' => $comment->user->id]) }}">
        {{ $comment->user->name }}
    </a>
</p>
