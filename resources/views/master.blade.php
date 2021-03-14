<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Google Vision API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <script type="text/javascript" src="{{ mix('js/cropper.min.js') }}"></script>

        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container-wrapper">
            @include('layouts.header')

            <div id="app">
                @yield('content-wrapper')
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
