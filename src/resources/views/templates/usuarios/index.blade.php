@extends('layouts.main') 

@push('scripts_top')
	<script src="{{ asset('app/controllers/usuarios/MainController.js') }}" charset="utf-8"></script>
	<script src="{{ asset('app/controllers/usuarios/IndexController.js') }}" charset="utf-8"></script>
@endpush

@section('content')
	<ng-controller ng-controller="Usuarios_MainController">
		<section id="ayudas" class="col-md-10 col-md-offset-1" ng-controller="Usuarios_IndexController">

			<!-- TABLA DE inspectores -->
			<div class="table-responsive col-sm-8" style="margin-left: 15%">
				<h3 class="text-center">
					Ayudas 
					<button type="button" class="btn btn-success pull-right" ng-click="show(null, 0);">Agregar</button>
				</h3>
				<table id="index" class="table table-hover table-striped">
					<thead style="background-color: #e7e7e7; color: #555;">
						<tr>
							<th ng-show="columns.username" style="width: 40%">
								<h4><Strong>Usuario</Strong></h4>
							</th>
							<th ng-show="columns.email" style="width: 40%">
								<h4><Strong>Correo electrónico</Strong></h4>
							</th>
							<th ng-show="columns.opciones">
								<h4><Strong>Opciones</Strong></h4>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-class="{'active' : a.isSelected}" ng-repeat="u in usuarios"ng-cloak>
							<td ng-show="columns.username" style="width: 40%;">@{{ u.username }}</td>
							<td ng-show="columns.email" style="width: 40%;">@{{ u.email }}</td>
							<td>
								<button type="button" class="btn btn-sm btn-outline btn-edit" ng-click="show(u, 1)">Editar</button>
								<button type="button" class="btn btn-sm btn-outline btn-delete" ng-click="show(u, 2)">Eliminar</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
	
			<div class="text-center col-sm-8" style="margin-left: 15%">
				<ul uib-pagination total-items="total" class="pagination-sm" ng-model="page" items-per-page="16" ng-change="index(page)"></ul>
			</div>

			  <!-- Modal agregar -->
			<div class="modal fade" id="modalOpcion" role="dialog" style="margin-top: 10%;" ng-model='modalOpciones'>
			    <div class="modal-dialog modal-md">
			      	<div class="modal-content">
			        	
			        	<div class="modal-header" style="background-color: @{{ opcion == 0 ? '#5cb85c' : opcion == 1 ? '#337ab7' : '#c9302c'}};text-align: center;color: white;">
			          		<button type="button" class="close" ng-click="closeModal()">&times;</button>
			          		<h4 class="modal-title" >
			          			@{{ opcion === 0 ? 'Agregar' : opcion === 1 ? 'Editar' : 'Eliminar' }} usuario</h4>
			        	</div>
			        	
			        	<div class="modal-body" style="height: @{{ opcion === 0 ? '220px' : opcion === 1 ? '150px' : '100px' }}">
			        		
			        		<h4 style="display:@{{ opcion === 2 ? 'block' : 'none' }}; margin-top: 20px;text-align: center;">¿Desea eliminar el usuario @{{ selected.username }}?</h4>
							
							<div style="display:@{{ opcion !== 2 ? 'block' : 'none' }}; margin-top: 20px;">	
								
								<div class="form-group row">
								    <label  class="col-sm-4 col-form-label" for="username">Usuario:</label>
								    <div class="col-sm-6">
								        <input type="text" class="form-control" id="username" placeholder="Ingrese el nombre de usuario" ng-model="update.username" required />
								    </div>
								</div>

				        		<div class="form-group row" style="display:@{{ opcion == 0 ? 'block' : 'none' }};">
								    <label class="col-sm-4 col-form-label" for="password">Contraseña:</label>
								    <div class="col-sm-6">
								        <input type="text" class="form-control" id="password" placeholder="Ingrese el correo contrasseña" ng-model="update.password" required />
								    </div>
								</div>

				        		<div class="form-group row">
								    <label class="col-sm-4 col-form-label" for="email">Correo electrónico:</label>
								    <div class="col-sm-6">
								        <input type="text" class="form-control" id="email" placeholder="Ingrese el correo electrónico" ng-model="update.email" required />
								    </div>
								</div>

							</div>

			        	</div>

			        	<div class="modal-footer">
			          		<button type="button" class="btn-outline btn-default" ng-click="closeModal()" style="height: 30px;border-radius: 5px;">Cancelar</button>
			        		<button type="button" class="btn-outline btn-@{{ opcion == 0 ? 'show' : opcion == 1 ? 'edit' : 'delete'}}" 
			        			ng-click="opcion === 0 ? add() : opcion === 1 ? edit() : delete()" style="height: 30px;border-radius: 5px;">
			        			@{{ opcion === 0 ? 'Agregar' : opcion === 1 ? 'Guardar cambios' : 'Aceptar' }}
			        		</button>
			        	</div>
			      	</div>
			    </div>
			</div>

		</section>
	</ng-controller>
@endsection