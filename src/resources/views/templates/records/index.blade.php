@include('templates.records.show')

<div class="col-md-12">

    <nav class="navbar navbar-default navbar-sm" role="navigation">
        {{-- <span class="navbar-text"><b>Columnas visibles</b></span>
        <form class="navbar-form" style="padding-top:4px">
            <label class="checkbox-inline"><input type="checkbox" ng-model="expediente.visible.cedula">Identificación</label>
            <label class="checkbox-inline"><input type="checkbox" ng-model="expediente.visible.nombre">Nombre</label>
            <label class="checkbox-inline"><input type="checkbox" ng-model="expediente.visible.apellidos">Apellidos</label>
            <label class="checkbox-inline"><input type="checkbox" ng-model="expediente.visible.ocupacion">Ocupacion</label>
            <label class="checkbox-inline"><input type="checkbox" ng-model="expediente.visible.tels">Teléfonos</label>
            <input type="number" ng-model="maxrecords" ng-value="0">
            <button type="button" ng-click="seed(maxrecords,true)">Wipe & seed</button>
            <button type="button" ng-click="seed(0,true)">Wipe all</button>
        </form> --}}
    </nav>

    <div class="table-responsive">

        <!--<nav class="text-center" style="padding:0;margin:0">
            <ul uib-pagination ng-model="pagination.page" total-items="pagination.total" max-size="12" items-per-page="16" max-size="pagination.total" class="pagination-sm" ng-change="index(pagination.page)"></ul>
        </nav>-->

        <table class="table table-hover recordsindex">
            <thead>
                <tr>
                    <th><button type="button" class="btn btn-table-header" ng-click="sort('cedula')">Beneficiario<span class="small glyphicon glyphicon-menu-@{{(!expediente.sort.by)? 'up' : 'down'}}" ng-show="expediente.sort.property==='beneficiario'"></span></button></th>
                    <th><button type="button" class="btn btn-table-header" ng-click="sort('nombre')">Ubicación<span class="small glyphicon glyphicon-menu-@{{(!expediente.sort.by)? 'up' : 'down'}}" ng-show="expediente.sort.property==='ubicacion'"></span></button></th>
                    <th><button type="button" class="btn btn-table-header" ng-click="sort('apellidos')">Prioridad<span class="small glyphicon glyphicon-menu-@{{(!expediente.sort.by)? 'up' : 'down'}}" ng-show="expediente.sort.property==='prioridad'"></span></button></th>
                    <th><button type="button" class="btn btn-table-header" ng-click="sort('tels')">Tipo de ayuda<span class="small glyphicon glyphicon-menu-@{{(!expediente.sort.by)? 'up' : 'down'}}" ng-show="expediente.sort.property==='ayuda'"></span></button></th>
                    <th><button type="button" class="btn btn-table-header" ng-click="sort('ocupacion')">Estado<span class="small glyphicon glyphicon-menu-@{{(!expediente.sort.by)? 'up' : 'down'}}" ng-show="expediente.sort.property==='estado'"></span></button></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {{ csrf_field() }}
                <tr ng-repeat="e in expedientes">
                    <td ng-click="test(this,e)">@{{ e.persona.nombre+' '+e.persona.apellidos }}</td>
                    <td ng-click="test(this,e)">@{{ e.persona.ubicacion.provincia.data +', '+ e.persona.ubicacion.canton.data +', '+ e.persona.ubicacion.distrito.data }}</td>
                    <td ng-click="test(this,e)">
                        <span class="record-status record-status-@{{ e.prioridad === 1? 'low' : e.prioridad === 2? 'mid' : e.prioridad === 3? 'hi' : ''}}"></span>
                        <span>@{{ e.prioridad === 1? 'Baja' : e.prioridad === 2? 'Media' : e.prioridad === 3? 'Alta' : ''}}</span>
                    </td>
                    <td ng-click="test(this,e)">@{{e.ayuda.descripcion }}</td>
                    <td ng-click="test(this,e)">@{{ e.estado === 0? 'Aplica' : e.estado === 1? 'No aplica' : e.estado === 2? 'En valoración' : e.estado === 3? 'Pendiente' : ''}}</td>
                    <td>
                        <button type="button" class="btn-rest btn-edit" ng-click="edit(this,p)" data-toggle="modal" data-target="#modal" title="Editar"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button type="button" class="btn-rest btn-delete" ng-click="delete(e,$event)" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- <nav class="text-center" style="padding:0;margin:0">
            <ul uib-pagination ng-model="pagination.page" total-items="pagination.total" max-size="12" items-per-page="16" max-size="pagination.total" class="pagination-sm" ng-change="index(pagination.page)"></ul>
        </nav> --}}
    </div>
