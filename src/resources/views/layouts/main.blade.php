<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">

    <script src="{{asset('js/angularjs/angular.1.6.4.min.js')}}"></script>
    <script src="{{asset('js/angularjs/angular-route.1.6.4.min.js')}}"></script>
    <script src="{{asset('js/angularjs/angular-sanitize.1.6.4.min.js')}}"></script>
    <script src="{{asset('js/angularjs-ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js')}}"></script>
    <script src="{{asset('app/app.js')}}"></script>
    @stack('scripts_top')

    <title>{{ config('app.name') }}</title>
</head>
<body>

    @include('partials._navbar')

    <main class="container-fluid" style="padding-top:50px" ng-app="App">
        <section class="row" style="padding: 1em 0">
            @yield('content')
        </section>
    </main>


     <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    @stack('scripts_bottom')
</body>
</html>
