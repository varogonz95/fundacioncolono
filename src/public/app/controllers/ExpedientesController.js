
/*
*   Controller for entity 'Expediente'
*/
app.controller('ExpedientesController',function($scope,$http,$location){

    var showModal = $('#show_modal').animatedModal({
        onBeforeShow: function(){$('body').css('overflow-y','hidden');},
        onBeforeClose: function(){$('body').css('overflow-y','auto');},
    });

    $scope.selected = {};
    $scope.total = 1;
    $scope.page = 1;
    $scope.sort = {
        by:'cedula',
        order:true,
        filter: function(){}
    };
    $scope.columns = {
        cedula: true,
        nombre: true,
        apellidos: true,
        referente: true
    }

    $scope.index = function(page = 1) {
        $scope.page = (page < 1)? 1 : page;

        $http.get('./expedientes/all?page='+page+'&by='+$scope.sort.by+'&order='+($scope.sort.order? 'asc' : 'desc' )).then(
            function(response){
                // for (var i = 0; i < response.data.expedientes.length; i++) {
                //     var a = response.data.expedientes[i].persona.ubicacion.split('/');
                //     response.data.expedientes[i].persona.ubicacion = $scope.location.getInfo(a[0],a[1],a[2]);
                // }
                $scope.expedientes = response.data.expedientes;
                $scope.total = response.data.total;
            },
            function(){}
        );
    };

    $scope.edit = function(w){
        switch (w) {
            //Expediente
            case 'e':
            $scope.selected.editable = true;
            break;
            //Persona
            case 'p':
            $scope.selected.persona.editable = true;
            break;
            //Ayudas
            case 'a':
            $scope.selected.ayudas = true;
            break;

        }
        console.log($scope.selected);
    };

    $scope.index();

    // var Content = $scope.content,
    // Persist = $scope.persist,
    // request_method = $location.path().replace('/records/','');

    // $scope.pagination = Persist.get('ExpedienteController$pagination',{page:1, total:1, last:1});
    // $scope.expediente = {
    //     sort:{ by:true, property: 'beneficiario'}
    // };

    // $scope.index=function(page=1){
    //     $scope.pagination.page=(page < 1)? 1 : page;
    //
    //     $http.get('./records?page='+page+'&property='+$scope.expediente.sort.property+'&by='+($scope.expediente.sort.by? 'asc' : 'desc' )).then(
    //         function(response){
    //             for (var i = 0; i < response.data.expedientes.length; i++) {
    //                 var a = response.data.expedientes[i].persona.ubicacion.split('/');
    //                 response.data.expedientes[i].persona.ubicacion = $scope.location.getInfo(a[0],a[1],a[2]);
    //             }
    //             $scope.expedientes = response.data.expedientes;
    //         },
    //         function(){}
    //     );
    // };
    //
    $scope.show = function(scope){
        scope.editable = false;
        scope.persona.editable = false;
        // scope.ayudas.editable = false;
        $scope.selected = scope;
        console.log($scope.selected);
        showModal.show();
    };
    $scope.delete = function(){
        if (confirm('¿Realmentemente desea eliminar este expediente?\nEste proceso es irreversible.')) {

        }
    };
    //
    // $scope.test = function(a,b){
    //     $scope.expediente.selected = b;
    //     console.log(b);
    //     $('#recordshowmodal').modal('show');
    // }
    //
    // $scope.append = function(){
    //     //var data = jQueryToJson($('#recordappend'),'name');
    //
    //     $http.post('./records/'+$scope.persona.selected.cedula, jQueryToJson($('#recordappend'),'name')).then(
    //         function(response){
    //             if(response.data.inserted){$scope.persona.selected.expedientes.push(response.data.inserted);}
    //             else {alert(response.data.errorInfo[2]);}
    //         },
    //         function(){alert('Something went wrong :(');}
    //     );
    // };
    //
    // $scope.delete = function(scope, $event){
    //     console.log(scope);
    //     if (true/*confirm('¿Realmente desea eliminar a esta persona?\n*Esta operación es irreversible')*/) {
    //         $http.delete('./records/'+scope.id).then(
    //             function(response){
    //                 console.log(response.data);
    //                 // $scope.personas.splice($scope.personas.indexOf(scope),1);
    //                 // if($scope.pagination.page !== response.data.last && $scope.personas.length > 0){
    //                 //     angular.element(this).remove();
    //                 //     $scope.index($scope.pagination.page);
    //                 // }
    //                 // else if ($scope.personas.length === 0) {$scope.index($scope.pagination.page-1);}
    //             },
    //             function(){
    //                 alert('Something went wrong :(');
    //             }    // Handle possible server errors
    //         );
    //     }
    // };
    //
    // $scope.edit = function(){
    //     //
    // };
    //
    // $scope.update = function(scope,$event){
    //     var data = jQueryToJson($($event.target).parents('.record-content'),'name');
    //     $http.put('./records/'+scope.id, data)
    //     .then(
    //         function(response){
    //             if(response.data.updated){
    //                 data.prioridad = parseInt(data.prioridad);
    //                 mergeObjs(data, scope);
    //                 scope.editable = false;
    //             }
    //             else {
    //                 alert('Something went wrong :(');
    //             }
    //         },
    //         function(){alert('Something went wrong :(');}    // Handle possible server errors
    //     );
    // };
    //
    // // Not supported for Location yet
    // $scope.sort = function(property){
    //     $scope.persona.sort.by = ($scope.persona.sort.property === property)? !$scope.persona.sort.by : true;
    //     $scope.persona.sort.property=property;
    //
    //     $scope.index();
    // }
    //
    // switch (request_method) {
    //     case 'index':
    //     // Content.remote=true;
    //     // Content.template='./person/header';
    //     // Content.compile();
    //     $scope.index();
    //     break;
    // }

});
