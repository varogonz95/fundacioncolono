
app.controller('Ayudas_MainController', function ($scope, Alert, AyudaExpediente) {

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

    $scope.commit = function(ayuda){
        ayuda.pivot = ayuda.update.pivot;
        ayuda.pivot.detalle_tmp = ayuda.update.pivot.detalle;

        ayuda.editable = false;
        ayuda.changed = true;

        if (!find('id', ayuda.id, $scope.update.ayudas.updates))
            $scope.update.ayudas.updates.push(ayuda.update);
    };

    $scope.revert = function (ayuda){
        
        // If this 'ayuda' has changed
        // then it's in 'update.ayudas.updates' list
        if (ayuda.changed){
            // remove element from list
            $scope.update.ayudas.updates.splice(getIndex($scope.update.ayudas.updates, ayuda), 1);
            
            // Non-referential copy of 'ayuda.cache' into 'ayuda' object itself
            copy(ayuda.cache, ayuda);
            
            // Set 'changed' state to false
            ayuda.changed = false;
        }
        
        // If not, then it's in 'update.ayudas.detachs' list
        else if (ayuda.removed){
            // remove that element from list
            $scope.update.ayudas.detachs.splice(getIndex($scope.update.ayudas.detachs, ayuda), 1);  

            // Change 'removed' state to false
            ayuda.removed = false;
        }

        // Same logic here...
        else if (ayuda.added) {
            // remove that element from list
            $scope.update.ayudas.attachs.splice(getIndex($scope.update.ayudas.attachs, ayuda), 1);

            // Change 'added' state to false
            ayuda.added = false;
        }
    };    

});
