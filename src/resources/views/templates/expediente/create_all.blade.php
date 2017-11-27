@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/expedientes/MainController.js') }}" charset="utf-8"></script>
    <script src="{{ asset('app/controllers/expedientes/CreateController.js') }}" charset="utf-8"></script>
@endpush

@push('scripts_bottom')
    <script src="{{ asset('js/animatedModal/animatedModal.js') }}"></script>
@endpush

@section('controller', 'Expedientes')

@section('content')

    <section class="col-md-10 col-md-offset-1" ng-controller="Expedientes_CreateController">

        @include('templates.ayuda.$add_pivot')

        <form name="newexpediente" class="form-horizontal" action="{{ route('expedientes.store') }}" method="POST">

            {{ csrf_field() }} {{-- PERSONA --}}
            <fieldset class="col-md-5">
                <legend>Detalles de la persona</legend>
                {{-- IMPORT FORM COMPONENT FOR PERSONA --}}
                @include('templates.persona.$create')
            </fieldset>

            <div class="col-md-1 hidden-xs hidden-sm"></div>

            {{-- EXPEDIENTE --}}
            <fieldset class="col-md-5">
                <legend>Detalles del caso</legend>
                {{-- IMPORT FORM COMPONENT FOR PERSONA --}}
                @include('templates.expediente.$create')
            </fieldset>

            {{-- AYUDAS --}}
            <fieldset class="col-md-5 col-md-offset-1">
                <legend>
                    Ayudas solicitadas
                    <button type="button" class="btn-outline btn-rest btn-show btn-sm pull-right" title="Agregar ayudas" style="margin-bottom: 5px" data-toggle="modal" data-target="#ayudasModal">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span class="hidden-xs">Agregar ayudas</span>
                    </button>
                </legend>
                @include('templates.ayuda.$add_pivot2')

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="center-block btn btn-primary" ng-disabled="newexpediente.$invalid">Guardar expediente</button>
                    </div>
                </div>
            </fieldset>


        </form>
    </section>
@endsection
