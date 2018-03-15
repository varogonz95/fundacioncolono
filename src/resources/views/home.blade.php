@extends('layouts.main')

@section('content')

	<div class="col-md-4 col-md-offset-1">
		
		<h3 class="page-header">
			Entregas pendientes
			<small style="display: flex; font-size: small">
				Leyenda
				<span class="">Meses aprobados <span class="glyphicon glyphicon-ok-circle"></span></span>
				<span class="">Meses restantes <span class="glyphicon glyphicon-time"></span></span>
				<span class="">Entregas pendientes <span class="glyphicon glyphicon-warning-sign"></span></span>
			</small>
		</h3>
		
		@foreach($pending_transactions as $pt)
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="nogutters col-md-6 col-sm-12">Aprobado del <b>{{ $pt->formatted_fecha_desde }}</b> al <b>{{ $pt->formatted_fecha_hasta }}</b></div>
					<div class="nogutters col-md-4 col-sm-12 text-nowrap" style="display: flex">
						<span class="delivery-badge approved">5 <span class="glyphicon glyphicon-ok-circle"></span></span>
						<span class="delivery-badge remaining">4 <span class="glyphicon glyphicon-time"></span></span>
						<span class="delivery-badge pending">2 <span class="glyphicon glyphicon-warning-sign"></span></span>
					</div>
					<button class="close">&times;</button>
				</div>

				<div class="panel-body">
					<p>Está pendiente la entrega de las ayudas de este caso</p>

					<label>Expediente.</label>
					<table class="table table-condensed">
						<tbody>
							<tr>
								<td>{{ $pt->persona['cedula'] }}</td>
								<td>{{ $pt->persona['nombre'] }}</td>
								<td>{{ $pt->persona['apellidos'] }}</td>
								<td>
									<label for="">Prioridad</label>
									@switch($pt['prioridad'])
										@case(1)
											<span class="label label-success">Baja</span>
										@break

										@case(2)
											<span class="label label-warning">Media</span>
										@break

										@case(3)
											<span class="label label-danger">Alta</span>
										@break
									@endswitch
									
								</td>
							</tr>
						</tbody>
					</table>

					<label>Ayudas. <a class="btn btn-sm btn-link" href="#ayudas1" data-toggle="collapse">ver/ocultar</a></label>
					<div id="ayudas1" class="collapse">
						<ul class="list-group list-group-sm">
							@foreach($pt->ayudas as $ayuda)
								<li class="list-group-item">
									{{ $ayuda['descripcion'] }}
									<button class="btn-sm btn btn-outline btn-show">asdsas</button>
								</li>
							@endforeach
						</ul>
                    </div>
					<div class="panel-controls text-right">
						<button class="btn btn-sm btn-outline btn-edit">Hello world</button>
					</div>
				</div>
			</div>
		@endforeach

	</div>
@endsection