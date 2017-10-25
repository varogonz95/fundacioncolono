
/*
*   Controller for entity 'Expediente'
*/
app.controller('Ayudas_MainController', function ($scope, $http, AyudaExpediente) {
    
    var hasUncommitted = function(){
        for (var i = 0; i < $scope.selected.ayudas.length; i++)
            if($scope.selected.ayudas[i].editable)
                return true;

        return false;
    };

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

    $scope.cancelAll = function(withCache = true) {
        
        // Set everything back to its initial state

        // Empty update lists
        $scope.update.ayudas.attachs = [];
        $scope.update.ayudas.detachs = [];
        $scope.update.ayudas.updates = [];

        // Reset 'editable' and 'removed' state for all 'ayudas'
        for (var i = 0; i < $scope.selected.ayudas.length; i++) {
            if ($scope.selected.ayudas[i].removed){
                $scope.selected.ayudas.splice(i, 1);
                i--;
            }
            else if (withCache) {
                $scope.selected.ayudas[i] = $scope.selected.ayudas[i].cache || $scope.selected.ayudas[i];
                $scope.selected.ayudas[i].editable = false;
                $scope.selected.ayudas[i].changed = false;
                $scope.selected.ayudas[i].removed = false;
            }
            else{
                $scope.selected.ayudas[i].editable = false;
                $scope.selected.ayudas[i].changed = false;
                $scope.selected.ayudas[i].removed = false;
                delete $scope.selected.ayudas[i].cache;
            }
        }
    };

    $scope.commit = function(ayuda){
        ayuda.pivot = ayuda.update.pivot;
        ayuda.pivot.detalle_tmp = ayuda.update.pivot.detalle;

        ayuda.editable = false;
        ayuda.changed = true;

        if (!find('id', ayuda.id, $scope.update.ayudas.updates))
            $scope.update.ayudas.updates.push(ayuda);
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

        console.log($scope.update.ayudas);
    }

    $scope.updateAll= function(){

        if (hasUncommitted())
            swal({
                title: 'Aún tiene cambios sin confirmar.',
                text: 'Confirme sus cambios antes de guardar.',
                icon: 'warning',
                buttons: false,
                timer: 2000
            });
        else
            swal({
                text: "¿Desea incluir los cambios en el histórico?",
                icon: "info",
                buttons: ['Cancelar', 'Confirmar'],
            })
            .then(function(value){
                AyudaExpediente.$service.post(
                    {
                        expedienteId: $scope.selected.id,
                        ayudas:$scope.update.ayudas,
                        record: value !== null? value : false
                    },
                    function(response){
                        if (response.status) {
                            $scope.cancelAll(false);
                        }
                        swal({
                            title: response.title,
                            text: response.msg,
                            icon: response.status? 'success' : 'error',
                            buttons: false,
                            timer: 2500
                        });
                    },
                    function(error){}
                );
            });
    };

});
