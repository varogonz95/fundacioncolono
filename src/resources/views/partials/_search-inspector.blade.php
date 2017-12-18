<nav class="navbar navbar-default" style="margin-left: 20px; width:1350px; padding-left:15px; padding-right:15px; padding-top:10px" role="navigation">
    <div>
        <!-- buscqueda -->
        <input type="text" placeholder="Buscar" ng-model="search" ng-change="index()" style="width: 300px; height: 30px; padding-left:15px"/>
        <span class="glyphicon glyphicon-search text-muted" style="height: 30px;"></span>
        <!-- filtrar -->
        <button class="btn-outline btn-rest btn-none" ng-init="filter_active = false" ng-click="filter_active = !filter_active; filter_init()"
            style="margin: 0 4px" type="button" data-toggle="collapse" data-target="#filter">
            Filtrar
            <span class="caret" ng-class="{'caret-right': !filter_active}"></span>
        </button>
        <button class="btn-outline btn-rest btn-edit" type="button" ng-show="filter_data.filtered" ng-click="filter_data.filtered = false; search = ''; index();">Ver todos</button>

        <!-- LINK AGREGAR NUEVO USUARIO INSPECTOR -->
        <a class="btn btn-primary btn-sm" href="{{ route('inspectores.create') }}" style="float: right">Agregar nuevo inspector</a>
    </div>
</nav>
