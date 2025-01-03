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

@else
    <p>You are not logged in :(</p>
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
@endauth

<x-nav-link></x-nav-link>
{{$slot}}

</body>
