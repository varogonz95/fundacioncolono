<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

    <!-- Scripts top -->
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/angularjs/angular.1.6.4.min.js') }}"></script>
    <script src="{{ asset('js/angularjs/angular-animate.1.6.4.min.js') }}"></script>
    <script src="{{ asset('js/angularjs/angular-resource.1.6.4.js') }}"></script>
    <script src="{{ asset('js/angularjs-ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script src="{{ asset('app/app.js') }}"></script>
    <script src="{{ asset('app/providers.js') }}"></script>
    <script src="{{ asset('app/services.js') }}"></script>
    <script src="{{ asset('app/factory.js') }}"></script>
    @stack('scripts_top')

    <title>{{ config('app.name') }}</title>
</head>
<body>

    @include('partials._navbar')

    <main class="container-fluid" style="padding-top:50px" ng-app="App" ng-controller="@yield('controller')_MainController" ng-cloak>
        <div class="row" style="padding: 1em 0">
            @yield('content')
        </div>
    </main>


     <!-- Scripts Bottom -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap3.min.js') }}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
    @stack('scripts_bottom')
</body>
</html>
