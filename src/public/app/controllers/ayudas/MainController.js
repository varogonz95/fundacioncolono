
/*
*   Controller for entity 'Expediente'
*/
app.controller('Ayudas_MainController', function ($scope, $http, AyudaExpediente) {
    
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
        delete ayuda.update;
    };

    $scope.cancelAll = function() {
        
        // Set everything back to its initial state

        // Empty update lists
        $scope.update.ayudas.attachs = [];
        $scope.update.ayudas.detachs = [];
        $scope.update.ayudas.updates = [];

        // Reset 'editable' and 'removed' state for all 'ayudas'
        console.log($scope.selected.ayudas);
        for (var i = 0; i < $scope.selected.ayudas.length; i++) {
            $scope.selected.ayudas[i] = $scope.selected.ayudas[i].cache || $scope.selected.ayudas[i];
            $scope.selected.ayudas[i].editable = false;
            $scope.selected.ayudas[i].removed = false;
        }
    };

    $scope.commit = function(ayuda){
        ayuda.pivot = ayuda.update.pivot;
        ayuda.pivot.detalle_tmp = ayuda.update.pivot.detalle;

        ayuda.editable = false;
        $scope.update.ayudas.updates.push(ayuda);
    };

    $scope.revert = function (ayuda){
        
        console.log(find('id', ayuda.id, ayuda.removed ? $scope.update.ayudas.detachs : ayuda.cache ? $scope.update.ayudas.updates : []));
        ayuda = ayuda.cache;
        delete ayuda.cache;
    }

    $scope.updateAll= function(){

        AyudaExpediente.update(
            {
                expediente: $scope.selected.id,
                ayudas: $scope.update.ayudas
            },
            function (response) {
                console.log(response);
            }
        );

    };

});
