<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

@auth
    <p>You are logged in!</p>
    <a href="{{route('articles.index')}}">Articles</a>
    @if(auth()->user()->is_admin) <!-- Check if the user is an admin -->
    <a href="{{ route('articles.admin_index') }}">Manage Articles</a><!-- Link to admin articles -->
        <a href="{{route('categories.create')}}">Create Categories</a>
        <a href="{{route('articles.create')}}">Create Articles</a>
    @endif


    <!-- Logout Form -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>

@else
    <p>You are not logged in :(</p>
    <!-- Login Form -->
    <form action="{{ route('login') }}" method="GET" style="display: inline;">
        <button type="submit">Login</button>
    </form>

    <!-- Register Form -->
    <form action="{{ route('register') }}" method="GET" style="display: inline;">
        <button type="submit">Register</button>
    </form>
@endauth

<x-nav-link></x-nav-link>
{{$slot}}

</body>
