<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="../../favicon.ico">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.min.js" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.min.js" charset="utf-8"></script>
    -->

    <link rel="stylesheet" href="{{asset('assets/bootstrap3/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">

    <script src="{{asset('libs/angularjs/angular.1.6.4.min.js')}}"></script>
    <script src="{{asset('libs/angularjs/angular-route.1.6.4.min.js')}}"></script>
    <script src="{{asset('libs/angularjs/angular-sanitize.1.6.4.min.js')}}"></script>
    <script src="{{asset('libs/angularjs-ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js')}}"></script>

    <script src="{{asset('app/app.js')}}"></script>
    <script src="{{asset('app/controllers/HistoricoController.js')}}"></script>

    <title>{{ config('app.name') }} | Histórico de expedientes</title>
</head>

<body class="container-fluid">


    <main class="row" ng-app="App" ng-controller="Main">



    </main>

    <!--
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    -->
    <script src="{{asset('libs/jquery/jquery3.2.1.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap3/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('libs/animatedModal/animatedModal.js')}}"></script>
    <script type="text/javascript"></script>
</body>
</html>
