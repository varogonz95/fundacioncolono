@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="page-header text-center col-md-8 col-md-offset-2">
          <h1>{{ config('app.name') }}</h1>
          <h4>Sistema de gestión</h4>
        </div>

        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Ingreso al sistema</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        @include('partials._usuario')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
