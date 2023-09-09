<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog Posts</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="p-3 mb-3 shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <h3 class="d-flex">
                <a href="{{ route('home.index') }}" class="text-black text-decoration-none">Laravel Blog</a>
            </h3>
            <nav class="nav justify-content-center d-flex ">
                <a href="{{ route('home.index') }} " class="nav-link">{{ __('Home') }}</a>
                <a href="{{ route('home.contact') }}" class="nav-link">{{ __('Contact') }}</a>
                <a href="{{ route('posts.index') }}" class="nav-link">{{ __('Blog Posts') }}</a>
                <a href="{{ route('posts.create') }}" class="nav-link">{{ __('Add') }}</a>
                @guest
                    <a href="{{ route('login') }}" class="nav-link">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link">{{ __('Register') }}</a>
                    @endif
                @else
                    <a href="{{ route('users.show', ['user' => Auth::user()]) }}" class="nav-link">{{ __('Profile') }}</a>
                    <a href="{{ route('users.edit', ['user' => Auth::user()]) }}"
                        class="nav-link">{{ __('Edit Profile') }}</a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit()"
                        class="nav-link">{{ __('Logout') }}({{ Auth::user() ? Auth::user()->name : '' }})</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="post">
                        @csrf
                    </form>
                @endguest
            </nav>
        </div>
    </div>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>

</html>
