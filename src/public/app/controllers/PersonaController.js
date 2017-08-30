
/*
*   Controller for entity 'Persona'
*/
app.controller('PersonaController',function($scope,$http,$location){

    var Content = $scope.content,
    Persist = $scope.persist,
    request_method = $location.path().replace('/person/',''),
    modal = $('#personrecords').animatedModal();

    Content.scope=$scope;
    Content.emptyFirst=true;
    Content.target=document.getElementById('sectionheader');

    $scope.provincia = '0';
    $scope.canton = '0';
    $scope.distrito = '0';

    $scope.cantones = [];
    $scope.distritos = [];

    $scope.persona={
        selected:{},
        update:{},

        // Sets default visible columns config for `Person` index
        // if not present in persitance service.
        // If present, then gets the data stored with the specified key
        visible:Persist.get('PersonaController$persona.visible',{
            cedula:true,
            nombre:true,
            apellidos:true,
            ocupacion:true,
            tels:false
        }),

        sort:{
            property:'cedula',
            by:true            // true: 'asc' || false: 'desc'
        }
    };
    $scope.pagination=Persist.get('PersonaController$pagination',{page:1, total:1, last:1});

    Persist.set('PersonaController$persona.visible',$scope.persona.visible, false);

    $scope.show=function(scope, $event){
        $('.personindex > tbody').find('tr').removeClass('selected');
        angular.element($event.target).parent().addClass('selected');
        mergeObjs(scope, $scope.persona.selected, ['$$hashKey']);
        //Persist.set('PersonController$persona.selected',scope, true);
    }

    $scope.save=function(f){

        var insert=function(withrecord){

            //Get data from new person form
            var data = {persona:jQueryToJson($('#personcreate'),'name')};

            // Make post request to server
            $http.post('./person',data).then(
                // If request is successfull
                function(response){
                    console.log('Transaction '+((response.data.personsuccess)?'succeeded!':'failed :('));

                    // If server response is successfull
                    // and insert attempt has new record appended to it
                    if(withrecord && response.data.personsuccess){

                        // Then get data from new record form
                        data.expediente = jQueryToJson($('#recordcreate'),'name');

                        // Make post request
                        $http.post('./records',data).then(
                            function(response){$('#recordcreatemodal').modal('hide');},
                            function(){alert('Something went wrong :(');}
                        );
                    }
                },
                function(){alert('Something went wrong :(');}    // Handle possible server errors
            );
        };

        if (f && !$scope.withrecord) {
            insert(false);
        }
        else if(!f && $scope.withrecord){
            insert($scope.withrecord);
        }
    };

    $scope.edit=function(scope){
        mergeObjs(scope, $scope.persona.selected, ['$$hashKey']);

        var u = $scope.persona.selected.ubicacion.split('/');

        $scope.location.select(u[0],0,$scope);
        $scope.location.select(u[0],u[1],$scope);
        $scope.provincia = u[0];
        $scope.canton = u[1];
        $scope.distrito = u[2];

        $scope.persona.update=scope;
    };

    $scope.update=function(){
        $http.put('./person/'+$scope.persona.selected.cedula,$scope.persona.selected)
        .then(
            function(response){
                console.log('Transaction '+((response.data.result)?'succeeded!':'failed :('));
                mergeObjs($scope.persona.selected, $scope.persona.update, ['$$hashKey']);
                $('#personupdatemodal').modal('hide');
            },
            function(){alert('Something went wrong :(');}    // Handle possible server errors
        );
    };

    $scope.delete=function(scope, $event){
        if (true/*confirm('¿Realmente desea eliminar a esta persona?\n*Esta operación es irreversible')*/) {
            $http.delete('./person/'+scope.cedula+'?page='+$scope.pagination.page,jQueryToJson($('#indexperson'),'name'))
            .then(
                function(response){
                    console.log('Transaction '+((response.data.result)?'succeeded!':'failed :('));
                    $scope.personas.splice($scope.personas.indexOf(scope),1);
                    if($scope.pagination.page !== response.data.last && $scope.personas.length > 0){
                        angular.element(this).remove();
                        $scope.index($scope.pagination.page);
                    }
                    else if ($scope.personas.length === 0) {$scope.index($scope.pagination.page-1);}
                },
                function(){
                    alert('Something went wrong :(');
                }    // Handle possible server errors
            );
        }
    };

    $scope.index=function(page=1){
        $scope.pagination.page=(page < 1)? 1 : page;

        $http.get('./person?page='+page+'&property='+$scope.persona.sort.property+'&by='+($scope.persona.sort.by? 'asc' : 'desc' ))
        .then(
            function(response){
                $scope.personas=response.data.personas;
                $scope.pagination.last = response.data.last;
                $scope.pagination.total = response.data.total;
            },
            function(){alert('Something went wrong :(');}
        );
    };

    $scope.showrec = function(){
        $('#personshowmodal').modal('hide');
        modal.show();
    }

    $scope.sort = function(property){
        $scope.persona.sort.by = ($scope.persona.sort.property === property)? !$scope.persona.sort.by : true;
        $scope.persona.sort.property=property;

        $scope.index();
    }

    switch (request_method) {
        case 'create':
        Content.remote=false;
        Content.template='<span>Ingresar una nueva persona</span> <button class="btn btn-success btn-sm" type="button" ng-click="save(true)" data-toggle="modal" data-target="{{withrecord?\'#recordcreatemodal\':\'\'}}">Guardar registro</button>';
        Content.compile();
        break;

        case 'index':
        Content.remote=true;
        Content.template='./person/header';
        Content.compile();

        $scope.index();
        break;
    }
});
