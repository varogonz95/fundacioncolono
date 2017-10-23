app.controller('Expedientes_EditController', function ($scope, Expediente, Region, Typeahead) {

    $scope.invalid_add = false;

    $scope.formatter = Typeahead.formatter;
    $scope.ayudas_selected = [{}];

    $scope.cantones = [];
    $scope.distritos = [];

    $scope.estado = $scope.estados[0];
    
    $scope.edit = function (){
        copy($scope.selected, $scope.update.caso, ['editable','persona','ayudas','$$hashKey']);
        
        $scope.update.caso.estado_selected = find('id', $scope.update.caso.estado, $scope.estados);
        $scope.update.caso.prioridad_selected = find('id', $scope.update.caso.prioridad, $scope.prioridades);
        $scope.update.caso.referente_selected = $scope.selected.referente.id;

        $scope.selected.editable = true;
    };

    $scope.commit = function(){

        // Save current state
        $scope.update.cache = $scope.update.cache ? $scope.update.cache : angular.copy($scope.selected);

        // Set Expediente with new data
        
        // parse attributes...
        $scope.update.caso.prioridad = $scope.update.caso.prioridad_selected.id;
        $scope.update.caso.estado = $scope.update.caso.estado_selected.id;
        
        if ($scope.update.caso.hasReferenteOtro) {$scope.update.caso.referente = { id: 1, descripcion: 'Otro o ninguno' };}
        else {
            $scope.update.caso.referente = find('id', $scope.update.caso.referente_selected, $scope.referentes);
            $scope.update.caso.referente_otro = null;
        }

        copy($scope.update.caso, $scope.selected);

        $scope.selected.editable = false;
    }

    $scope.revert = function(){
        copy($scope.update.cache, $scope.selected);

        delete $scope.update.cache;

        $scope.selected.editable = false;
    }

    $scope.updateCaso = function(){

        if (confirm('¿Desea incluir los cambios al histórico?')) {
        }
        else{
            
            Expediente().update(
                $scope.update.caso,
                function (response) {
                    console.log(response);
                    copy($scope.update.caso, $scope.selected);
                },
                function (error) {},
            );

        }
    };

    // Update Canton SELECT
    $scope.updateCantones = function (p) {
        $scope.distritos = [];
        // $scope.canton = null;

        Region.getCantones(p)
            .then(function (response) { $scope.cantones = Region.toList(response.data); });
    };

    // Update Distrito SELECT
    $scope.updateDistritos = function (p, c) {
        Region.getDistritos(p, c)
            .then(function (response) { $scope.distritos = Region.toList(response.data); });
    }

    $scope.ayudaChanged = function (scope, index) {
        $scope.invalid_add = false;

        // Revisar en las ayudas seleccionadas
        for (var i = 0; i < $scope.ayudas_selected.length; i++) {

            // Si el elemento de la lista es igual al de la iteracion
            // entonces que lo salte
            if (i === index) { continue; }

            // Sino, si el id del objeto seleccionado
            // es igual al id del elemento de la lista en i
            // entonces el elemento ya se encuentra seleccionado,
            // por lo tanto es invalido
            else if (scope.id === $scope.ayudas_selected[i].id) {
                scope.$invalid = true;
                break;
            }
        }
    };

    $scope.addAyuda = function () {
        if ($scope.ayudas_selected[$scope.ayudas_selected.length - 1].id && !$scope.ayudas_selected[$scope.ayudas_selected.length - 1].$invalid) {
            $scope.invalid_add = false;
            $scope.ayudas_selected.push({});
        }
        else {
            $scope.invalid_add = true;
        }
    };

    $scope.removeAyuda = function (scope) {
        $scope.ayudas_selected.splice(getIndex($scope.ayudas_selected, scope), 1);
    };

});
