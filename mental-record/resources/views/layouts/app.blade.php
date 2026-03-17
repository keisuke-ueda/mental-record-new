<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>


@include('components.header')

<body>

<div class="container">

@yield('content')

</div>

</body>
</html>