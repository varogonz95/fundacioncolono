@extends('layouts.main') 

@section('controller', 'Expedientes') 

@section('content')

<div class="col-lg-offset-1 col-xs-10 text-left" style="margin-bottom: 2em">
    <button type="button" class="btn btn-delete btn-sm btn-outline" title="Archivar" ng-hide="selected.archivado" ng-click="delete()">
        <span class="glyphicon glyphicon-briefcase"></span>
        <span class="hidden-xs">Archivar</span>
    </button>
    <button type="button" class="btn btn-show btn-sm btn-outline" title="Restaurar" ng-show="selected.archivado" ng-click="restore()">
        <span class="glyphicon glyphicon-refresh"></span>
        <span class="hidden-xs">Restaurar</span>
    </button>
    <a href="{{ route('expedientes.show', ['id' => $expediente]) }}" target="_blank" class="btn btn-outline btn-sm btn-edit" title="Historial de cambios">
        <span class="glyphicon glyphicon-time"></span>
        <span class="hidden-xs">Historial de cambios</span>
    </a>
    <span style="border-left: thin solid #ccc; padding: 0 4px" ng-show="update.cache || (update.cache && (update.ayudas.attachs.length > 0 || update.ayudas.detachs.length > 0 || update.ayudas.updates.length > 0))">
        <button type="button" class="btn btn-outline btn-update" title="Guardar cambios" ng-click="updateCaso()">
            <span class="glyphicon glyphicon-edit"></span>
            <span class="hidden-xs">Guardar todo</span>
        </button>
    </span>
</div>

{{-- INFORMACION DE LA PERSONA --}}
<article class="col-lg-4 col-lg-offset-1">
    <h3 class="lead">Informacion de la persona</h3>

    <div class="table-responsive">

        <table class="table table-borderless">

            <tbody>

                {{-- ATTRIBUTES --}}
                <tr>
                    <td>Cédula</td>
                    <td>{{ $expediente['persona']['cedula'] }}</td>
                </tr>
                <tr>
                    <td>Nombre completo</td>
                    <td>{{ "{$expediente['persona']['nombre']} {$expediente['persona']['apellidos']}" }}</td>
                </tr>
                <tr>
                    <td>Telefonos</td>
                    <td>{{ $expediente['persona']['telefonos'] }}</td>
                </tr>
                <tr>
                    <td>Ubicación</td>
                    <td>{{ $expediente['persona']['ubicacion'] }}</td>
                </tr>
                <tr>
                    <td>Dirección exacta</td>
                    <td>{{ $expediente['persona']['direccion'] }}</td>
                </tr>
                <tr>
                    <td>Contactos</td>
                    <td>{{ $expediente['persona']['contactos'] }}</td>
                </tr>
            </tbody>

        </table>

    </div>

</article>

{{-- INFORMACION DEL CASO --}}
<article class="col-lg-4 col-lg-offset-1">
    <h3 class="lead">Datos del caso</h3>

    <div class="table-responsive">

        <table class="table table-borderless">

            <tbody>

                {{-- ATTRIBUTES --}}
                <tr>
                    <td>Descripción</td>
                    <td>{{ $expediente['descripcion'] }}</td>
                </tr>

                <tr>
                    <td>Referente</td>
                    <td>{{ $expediente['referente_otro'] }}</td>
                </tr>

                <tr>
                    <td>Prioridad</td>
                    <td>{{ $expediente['prioridad'] }}</td>
                </tr>

                <tr>
                    <td>Estado de aprobación</td>
                    <td>{{ $expediente['estado'] }}</td>
                </tr>

                @if($expediente['estado'] === 1)
                <tr>
                    <td></td>
                    <td>&lt;-- Poner aqui las fecha de aprobacion y de pago --&gt;</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</article>

{{-- INFORMACION DE LAS AYUDAS --}}
<article class="col-lg-10 col-lg-offset-1">

    <h3 class="lead">
        Ayudas
        <small class="text-mute">Monto total asignado: ₡ {{ $expediente['montoTotal'] }}</small>
    </h3>

    @foreach($expediente['ayudas'] as $ayuda)
    <div class="table-responsive col-lg-4">

        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td>Tipo de ayuda</td>
                    <td>{{ $ayuda['descripcion'] }}</td>
                </tr>

                <tr>
                    <td>Detalle</td>
                    <td>{{ $ayuda['pivot']['detalle'] }}</td>
                </tr>

                <tr>
                    <td>Monto</td>
                    <td>{{ $ayuda['pivot']['monto'] }}</td>
                </tr>        
            </tbody>
        </table>
    </div>
    @endforeach

</article>

@endsection