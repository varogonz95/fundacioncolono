app.controller('Expedientes_EditController', function ($scope, Expediente, Typeahead) {

    $scope.invalid_add = false;

    $scope.formatter = Typeahead.formatter;

    $scope.cantones = [];
    $scope.distritos = [];

    $scope.estado = $scope.estados[0];
    
    $scope.edit = function (){
        copy($scope.selected, $scope.update.caso, ['editable','persona','ayudas','$$hashKey']);
        console.log($scope.update.caso);

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
        $scope.update.caso.fecha_desde.formatted = $scope.update.caso.datePickers.from.date.toLocaleDateString();
        $scope.update.caso.fecha_hasta.formatted = $scope.update.caso.datePickers.to.date.toLocaleDateString();
        
        if ($scope.update.caso.hasReferenteOtro) {$scope.update.caso.referente = { id: 1, descripcion: 'Otro o ninguno' };}
        else {
            $scope.update.caso.referente = find('id', $scope.update.caso.referente_selected, $scope.referentes);
            $scope.update.caso.referente_otro = null;
        }

        copy($scope.update.caso, $scope.selected);

        $scope.selected.editable = false;
    };

    $scope.revert = function(){
        copy($scope.update.cache, $scope.selected);

        delete $scope.update.cache;

        $scope.selected.editable = false;
    };

});
