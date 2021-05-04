<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @if(Request::is('admin') || Request::is('admin/*'))
            <link rel="stylesheet" href="/css/all.css">
        @else 
            <link rel="stylesheet" href="/css/front-all.css">
        @endif
        
        <script>
            (function (){
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                }
            })();
        </script>
    </head>
    <body>        
        <div id="app">
            @if(Request::is('admin') || Request::is('admin/*'))
                @if(Auth::check())
                    <adminapp :user="{{ Auth::user() }}"></adminapp>
                @else
                    <adminapp :user='false'></adminapp>
                @endif
            @else 
                <mainapp></mainapp>
            @endif
        </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
</html>
