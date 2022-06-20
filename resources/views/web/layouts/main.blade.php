<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- Bootstrap CSS -->
        @include('web.layouts.links')
        <title>Smart Auto Parts</title>
    </head>
    <body id="cms-body">
        <!-- Header Start -->
        <header>
            @include('web.layouts.header')
        </header>
        <!-- Header End -->
        <!-- welcome -->
        @yield('content')
        <footer>
            @include('web.layouts.footer')
        </footer>
        @include('web.layouts.scripts')
        @yield('js')
    </body>
</html>

