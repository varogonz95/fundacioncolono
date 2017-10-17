
/*
*   Controller for entity 'Expediente'
*/
app.controller('Ayudas_MainController', function ($scope, Ayuda) {
    
    $scope.remove = function(ayuda){
        ayuda.removed = true;
        $scope.update.ayudas.detachs.push(ayuda);
    };

    $scope.edit = function(ayuda){
        ayuda.update = angular.copy(ayuda);
        ayuda.cache = ayuda.cache? ayuda.cache : angular.copy(ayuda);
        ayuda.editable = true;
    };

    $scope.cancel = function (ayuda) {
        ayuda.editable = false;
        ayuda.update = null;
    };

    $scope.cancelAll = function() {
        
        // Set everything back to its initial state

        // Empty update lists
        $scope.update.ayudas.attachs = [];
        $scope.update.ayudas.detachs = [];
        $scope.update.ayudas.updates = [];

        // Reset editable and removed state for all 'ayudas'
        console.log($scope.selected.ayudas);
        for (var i = 0; i < $scope.selected.ayudas.length; i++) {
            $scope.selected.ayudas[i] = $scope.selected.ayudas[i].cache || $scope.selected.ayudas[i];
            $scope.selected.ayudas[i].editable = false;
            $scope.selected.ayudas[i].removed = false;
        }
    };

    $scope.updateAyuda = function(ayuda){
        ayuda.pivot = ayuda.update.pivot;
        ayuda.pivot.detalle_tmp = ayuda.update.pivot.detalle;

        ayuda.editable = false;
        $scope.update.ayudas.updates.push(ayuda);
    };

});
