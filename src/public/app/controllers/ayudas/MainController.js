
/*
*   Controller for entity 'Expediente'
*/
app.controller('Ayudas_MainController', function ($scope, Ayuda) {
    
    $scope.remove = function(ayuda){
        ayuda.removed = true;
        ayuda.editable = true;
        $scope.update.ayudas.detachs.push(ayuda);
    };

    $scope.edit = function(ayuda){
        ayuda.editable = true;
    };

    $scope.cancel = function() {
        
        $scope.update.ayudas.attachs = [];
        $scope.update.ayudas.detachs = [];
        $scope.update.ayudas.updates = [];

        for (var i = 0; i < $scope.selected.ayudas.length; i++) {
            $scope.selected.ayudas[i].editable = false;
            $scope.selected.ayudas[i].removed = false;
        }
    }

});
