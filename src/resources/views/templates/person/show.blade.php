@extends('partials._modal')

@section('modal-id')
id="personshowmodal"
@overwrite

@section('modal-controller')
@overwrite

@section('modal-title')
    <h4 class="modal-title">Información de persona<button type="button" ng-click="showrec()" class="pull-right btn btn-info btn-sm">Ver expedientes</button></h4>
@overwrite

@section('modal-body')
    <article>
        <p><strong>Identificación:</strong> @{{persona.selected.cedula}}</p>
        <p><strong>Nombre:</strong> @{{persona.selected.nombre}}</p>
        <p><strong>Apellidos:</strong> @{{persona.selected.apellidos}}</p>
        <p><strong>Ocupación:</strong> @{{persona.selected.ocupacion}}</p>
        <p><strong>Teléfono(s):</strong> @{{persona.selected.tels}}</p>
    </article>
@overwrite

@section('modal-footer')
@overwrite
