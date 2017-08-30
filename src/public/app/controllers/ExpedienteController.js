
/*
*   Controller for entity 'Expediente'
*/
app.controller('ExpedienteController',function($scope,$http,$location){

    var Content = $scope.content,
    Persist = $scope.persist,
    request_method = $location.path().replace('/records/','');

    $scope.pagination = Persist.get('ExpedienteController$pagination',{page:1, total:1, last:1});
    $scope.expediente = {
        sort:{ by:true, property: 'beneficiario'}
    };

    $scope.index=function(page=1){
        $scope.pagination.page=(page < 1)? 1 : page;

        $http.get('./records?page='+page+'&property='+$scope.expediente.sort.property+'&by='+($scope.expediente.sort.by? 'asc' : 'desc' )).then(
            function(response){
                for (var i = 0; i < response.data.expedientes.length; i++) {
                    var a = response.data.expedientes[i].persona.ubicacion.split('/');
                    response.data.expedientes[i].persona.ubicacion = $scope.location.getInfo(a[0],a[1],a[2]);
                }
                $scope.expedientes = response.data.expedientes;
            },
            function(){}
        );
    };

    $scope.show = function(){
        $('#recordappendmodal').modal('show');
    };

    $scope.test = function(a,b){
        $scope.expediente.selected = b;
        console.log(b);
        $('#recordshowmodal').modal('show');
    }

    $scope.append = function(){
        //var data = jQueryToJson($('#recordappend'),'name');

        $http.post('./records/'+$scope.persona.selected.cedula, jQueryToJson($('#recordappend'),'name')).then(
            function(response){
                if(response.data.inserted){$scope.persona.selected.expedientes.push(response.data.inserted);}
                else {alert(response.data.errorInfo[2]);}
            },
            function(){alert('Something went wrong :(');}
        );
    };

    $scope.delete = function(scope, $event){
        console.log(scope);
        if (true/*confirm('¿Realmente desea eliminar a esta persona?\n*Esta operación es irreversible')*/) {
            $http.delete('./records/'+scope.id).then(
                function(response){
                    console.log(response.data);
                    // $scope.personas.splice($scope.personas.indexOf(scope),1);
                    // if($scope.pagination.page !== response.data.last && $scope.personas.length > 0){
                    //     angular.element(this).remove();
                    //     $scope.index($scope.pagination.page);
                    // }
                    // else if ($scope.personas.length === 0) {$scope.index($scope.pagination.page-1);}
                },
                function(){
                    alert('Something went wrong :(');
                }    // Handle possible server errors
            );
        }
    };

    $scope.edit = function(){
        //
    };

    $scope.update = function(scope,$event){
        var data = jQueryToJson($($event.target).parents('.record-content'),'name');
        $http.put('./records/'+scope.id, data)
        .then(
            function(response){
                if(response.data.updated){
                    data.prioridad = parseInt(data.prioridad);
                    mergeObjs(data, scope);
                    scope.editable = false;
                }
                else {
                    alert('Something went wrong :(');
                }
            },
            function(){alert('Something went wrong :(');}    // Handle possible server errors
        );
    };

    // Not supported for Location yet
    $scope.sort = function(property){
        $scope.persona.sort.by = ($scope.persona.sort.property === property)? !$scope.persona.sort.by : true;
        $scope.persona.sort.property=property;

        $scope.index();
    }

    switch (request_method) {
        case 'index':
        // Content.remote=true;
        // Content.template='./person/header';
        // Content.compile();
        $scope.index();
        break;
    }

});
