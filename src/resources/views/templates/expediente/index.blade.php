@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/ayudas/EditController.js') }}"></script>
    <script src="{{ asset('app/controllers/expedientes/MainController.js') }}"></script>
    <script src="{{ asset('app/controllers/expedientes/IndexController.js') }}"></script>
    <script src="{{ asset('app/controllers/expedientes/OverviewController.js') }}"></script>
    <script src="{{ asset('app/controllers/expedientes/EditController.js') }}"></script>
    <script src="{{ asset('app/controllers/personas/EditController.js') }}"></script>
@endpush

@push('scripts_bottom')
    <script src="{{ asset('js/animatedModal/animatedModal.js') }}"></script>
    @if (Session::has('status'))
        @include('partials._error_alert')
    @endif
@endpush

@section('controller', 'Expedientes')

@section('content')

    <section id="expedientes" class="col-md-10 col-md-offset-1" ng-controller="Expedientes_IndexController">

        <!-- MODAL PARA MOSTRAR EL DETALLE DE CADA CASO -->
        <!-- IMPLEMENTACION DEL COMPONENTE 'animatedModal' -->
        @include('templates.expediente.$overview')

        <!-- <h2 class="lead">Índice de Casos</h2> -->

        <!-- BUSQUEDA -->
        <div class="col-lg-12">
        
            @include('partials._search')
        
            <!-- FILTRAR RESULTADOS -->
            <div class="col-lg-2 row">
                <button class="btn-outline btn btn-none" ng-init="filter_active = false" ng-click="filter_active = !filter_active; filter_init()"
                    style="margin: 0 4px" type="button" data-toggle="collapse" data-target="#filter">
                    <!-- <span class="glyphicon glyphicon-filter"></span> -->
                    Filtrar
                    <span class="caret" ng-class="{'caret-right': !filter_active}"></span>
                </button>
        
                <button class="btn-outline btn btn-edit" type="button" ng-show="filter_data.filtered" ng-click="filter_data.filtered = false; search = ''; index();">Ver todos</button>
            </div>
        
            <!-- LINK AGREGAR NUEVO CASO -->
            <div class="col-lg-2 text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('expedientes.create') }}">Agregar nuevo caso</a>
            </div>
        </div>

        <!-- COLUMNAS VISIBLES -->
        <nav class="navbar navbar-default navbar-sm col-md-10 col-md-offset-1" style="margin-top: 1.5em" role="navigation">
            <span class="navbar-text">
                <b>Columnas visibles</b>
            </span>
            <div class="navbar-form" style="padding-top:4px">
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.cedula">Cédula</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.nombre">Nombre</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.apellidos">Apellidos</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.referente">Referente</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.ubicacion">Ubicación</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.estado">Estado</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.prioridad">Prioridad</label>
                <label class="checkbox-inline"><input type="checkbox" ng-model="columns.fecha_creacion">Fecha de creación</label>
            </div>
        </nav>

        <!-- FILTRO DE BUSQUEDA -->
        <div class="collapse col-md-12" id="filter" style="background-color: #fafafa;">
            @include('partials._filter')
        </div>

        <!-- TABLA DE CASOS -->
        <div class="table-responsive col-md-12" style="overflow-y: auto; max-height: 70vh">

            {{-- <span class="text-muted text-nowrap" style="padding-left: 2em">
                @{{ 
                    !filter_data.filtered ? 
                        'Mostrando todos los resultados. Pág ' + page + '/' + totalpages : 
                        'Filtrado por: ' + filter_data.filter
                }}
            </span> --}}

            <table id="expedientesindex" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th ng-show="columns.cedula">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('cedula')">
                                Cédula <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'cedula'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.nombre">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('nombre')">
                                Nombre
                                <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'nombre'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.apellidos">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('apellidos')">
                                Apellidos
                                <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'apellidos'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.referente">Referente</th>
                        <th ng-show="columns.ubicacion">Ubicación</th>
                        <th ng-show="columns.estado">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('estado')">
                                Estado
                                <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'estado'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.prioridad">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('prioridad')">
                                Prioridad <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'prioridad'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.fecha_creacion">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('fecha_creacion')">
                                Fecha de creación
                                <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'fecha_creacion'}"></span>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-class="{'active' : e.isSelected, 'archived progress-bar-striped': e.archivado }" ng-repeat="e in expedientes" ng-click="show(e)" ng-cloak>
                        <td ng-show="columns.cedula">@{{ e.persona.cedula }}</td>
                        <td ng-show="columns.nombre">@{{ e.persona.nombre }}</td>
                        <td ng-show="columns.apellidos">@{{ e.persona.apellidos }}</td>
                        <!-- POST RENDERIZADO DE FILA PARA REFERENTES -->
                        <td ng-show="columns.referente" ng-if="e.referente_otro !== null">@{{ e.referente_otro }}</td>
                        <td class="text-muted" ng-show="columns.referente" ng-if="e.referente_otro === null && e.referente.id === {{ $first_referente }}">Ninguno</td>
                        <td ng-show="columns.referente" ng-if="e.referente_otro === null && e.referente.id !== {{ $first_referente }}">
                            <span class="text-primary glyphicon glyphicon-file"></span> @{{ e.referente.descripcion }}
                        </td>
                        <!-- ------------------------------------------ -->
                        <td ng-show="columns.ubicacion" region-text path="e.persona.ubicacion"></td>                        
                        <td ng-show="columns.estado">
                            <span class="label label-@{{ (e.estado === 0)? 'info' : (e.estado === 1)? 'success' : (e.estado === 2)? 'danger' : (e.estado === 3)? 'warning' : ''}}">
                                @{{
                                    e.estado === 0 ? 'En valoración' :
                                    e.estado === 1 ? 'Aprobado' :
                                    e.estado === 2 ? 'No aprobado' :
                                    e.estado === 3 ? 'Pendiente' : ''
                                }}
                            </span>
                        </td>
                        <td ng-show="columns.prioridad">
                            <span class="label label-@{{ (e.prioridad === 1)? 'success' : (e.prioridad === 2)? 'warning' : (e.prioridad === 3)? 'danger' : '' }}">@{{ (e.prioridad === 1)? 'Baja' : (e.prioridad === 2)? 'Media' : (e.prioridad === 3)? 'Alta' : '' }}</span>
                        </td>
                        <td ng-show="columns.fecha_creacion">@{{ e.fecha_creacion }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- <h1 class="text-center" ng-show="expedientes.length === 0">Cargando casos...</h1> -->
        </div>

        <div class="text-center col-md-12">
            <ul uib-pagination total-items="total" class="pagination-sm" ng-model="page" items-per-page="{{ $max_records }}" ng-change="index(page)"></ul>
        </div>
    </section>
@endsection
