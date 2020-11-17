<html>
    <head>
        <title>Painel - @yield('title')</title>
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
    </head>
    <body>

        @include('panel.components.navbar')

        <div class="container-sm">
            @yield('content')
        </div>

        <script src="/lib/jquery-3.4.1.slim.min.js"></script>
        <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
