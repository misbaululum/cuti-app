@props(['title' => config('app.name', 'Laravel'), 'titlePage' => ''])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />
    @stack('css')
    @vite(['resources/js/vendor/jquery.js', 'resources/js/app.js', 'resources/css/app.css'])
    @stack('jsModule')
</head>

<body>
    <div id="app">
        <div class="shadow-header"></div>
        @include('layouts.header')
        @include('layouts.sidebar')        
        <div class="main-content">
            <div class="title">
                {{ $titlePage }}
            </div>
            <div class="content-wrapper">

                {{ $slot }}
                
            </div>
        </div>

        <div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="modalActionLabel" aria-hidden="true"></div>
        <div class="modal fade" id="modalSearch" tabindex="-1" aria-labelledby="modalSearchLabel" aria-hidden="true"></div>

        @include('layouts.settings')

        <footer>
            Copyright © 2024 &nbsp <a href="#" target="_blank" class="ml-1"> CutiApp </a> <span> . All rights Reserved</span>
        </footer>
        <div class="overlay action-toggle">
        </div>
    </div>

    @stack('js')
</body>

</html>