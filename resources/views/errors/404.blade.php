<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('404.css') }}" rel="stylesheet" />

    <title>404 - Página no encontrada</title>
    @extends('layouts.index')

</head>
<body>
    <div class="center">
        <!--<img src="{{ asset('img/brand/404.png') }}" />-->
    </div>
</body>
@section('content')

</html>

@endsection

<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('{{ asset("img/brand/error404.gif") }}');
            background-position: center;
            background-repeat: no-repeat;
        }
        .center {
            text-align: center;
            color: white;
        }
        .center img {
            max-width: 100%;
            height: auto;
        }
        h1 {
            color: #dc3545;
        }
    </style>
