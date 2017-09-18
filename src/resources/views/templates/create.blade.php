@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/CreateExpedienteController.js') }}" charset="utf-8"></script>
@endpush

@section('content')
    <section class="col-md-10 col-md-offset-1" ng-controller="CreateExpedienteController">
        <form id="expedientescreate" name="newexpediente" class="form-horizontal" action="{{ route('expedientes.store') }}" method="post">

            {{ csrf_field() }}

            {{-- FIX THIS REDIRECT --}}
            @if (URL::previous() !== route('expedientes.index'))
                <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">
            @else
                <input type="hidden" name="redirects_to" value="{{ route('expedientes.index') }}">
            @endif

            <fieldset class="col-md-5">
                <legend>Detalles de la persona</legend>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="cedula">Cédula:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="cedula" placeholder="Formato: x0xxx0xxx" ng-model="cedula" required>
                        <p class="help-block"><small>Reemplace las equis (x) por los números de la cédula correspondiente.</small></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre" ng-model="nombre" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="apellidos">Apellidos:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="apellidos" placeholder="Ingrese los apellidos" ng-model="apellidos" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="apellidos">Teléfono(s):</label>
                    <div class="col-sm-10 col-sm-offset-2">
                        <textarea name="telefonos" class="noresize form-control" rows="5" cols="50" placeholder="Separe por comas (,) o espacios"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="ubicacion">Ubicación:</label>
                    <div class="col-sm-10 col-sm-offset-2">
                        <p class="help-block">Provincia</p>
                        <select class="form-control" name="provincia" ng-model="provincia" ng-change="location.select(provincia,0,this)">
                            <option value="0" disabled>-Seleccionar provincia-</option>
                            <option value="1">San José</option>
                            <option value="2">Alajuela</option>
                            <option value="3">Cartago</option>
                            <option value="4">Heredia</option>
                            <option value="5">Guanacaste</option>
                            <option value="6">Puntarenas</option>
                            <option value="7">Limón</option>
                        </select>
                        <p class="help-block">Cantón</p>
                        <select class="form-control" name="canton" ng-disabled="cantones.length === 0" ng-model="canton" ng-change="location.select(provincia,canton,this)">
                            <option value="0">-Seleccionar cantón-</option>
                            <option value="@{{ $index + 1 }}" ng-repeat="c in cantones | limitTo: (1 - cantones.length) ">@{{ c }}</option>
                        </select>
                        <p class="help-block">Distrito</p>
                        <select class="form-control" name="distrito" ng-disabled="distritos.length === 0" ng-model="distrito">
                            <option value="0">-Seleccionar distrito-</option>
                            <option value="@{{ $index + 1 }}" ng-repeat="d in distritos | limitTo: (1 - distritos.length) ">@{{ d }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-12" for="direccion">Dirección exacta:</label>
                    <div class="col-sm-10 col-sm-offset-2">
                        <textarea name="direccion" class="noresize form-control" rows="5" cols="50" ng-model="direccion" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="contactos">Contacto(s):</label>
                    <div class="col-sm-10 col-sm-offset-2">
                        <textarea name="contactos" class="noresize form-control" rows="5" cols="50"></textarea>
                    </div>
                </div>

            </fieldset>
            <div class="col-md-1 hidden-xs hidden-sm"></div>
            <fieldset class="col-md-5">
                <legend>Detalles del caso</legend>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="descripcion">Descripcion:</label>
                    <div class="col-sm-10 col-sm-offset-2">
                        <textarea name="descripcion" class="noresize form-control" rows="5" cols="50" placeholder="Anote en detalle la descripción del caso" ng-model="descripcion" required></textarea>
                    </div>
                </div>

                <div class="form-group col-sm-pull-2">
                    <label class="control-label col-sm-4" for="referente">Referente:</label>

                    <div class="col-sm-8">
                        {{-- <p><input type="checkbox"> Otro <input type="text" class="form-control" name="" value="" placeholder="Debug msg: This input should be hidden"></p> --}}
                        <select class="form-control" name="referente">
                            @foreach (\App\Models\Referente::where('id', '<>', 1)->get() as $r)
                                <option value="{{ $r->id }}">{{ $r->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-sm-pull-2">
                    <label class="control-label col-sm-4" for="prioridad">Prioridad:</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="prioridad" ng-model="prioridad" ng-options="p.name for p in prioridades track by p.value" convert-to-number required>
                            <option value="" disabled selected>-Seleccionar prioridad-</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-sm-pull-2">
                    <label class="control-label col-sm-4" for="estado" ng-model="estado" required>Estado de aprobación:</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="estado" ng-model="estado" ng-options="e.name for e in estados track by e.value" convert-to-number required></select>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="control-label col-sm-4" for="ayuda">Ayuda solicitada:</label>

                    <button class="btn-rest btn-show" type="button" ng-click="add()" ng-disabled="checkNullity(ayudas_selected)"><span class="glyphicon glyphicon-plus"></span> Agregar ayuda</button>

                    <div class="col-sm-8 col-sm-offset-4" ng-repeat="as in ayudas_selected">

                        <div class="controls">
                            <select class="form-control" name="ayuda" ng-model="ayudas_selected[$index]" ng-options="o.descripcion for o in ayudas track by o.id" ng-change="changed(ayudas_selected[$index], $index)" convert-to-number>
                                <option value="">-Seleccionar tipo de ayuda-</option>
                            </select>
                            <p class="help-block" ng-show="ayudas_selected[$index].$invalid"><small class="text-danger">Cada tipo de ayuda debe ser <strong>distinto</strong></small></p>
                            <button type="button" class="btn btn-primary" ng-click="remove(as)" ng-if="!$first">remove</button>
                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="center-block btn btn-primary" ng-disabled="newexpediente.$invalid">Guardar expediente</button>
                    </div>
                </div>
            </fieldset>

        </form>
    </section>
@endsection
