<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>9Laravel - a 9gag like website created in Laravel</title>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
</head>
<body>
    <div class="container-fluid">
        @include('includes.top-menu')
    </div>
    <div class="container page-container">
        <div class="col-sm-16 col-sm-offset-4">
            @yield('content')
        </div>
        <div class="col-sm-4">
            @include('includes.sidebar')
        </div>
    </div>
    @include('includes.modals')
    <script src="{{ elixir('js/scripts.min.js') }}"></script>
</body>
</html>