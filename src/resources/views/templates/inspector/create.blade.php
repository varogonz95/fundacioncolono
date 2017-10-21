@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/expedientes/MainController.js') }}" charset="utf-8"></script>
    <script src="{{ asset('app/controllers/expedientes/CreateController.js') }}" charset="utf-8"></script>
@endpush

@section('controller', 'Inspectores')

@section('content')
    <section class="col-md-10 col-md-offset-1" ng-controller="Expedientes_CreateController">
        <form class="form-horizontal" action="{{ route('inspectores.store') }}" method="post">

            {{ csrf_field() }}

            {{-- USUARIO --}}
            <fieldset class="col-md-5">
                <legend>Cuenta del usuario</legend>
                {{-- IMPORT FORM COMPONENT FOR USUARIO --}}
                @include('partials._usuario')
            </fieldset>
            
            <div class="col-md-1 hidden-xs hidden-sm"></div>
            
            {{-- PERSONA --}}
            <fieldset class="col-md-5">
                <legend>Detalles de la persona</legend>
                {{-- IMPORT FORM COMPONENT FOR PERSONA --}}
                @include('persona.$create')
            </fieldset>

        </form>
    </section>
@endsection
