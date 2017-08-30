<span class="col-sm-5 text-right">Personas registradas</span>
<form method="get" class="col-sm-4 async" ng-submit="index">
    <div class="input-group input-group-sm">
        <input type="text" class="form-control" placeholder="Término de búsqueda...">
        <div class="input-group-btn">
           <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="glyphicon glyphicon-search"></span></button>
           <ul class="dropdown-menu">
               <li class="dropdown-header" style="font-weight:bold">Buscar por:</li>
               <li><div class="checkbox"><label class="text-left"><input name="" type="checkbox" ng-true-value="true" ng-false-value="false"> Identificación</label></div></li>
               <li><div class="checkbox"><label class="text-left"><input name="" type="checkbox" ng-true-value="true" ng-false-value="false"> Nombre</label></div></li>
               <li><div class="checkbox"><label class="text-left"><input name="" type="checkbox" ng-true-value="true" ng-false-value="false"> Apellidos</label></div></li>
               <li><div class="checkbox"><label class="text-left"><input name="" type="checkbox" ng-true-value="true" ng-false-value="false"> Region</label></div></li>
               <li><div class="checkbox"><label class="text-left"><input name="" type="checkbox" ng-true-value="true" ng-false-value="false"> Filtro2</label></div></li>
               <li><div class="checkbox"><label class="text-left"><input name="" type="checkbox" ng-true-value="true" ng-false-value="false"> Filtro3</label></div></li>
           </ul>
        </div>
    </div>
</form>
