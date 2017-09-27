@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/ExpedientesController.js') }}"></script>
@endpush

@push('scripts_bottom')
    <script src="{{ asset('js/animatedModal/animatedModal.js') }}"></script>
@endpush

@section('content')

    @if (Session::has('status'))
        <div class="alert alert-{{ Session::get('status')['type'] }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{ Session::get('status')['title'] }}</strong> {{ Session::get('status')['msg'] }}
        </div>
    @endif

    <section id="expedientes" class="col-md-8 col-md-offset-2" ng-controller="ExpedientesController">

        @include('templates.show')

        <nav class="navbar navbar-default navbar-sm col-md-8 col-md-offset-2" role="navigation">
            <span class="navbar-text"><b>Columnas visibles</b></span>
            <div class="navbar-form" style="padding-top:4px">
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.cedula">Cédula</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.nombre">Nombre</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.apellidos">Apellidos</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.referente">Referente</label>
            </div>
        </nav>

        <div class="col-lg-12 controls">

            <div class="col-lg-4 col-lg-offset-4">
                <form ng-submit="index(1,{search: search})">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Búsqueda..." ng-model="search" ng-change="index(1,{search:search})"/>
                        <span class="glyphicon glyphicon-search form-control-feedback" style="color:#aaa"></span>
                    </div>
                </form>
            </div>

            <div class="text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('expedientes.create') }}">Agregar nuevo caso</a>
            </div>
        </div>

        <div class="table-responsive col-md-12">
            <table id="expedientesindex" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th ng-show="columns.cedula">Cédula</th>
                        <th ng-show="columns.nombre">Nombre</th>
                        <th ng-show="columns.apellidos">Apellidos</th>
                        <th ng-show="columns.referente">Referente</th>
                        {{-- <th>Tipo de Ayuda</th>
                        <th>Prioridad</th>
                        <th>Ocupación</th>
                        <th>Teléfono(s)</th>
                        <th>Zona</th>
                        <th>Dirección</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr class="@{{ (e.isSelected)? 'active' : '' }}" ng-repeat="e in expedientes"ng-click="show(e)" ng-cloak>
                        <td ng-show="columns.cedula">@{{ e.persona.cedula }}</td>
                        <td ng-show="columns.nombre">@{{ e.persona.nombre }}</td>
                        <td ng-show="columns.apellidos">@{{ e.persona.apellidos }}</td>
                        <td ng-show="columns.referente" ng-if="e.referente.id === 1 && e.referente_otro">@{{ e.referente_otro }}</td>
                        <td ng-show="columns.referente" ng-if="!e.referente_otro && e.referente.id === 1">Ninguno</td>
                        <td ng-show="columns.referente" ng-if="e.referente.id !== 1">
                            <span class="text-primary">@{{ e.referente.descripcion }}</span>
                            {{--<a href="#">@{{ e.referente.descripcion }}</a>--}}
                        </td>
                    </tr>
                    {{-- @foreach ($expedientes as $e) --}}
                        {{-- <tr>
                            <td>{{ $e->persona->cedula }}</td>
                            <td>{{ $e->persona->nombre }}</td>
                            <td>{{ $e->persona->apellidos }}</td> --}}
                            {{-- <td>{{ $e->persona->cedula }}</td> --}}
                            {{-- @if ($e->referente->id === 1) --}}
                                {{-- <td>{{ $e->referente_otro }}</td> --}}
                            {{-- @else --}}
                                {{-- <td><a href="#">{{ $e->referente->descripcion }}</a></td> --}}
                            {{-- @endif --}}
                        {{-- </tr> --}}
                    {{-- @endforeach --}}
                </tbody>
            </table>
            <h1 class="text-center" ng-show="expedientes.length === 0">Cargando casos...</h1>
        </div>

        <div class="text-center col-md-12">
            <ul uib-pagination total-items="total" class="pagination-sm" ng-model="page" items-per-page="16" ng-change="index(page)"></ul>
            {{-- $expedientes->links() --}}
        </div>
    </section>
@endsection
