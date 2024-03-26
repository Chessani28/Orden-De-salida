<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/colores-tabla.css') }}">

    <title>Document</title>
    @extends('layouts.app')
</head>
<body>

    @section('content')

    <div id="app">
    <verificacion-component></verificacion-component>
    </div>

    @endsection

</body>
</html>
