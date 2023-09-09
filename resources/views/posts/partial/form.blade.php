<div class="form-group mb-3">
    <label for="title">{{ __('Title') }}</label>
    <input id="title" class="form-control" type="text" name="title"
        value="{{ isset($post->id) ? $post->title : @old('title') }}">
    @error('title')
        <div class="alert alert-danger my-3"> {{ $message }} </div>
    @enderror
</div>
<div class="form-group">
    <label for="content">{{ __('Content') }}</label>
    <textarea id="content" class="form-control" name="content" cols="30" rows="10">{{ isset($post->id) ? $post->content : @old('content') }}</textarea>
    @error('content')
        <div class="alert alert-danger my-3"> {{ $message }} </div>
    @enderror
</div>

<div class="form-group my-3">
    <label for="thumbnail">{{ __('Thumbnail') }}</label>
    <input id="thumbnail" class="form-control-file" type="file" name="thumbnail">
    @error('thumbnail')
        <div class="alert alert-danger my-3"> {{ $message }} </div>
    @enderror
</div>

@if ($errors->any())
    <ul class="list-group">
        @foreach ($errors->all() as $error)
            <li class=" list-group-item list-group-item-danger ">{{ $error }}</li>
        @endforeach
    </ul>
@endif
