<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i" rel="stylesheet">
        <!-- <link href="/css/app.css" rel="stylesheet"/> -->

        <script>
         // We have to keep window.Laravel for now since Echo is being too clingy
         // with the namespace they want. :<
         window.Laravel = window.Slack = {!! json_encode([
           'team' => request()->route('team'),
           'csrfToken' => csrf_token(),
         ]) !!};
        </script>
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
