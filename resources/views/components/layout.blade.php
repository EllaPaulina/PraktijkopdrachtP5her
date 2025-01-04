<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <title>AniForm</title>
</head>
<body>
<nav class="main-nav">
    <div class="nav-left">
        <a href="{{route('articles.index')}}">Articles</a>
        <a href="{{route('home')}}">About Us</a>
        @auth

            @if(auth()->user()->is_admin) <!-- Check if the user is an admin -->
            <a href="{{ route('articles.admin_index') }}">Manage Articles</a>
            <a href="{{route('categories.create')}}">Create Categories</a>
            <a href="{{route('articles.create')}}">Create Articles</a>
            @endif
        @endauth
    </div>

    <div class="nav-right">
        @auth
            <!-- Logout Form -->
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <!-- Login Form -->
            <form action="{{ route('login') }}" method="GET" style="display: inline;">
                <button type="submit">Login</button>
            </form>

            <!-- Register Form -->
            <form action="{{ route('register') }}" method="GET" style="display: inline;">
                <button type="submit">Register</button>
            </form>
        @endauth
    </div>
</nav>
@auth
    <h4 class="welcome">Welcome, {{ auth()->user()->name }}!</h4>
@else
    <h4 class="welcome">Welcome, Visitor!</h4>
@endauth


<x-nav-link></x-nav-link>
{{$slot}}

</body>
</html>
