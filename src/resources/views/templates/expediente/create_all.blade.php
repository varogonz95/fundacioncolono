@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/expedientes/MainController.js') }}" charset="utf-8"></script>
    <script src="{{ asset('app/controllers/expedientes/CreateController.js') }}" charset="utf-8"></script>
@endpush

@section('controller', 'Expedientes')

@section('content')
    <section class="col-md-10 col-md-offset-1" ng-controller="Expedientes_CreateController">
        <form name="newexpediente" class="form-horizontal" action="{{ route('expedientes.store') }}" method="POST">

            {{ csrf_field() }}

            {{-- PERSONA --}}
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
            {{--<fieldset class="col-md-5 col-md-offset-1">
                    <legend>Ayudas solicitadas</legend>
                    @include('templates.ayuda.$add_pivot')
                </fieldset>--}}

        </form>
    </section>
@endsection
