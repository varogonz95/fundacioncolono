<article id="selectedexpediente" class="col-md-10 col-md-offset-1 ng-scope" >
    <div>
        <header>
            <h3>
                Expedientes Asignados
                <button class="btn btn-sm btn-show btn-outline">
                    <span class="glyphicon glyphicon-plus"></span>
                    Asignar expediente
                </button>
            </h3>
        </header>
        <!-- TABLA DE visitas -->
        <div class="table-responsive col-md-12" style='overflow-x: hidden;overflow-y: auto'>
            <table id="visitasIndex" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th ng-show="columns.cedula">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('cedula')">
                                Cédula <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'cedula'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.nombre">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('nombre')">
                                Nombre <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'nombre'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.apellidos">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('apellidos')">
                                Apellidos <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'apellidos'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.ubicacion">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('ubicacion')">
                                Ubicación <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'ubicacion'}"></span>
                            </button>
                        </th>
                        <th ng-show="columns.observaciones">
                            <button type="button" class="btn btn-table-header">Observaciones</button>    
                        </th>
                        <th ng-show="columns.fecha_visita">
                            <button type="button" class="btn btn-table-header" ng-class="{'asc': sort.order, 'desc': !sort.order}" ng-click="doSort('fecha_visita')">
                                Fecha de la visita <span class="glyphicon" ng-class="{'glyphicon-menu-down': sort.by === 'fecha_visita'}"></span>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-class="{'active' : v.isSelected}" ng-repeat="visita in selected.visitas" ng-click="alertDelete(visita)">
                        <td ng-show="columns.cedula">@{{ visita.expediente.persona.cedula }}</td>
                        <td ng-show="columns.nombre">@{{ visita.expediente.persona.nombre }}</td>
                        <td ng-show="columns.apellidos">@{{ visita.expediente.persona.apellidos }}</td>
                        <td ng-show="columns.ubicacion" region-text path="visita.expediente.persona.ubicacion"></td>
                        <td ng-show="columns.observaciones">@{{ visita.observaciones }}</td>
                        <td ng-show="columns.fecha_visita">@{{ visita.fecha_visita }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</article>