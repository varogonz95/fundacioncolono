@extends('layouts.main')

@push('scripts_top')
    <script src="{{ asset('app/controllers/inspectores/MainController.js') }}" charset="utf-8"></script>
    <script src="{{ asset('app/controllers/inspectores/CreateController.js') }}" charset="utf-8"></script>
@endpush


@push('scripts_bottom')
    @if (Session::has('status'))
        @include('partials._error_alert')
    @endif
@endpush

@section('controller', 'Inspectores')

@section('content')
    <section class="col-md-10 col-md-offset-1"  ng-controller="Inspectores_CreateController">
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
                <legend>Detalles del inspector</legend>
                {{-- IMPORT FORM COMPONENT FOR PERSONA --}}
                @include('templates.persona.$create')

                <div class="form-group">
                    <label class="control-label col-md-3" for="activo" style="text-align:left">Activo:</label>
                    <div class="col-md-8 col-md-offset-1">
                        <select class="form-control" name="activo" required>
                            <option value="" disabled>-Seleccionar-</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary"  value="Enviar" style="float:right;width:150px">
             </fieldset>
        </form>
    </section>
@endsection
