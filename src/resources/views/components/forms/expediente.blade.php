<div class="form-group">
    <label class="control-label col-sm-2" for="descripcion">Descripcion:</label>
    <div class="col-sm-10 col-sm-offset-2">
        <textarea name="descripcion" class="noresize form-control" rows="5" cols="50" placeholder="Anote en detalle la descripción del caso" ng-model="{{  $descripcion_model  }}" required>
            {{ $descripcion_value }}
        </textarea>
    </div>
</div>

<div class="form-group col-sm-pull-2">
    <label class="control-label col-sm-4" for="referente">Referente:</label>

    <div class="col-sm-8">
        <label style="font-weight:100">
            Otro referente:
            <input type="checkbox" ng-model="{{ $hasReferenteOtro_model }}" ng-init="{{ $hasReferenteOtro_model }} = false">
            <input type="hidden" name="hasReferenteOtro" ng-value="{{ $hasReferenteOtro_value }}">
        </label>
        <ng-show ng-show="{{ $hasReferenteOtro_model }}">
            <input class="form-control" type="text" name="referente_otro" placeholder="Nombre del referente" ng-model="{{ $referente_otro_model }}">
            <label style="font-weight:100;font-size:12px;text-indent:1.5em;">
                Agregar a opciones:
                <input type="checkbox" ng-model="{{ $newReferente_model }}" ng-init="{{ $newReferente_model }} = false">
                <input type="hidden" name="newReferente" ng-value="{{ $newReferente_value }}">
            </label>
        </ng-show>

        <input type="text" name="referente" placeholder="-Seleccione un referente-" class="form-control"
            autocomplete="off" ng-model="{{ $referente_model }}" ng-hide="{{ $hasReferenteOtro_model }}"
            uib-typeahead="r.id as r.descripcion for r in {{ $referentes_list }} | filter:$viewValue | limitTo:{{ $referentes_limit }}"
            typeahead-show-hint="true" typeahead-min-length="0" typeahead-input-formatter="formatter($model, {{ $referentes_list }}, 'id', 'descripcion')">
        <input type="hidden" name="referente" ng-value="{{ $hasReferenteOtro_model }}? 1 : {{ $referente_model }}">
        {{-- LEGACY INPUT,  BY UI BOOTSTRAP TYPEAHEAD DIRECTIVE --}}
        {{-- <select class="form-control" name="referente" ng-hide="hasReferenteOtro">
        @foreach (\App\Models\Referente::where('id', '<>', 1)->get() as $r)
        <option value="{{ $r->id }}">{{ $r->descripcion }}</option>
    @endforeach
</select> --}}
</div>
</div>

<div class="form-group col-sm-pull-2">
    <label class="control-label col-sm-4" for="prioridad">Prioridad:</label>
    <div class="col-sm-8">
        <select class="form-control" name="prioridad" ng-model="{{ $prioridad_model }}" ng-options="p.name for p in {{ $prioridad_list }} track by p.id" convert-to-number required>
            <option value="" disabled selected>-Seleccionar prioridad-</option>
        </select>
    </div>
</div>

<div class="form-group col-sm-pull-2">
    <label class="control-label col-sm-4" for="estado" ng-model="{{ $estado_model }}" required>Estado de aprobación:</label>
    <div class="col-sm-8">
        <select class="form-control" name="estado" ng-model="{{ $estado_model }}" ng-options="e.name for e in {{ $estados_list }} track by e.id" convert-to-number required></select>
    </div>
</div>

{{ $slot }}
