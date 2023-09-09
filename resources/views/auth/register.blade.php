@extends('layout.layout')

@section('title', 'register')

@section('content')
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">username</label>
            <input id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                name="name" value="{{ @old('name') }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="email">email</label>
            <input id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                name="email" value="{{ @old('email') }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="password">password</label>
            <input id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                name="password">
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">password-confirmation</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation">
        </div>
        <div class="d-grid">
            <input class=" mt-3 btn btn-lg btn-primary" type="submit" name="Register" value="Register">
        </div>
    </form>
@endsection
