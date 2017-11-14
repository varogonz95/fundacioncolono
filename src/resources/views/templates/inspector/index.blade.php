@extends('layouts.main')

@section('controller', 'Inspectores')

@push('scripts_top')
	<script src="{{ asset('app/controllers/inspectores/MainController.js') }}" charset="utf-8"></script>
	<script src="{{ asset('app/controllers/inspectores/IndexController.js') }}" charset="utf-8"></script>
@endpush


@section('content')

    <section id="expedientes" class="col-md-10 col-md-offset-1" ng-controller="Inspectores_IndexController">
		        
        <!-- LINK AGREGAR NUEVO USUARIO INSPECTOR -->
        <div class="col-lg-2 text-right">
            <a class="btn btn-primary btn-sm" href="{{ route('inspectores.create') }}">Agregar nuevo inspector</a>
        </div>
        
        <!-- TABLA DE CASOS -->
        <div class="table-responsive col-md-12">
            <table id="inspectoresindex" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
						<th>Apellidos</th>
						<th>Ocupación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="i in inspectores" ng-cloak>
                        <td>@{{ i.usuario.username }}</td>
                        <td>@{{ i.usuario.email }}</td>
                        <td>@{{ i.persona.cedula }}</td>
                        <td>@{{ i.persona.nombre }}</td>
                        <td>@{{ i.persona.apellidos }}</td>
                        <td>@{{ i.persona.ocupacion }}</td>
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
