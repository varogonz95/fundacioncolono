@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/expedientes/MainController.js') }}"></script>
    <script src="{{ asset('app/controllers/expedientes/IndexController.js') }}"></script>
    <script src="{{ asset('app/controllers/expedientes/EditController.js') }}"></script>
    <script src="{{ asset('app/controllers/personas/EditController.js') }}"></script>
@endpush

@push('scripts_bottom')
    <script src="{{ asset('js/animatedModal/animatedModal.js') }}"></script>
@endpush

@section('controller', 'Expedientes')

@section('content')

    @if (Session::has('status'))
        <div class="alert alert-{{ Session::get('status')['type'] }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{ Session::get('status')['title'] }}</strong> {{ Session::get('status')['msg'] }}
        </div>
    @endif

    <section id="expedientes" class="col-md-10 col-md-offset-1" ng-controller="Expedientes_IndexController">

        <!-- MODAL PARA MOSTRAR EL DETALLE DE CADA CASO -->
        <!-- IMPLEMENTACION DEL COMPONENTE 'animatedModal' -->
        @include('expediente.$overview')
        
        <!-- COLUMNAS VISIBLES -->
        <nav class="navbar navbar-default navbar-sm col-md-8 col-md-offset-2" role="navigation">
            <span class="navbar-text"><b>Columnas visibles</b></span>
            <div class="navbar-form" style="padding-top:4px">
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.cedula">Cédula</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.nombre">Nombre</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.apellidos">Apellidos</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.referente">Referente</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.estado">Estado</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.prioridad">Prioridad</label>
            </div>
        </nav>
        
        <!-- BUSQUEDA -->
        <div class="col-lg-12">
            <div class="row col-lg-4 col-lg-offset-3">
                <form ng-submit="index(1,{search: search})">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Búsqueda..." ng-model="search" ng-change="index(1,{search:search})"/>
                        <span class="glyphicon glyphicon-search form-control-feedback" style="color:#aaa"></span>
                    </div>
                     {{-- <p class="help-block">
                        <span class="glyphicon glyphicon-info-sign text-info"></span>
                        <small>
                            <strong>Mensaje del desarrollador: </strong>
                            Por ahora sólo se pueden buscar casos por la cédula de la persona
                        </small>
                    </p> --}}
                </form>
            </div>
        
            <div class="col-lg-2 row">
                <button class="btn-outline btn-rest btn-none" style="margin: 0 4px">
                    <span class="glyphicon glyphicon-filter"></span> Filtrar
                </button>
            </div>

            <!-- LINK AGREGAR NUEVO CASO -->
            <div class="col-lg-2 text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('expedientes.create') }}">Agregar nuevo caso</a>
            </div>
        </div>

        <!-- TABLA DE CASOS -->
        <div class="table-responsive col-md-12">
            <table id="expedientesindex" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th ng-show="columns.cedula"><button type="button" class="btn btn-table-header @{{ sort.order? 'asc' : 'desc' }}" {{-- title="Ordenamiento @{{ sort.order? 'ascendente' : 'descendente'}}"--}} ng-click="doSort('cedula')">Cédula <span class="glyphicon @{{ sort.by === 'cedula'? 'glyphicon-menu-down' : '' }}"></span></button></th>
                        <th ng-show="columns.nombre">Nombre</th>
                        <th ng-show="columns.apellidos">Apellidos</th>
                        <th ng-show="columns.referente">Referente</th>
                        <th ng-show="columns.estado">Estado</th>
                        <th ng-show="columns.prioridad"><button type="button" class="btn btn-table-header @{{ sort.order? 'asc' : 'desc' }}" {{-- title="Ordenamiento @{{ sort.order? 'ascendente' : 'descendente'}}"--}} ng-click="doSort('prioridad')">Prioridad<span class="glyphicon @{{ sort.by === 'prioridad'? 'glyphicon-menu-down' : '' }}"></span></button></th>
                        {{-- <th>Tipo de Ayuda</th>
                        <th>Teléfono(s)</th>
                        <th>Zona</th>
                        <th>Dirección</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr class="@{{ (e.isSelected)? 'active' : '' }}" ng-repeat="e in expedientes" ng-click="show(e)" ng-cloak>
                        <td ng-show="columns.cedula">@{{ e.persona.cedula }}</td>
                        <td ng-show="columns.nombre">@{{ e.persona.nombre }}</td>
                        <td ng-show="columns.apellidos">@{{ e.persona.apellidos }}</td>
                        <!-- POST RENDERIZADO DE FILA PARA REFERENTES -->
                        <td ng-show="columns.referente" ng-if="e.referente.id === 1 && e.referente_otro">@{{ e.referente_otro }}</td>
                        <td ng-show="columns.referente" ng-if="!e.referente_otro && e.referente.id === 1">Ninguno</td>
                        <td ng-show="columns.referente" ng-if="e.referente.id !== 1">
                            <span class="text-primary glyphicon glyphicon-file"></span> @{{ e.referente.descripcion }}
                        </td>
                        <!-- ------------------------------------------ -->
                        <td ng-show="columns.estado">
                            {{-- <span class="status status-@{{ (e.estado === 0)? 'default' : (e.estado === 1)? 'approbed' : (e.estado === 2)? 'not-approbed' : (e.estado === 3)? 'pending' : '' }}"></span> --}}
                            <span class="label label-@{{ (e.estado === 0)? 'info' : (e.estado === 1)? 'success' : (e.estado === 2)? 'danger' : (e.estado === 3)? 'warning' : ''}}">
                                @{{
                                    (e.estado === 0)? 'En valoración' :
                                    (e.estado === 1)? 'Aprobado' :
                                    (e.estado === 2)? 'No aprobado' :
                                    (e.estado === 3)? 'Pendiente' : ''
                                }}
                            </span>
                        </td>
                        <td ng-show="columns.prioridad">
                            {{-- <span class="status priority-@{{ (e.prioridad === 1)? 'low' : (e.prioridad === 2)? 'mid' : (e.prioridad === 3)? 'hi' : '' }}"></span> --}}
                            <span class="label label-@{{ (e.prioridad === 1)? 'success' : (e.prioridad === 2)? 'warning' : (e.prioridad === 3)? 'danger' : '' }}">@{{ (e.prioridad === 1)? 'Baja' : (e.prioridad === 2)? 'Media' : (e.prioridad === 3)? 'Alta' : '' }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <h1 class="text-center" ng-show="expedientes.length === 0">Cargando casos...</h1> -->
        </div>

        <div class="text-center col-md-12">
            <ul uib-pagination total-items="total" class="pagination-sm" ng-model="page" items-per-page="16" ng-change="index(page)"></ul>
        </div>
    </section>
@endsection