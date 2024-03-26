<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/RutasdeBotones.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colores-tabla.css') }}">

    @extends('layouts.app2')

@section('content')
    <div id="app">
    <tablaven-component></tablaven-component>
    </div>
@endsection

</body>

</html>
