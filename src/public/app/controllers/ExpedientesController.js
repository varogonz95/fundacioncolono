
/*
*   Controller for entity 'Expediente'
*/
app.controller('ExpedientesController',function($scope, $http, Referente, Ayuda, Region){

    var showModal = $('#show_modal').animatedModal({
        onBeforeShow: function(){$('body').css('overflow-y','hidden');},
        onBeforeClose: function(){$('body').css('overflow-y','auto');},
    });

    $scope.ayudas = Ayuda().query();
    $scope.referentes = Referente().query();
    $scope.referente_selected = {};
    $scope.estados = [
        {id:0, name:'En valoración (por defecto)'},
        {id:1, name:'Aprobado'},
        {id:2, name:'No aprobado'}
    ];
    $scope.prioridades = [
        {id:1, name:'Baja'},
        {id:2, name:'Media'},
        {id:3, name:'Alta'}
    ];

    $scope.provincias = Region.getProvincias();
    $scope.cantones = [];
    $scope.distritos = [];
    
    $scope.selected = {};
    $scope.update = {
        persona:{},
        caso:{},
        ayudas:{
            attachs:[],
            detachs:[]
        }
    };

    $scope.total = 1;
    $scope.page = 1;

    $scope.sort = {
        by:'cedula',
        order:true,
        filter: function(){}
    };
    // Not supported for Location yet
    $scope.doSort = function(by){
        $scope.sort.order = ($scope.sort.by === by) ? !$scope.sort.order : true;
        $scope.sort.by=by;
    
        $scope.index();
    };

    $scope.columns = {
        cedula: true,
        nombre: true,
        apellidos: true,
        prioridad: true,
        referente: true,
        ayuda: true
    }

    $scope.test = function(val) {
        console.log(val);
    }

    $scope.index = function(page = 1, params = {}) {

        $scope.page = (page < 1)? 1 : page;

        paramsString = '';

        for (var key in params) {
            paramsString += '&'+key+'='+params[key];
        }

        $http.get(
            './expedientes/all?'
            +'page='+page
            +'&by='+$scope.sort.by
            +'&order='+($scope.sort.order? 'asc' : 'desc' )
            +paramsString
        ).then(
            function(response){
                $scope.expedientes = response.data.expedientes;
                $scope.total = response.data.total;
                console.log($scope.expedientes);
            },
            function(){}
        );
    };

    $scope.edit = function(w){
        switch (w) {
            //Expediente
            case 'e':
            $scope.selected.editable = true;
            $scope.update.caso = copy($scope.selected, ['editable','persona','ayudas','$$hashKey']);
            $scope.estado_selected = $scope.estados[$scope.selected.estado];

            $scope.prioridad_selected = $scope.prioridades[$scope.selected.prioridad - 1];
            $scope.referente_selected = $scope.selected.referente;
            break;

            //Persona
            case 'p':
            $scope.selected.persona.editable = true;
            $scope.update.persona = copy($scope.selected.persona, ['editable']);
            break;

            //Ayudas
            case 'a':
            $scope.selected.ayudas = true;
            break;

        }
    };

    $scope.updateCaso = function(obj){

        console.log('Updating caso with data:');
        console.log(obj);
        // console.log(jQueryToJson($('#selectedexpediente'), 'name'));

        $http.put('./expedientes/'+$scope.selected.id, obj).then(
            function(response){
                if(response.data.status){
                    $scope.selected = copy($scope.update.caso);
                    $scope.selected.editable = false;
                }
                else { alert(response.data.msg); }
            },
            function(error){ alert(error.data.message); }
        );
    };

    $scope.updatePersona = function(obj){

        console.log('Updating persona with data:');
        console.log(obj);

        $http.put('./personas/'+$scope.selected.persona.cedula, obj).then(
            function(response){
                if(response.data.status){
                    $scope.selected.persona = copy($scope.update.persona);
                    $scope.selected.persona.editable = false;
                }
                else { alert(response.data.msg); }
            },
            function(error){alert(error.data.message);}
        );
    };

    $scope.show = function(obj){
        obj.editable = false;
        obj.isSelected = true;
        obj.persona.editable = false;
        $scope.selected.isSelected = false;
        // scope.ayudas.editable = false;

        var regions = obj.persona.ubicacion.split('/');

        // Get Provincia from list and set to persona
        obj.persona.provincia = Region.find($scope.provincias, 'cod', regions[0]);

        Region.getCantones(obj.persona.provincia.cod).then(function(response){
            $scope.cantones = Region.toList(response.data);
            obj.persona.canton = Region.find($scope.cantones, 'cod', regions[1]);
            
            Region.getDistritos(obj.persona.provincia.cod, obj.persona.canton.cod).then(function(response){
                $scope.distritos = Region.toList(response.data);
                obj.persona.distrito = Region.find($scope.distritos, 'cod', regions[2]);
            });
        });

        $scope.selected = obj;
        showModal.show();
        console.log($scope.selected);
    };

    $scope.delete = function(){
        if (confirm('¿Realmentemente desea eliminar este expediente?\nEste proceso es irreversible.')) {
            $http.delete('./expedientes/'+$scope.selected.id).then(
                function(response){
                    if (response.data.status) {
                        showModal.close();
                        $scope.expedientes.splice(getIndex($scope.expedientes, $scope.selected),1);
                        $scope.selected = {};

                        if($scope.page !== response.data.last && $scope.expedientes.length > 0){ $scope.index($scope.page); }
                        else if ($scope.expedientes.length === 0) { $scope.index($scope.page - 1); }

                        alert('Deleted successfully');
                    }
                },
                function(error) {
                    alert(error.data.message);
                }
            );
        }
    };

    // Update Canton SELECT
    $scope.updateCantones = function(p){
        $scope.distritos = [];
        $scope.update.persona.canton = null;

        Region.getCantones(p)
        .then(function(response){ $scope.cantones = Region.toList(response.data);});
    };

    // Update Distrito SELECT
    $scope.updateDistritos = function(p, c){
        Region.getDistritos(p, c)
        .then(function(response){ $scope.distritos = Region.toList(response.data); });
    }

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
    //                 copy(data, scope);
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
