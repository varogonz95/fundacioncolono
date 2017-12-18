@extends('layouts.main')

@push('scripts_top')
	<script src="{{ asset('app/controllers/inspectores/MainController.js') }}" charset="utf-8"></script>
	<script src="{{ asset('app/controllers/inspectores/IndexController.js') }}" charset="utf-8"></script>
	<script src="{{ asset('app/controllers/personas/EditController.js') }}"></script>
@endpush

@push('scripts_bottom')
  <script src="{{ asset('js/animatedModal/animatedModal.js') }}"></script>
@endpush


@section('controller', 'Inspectores')

@section('content')

    <section id="inspectores" class="col-md-10 col-md-offset-1" ng-controller="Inspectores_IndexController">

				@include('templates.inspector.$overview')

				@include('partials._search-inspector')

				<!-- COLUMNAS VISIBLES -->
				<nav class="navbar navbar-default" style="margin-top: 1em; margin-left: 20px; width:1350px" role="navigation">
						<span class="navbar-text">
								<b>Columnas visibles</b>
						</span>

						<div class="navbar-form" style="padding-top:4px">
								<label class="checkbox-inline"> <input type="checkbox" ng-model="columns.cedula">Cédula</label>
								<label class="checkbox-inline"> <input type="checkbox" ng-model="columns.nombre">Nombre</label>
								<label class="checkbox-inline"> <input type="checkbox" ng-model="columns.apellidos">Apellidos</label>
								<label class="checkbox-inline"> <input type="checkbox" ng-model="columns.username">Usuario</label>
								<label class="checkbox-inline"> <input type="checkbox" ng-model="columns.email">Correo</label>
								<label class="checkbox-inline"> <input type="checkbox" ng-model="columns.activo">Activo</label>
						</div>
				</nav>

				<div class="collapse col-md-12" id="filter" style="background-color: #fafafa;">
            @include('partials._filter-inspector')
        </div>

        <!-- TABLA DE inspectores -->
        <div class="table-responsive col-md-12">
            <table id="inspectoresindex" class="table table-hover table-striped">
                <thead>
                    <tr>
												<th ng-show="columns.cedula">
													<button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('cedula')">
														Cédula <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'cedula'}"></span>
													</button>
												</th>
												<th ng-show="columns.nombre">
													<button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('nombre')">
														Nombre <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'nombre'}"></span>
													</button>
												</th>
												<th ng-show="columns.apellidos">
													<button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('apellidos')">
														Apellidos <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'apellidos'}"></span>
													</button>
												</th>
												<th ng-show="columns.username">
													<button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('username')">
														Usuario <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'username'}"></span>
													</button>
												</th>
                        <th ng-show="columns.email">
													<button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('email')">
														Correo <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'email'}"></span>
													</button>
												</th>
                        <th ng-show="columns.activo">
													<button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('activo')">
														Activo <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'activo'}"></span>
													</button>
												</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="@{{ (i.isSelected)? 'active' : '' }}" ng-repeat="i in inspectores | filter: search"  ng-click="show(i)" ng-cloak>
												<td ng-show="columns.cedula">@{{ i.persona.cedula }}</td>
												<td ng-show="columns.nombre">@{{ i.persona.nombre }}</td>
												<td ng-show="columns.apellidos">@{{ i.persona.apellidos }}</td>
												<td ng-show="columns.username">@{{ i.usuario.username }}</td>
                        <td ng-show="columns.email">@{{ i.usuario.email }}</td>
                        <td ng-show="columns.activo">@{{ i.activo }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center col-md-12">
            <ul uib-pagination total-items="total" class="pagination-sm" ng-model="page" items-per-page="16" ng-change="index(page)"></ul>
        </div>
    </section>
@endsection
