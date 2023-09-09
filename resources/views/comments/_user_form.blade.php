<form action="{{ route('users.comments.store', ['user' => $user->id]) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="content">{{ __('Content') }}</label>
        <textarea id="content" class="form-control" name="content" cols="20" rows="10">{{ @old('content') }}</textarea>
        @error('content')
            <div class="alert alert-danger my-3"> {{ $message }} </div>
        @enderror
    </div>
    <div class="d-grid">
        <input class="p-3 mt-3 mb-4 btn btn-lg btn-primary" type="submit" name="Create"
            value="{{ __('Add comment') }}">
    </div>
</form>
