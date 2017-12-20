
app.controller('Expedientes_OverviewController', function ($scope, Expediente, AyudaExpediente, Alert, Modal) {

    var modal = Modal.getInstance(),
    hasUncommitted = function () {
        for (var i = 0; i < $scope.selected.ayudas.length; i++)
            if ($scope.selected.ayudas[i].editable)
                return true;

        return false;
    };

    $scope.delete = function () {
        Alert.confirm(
            'Archivar expediente', 
            'Esta operación removerá el expediente de la lista pero no lo eliminará permanentemente.',
            'warning'
        )
        .then(function(value) {
            if (value)
                Expediente().delete({ id: $scope.selected.id },
                    function (response) {
                        if (response.status) {
                            $scope.expedientes.splice(getIndex($scope.expedientes, $scope.selected), 1);

                            if ($scope.page !== response.last && $scope.expedientes.length > 0) 
                                $scope.index($scope.page);
                            else if ($scope.expedientes.length === 0)
                                $scope.index($scope.page - 1);

                            modal.close();
                        }
                        Alert.notify(response.msg, null, response.status ? 'success' : 'error');
                    },
                    function (error) { alert(error.message); }
                );
        });
    };

    $scope.restore = function(){
        Expediente('restore').$service.post(
            {id: $scope.selected.id},
            function (response) {
                $scope.selected.archivado = !response.status;
        });
    };

    $scope.updateCaso = function () {
        if (hasUncommitted())
            Alert.notify(
                'Aún tiene cambios sin confirmar.',
                'Confirme sus cambios antes de guardar.',
                'warning'
            );
        else
            Alert.confirm('¿Desea incluir los cambios en el histórico?')
            .then(function (value) {
                if (value !== null){

                    $scope.update.caso.fecha_desde = $scope.update.caso.datePickers.from.date.toLocaleDateString();
                    $scope.update.caso.fecha_hasta = $scope.update.caso.datePickers.to.date.toLocaleDateString();

                    Expediente().save(
                        {
                            id: $scope.selected.id,
                            expediente: $scope.update.caso,
                            attachs: $scope.update.ayudas.attachs,
                            detachs: $scope.update.ayudas.detachs,
                            updates: $scope.update.ayudas.updates,
                            record: value
                        },
                        function (response) {
                            if (response.status){
                                delete $scope.update.cache;
                                $scope.update.caso = {};
                                $scope.selected = response.data

                                $scope.cancelAll(false);
                            }
                            Alert.notify(
                                response.title,
                                response.msg,
                                response.status ? 'success' : 'error'
                            );
                        },
                        function (error) { },
                    );
                }
            });
    };
    
    $scope.updateAyudas = function () {
        
        if (hasUncommitted())
            Alert.notify(
                'Aún tiene cambios sin confirmar.',
                'Confirme sus cambios antes de guardar.',
                'warning'
            );
        else
            Alert.confirm('¿Desea incluir los cambios en el histórico?')
            .then(function (value) {
                if(value !== null){
                    console.log(value);
                    AyudaExpediente.$service.post(
                        {
                            id: $scope.selected.id,
                            attachs: $scope.update.ayudas.attachs,
                            detachs: $scope.update.ayudas.detachs,
                            updates: $scope.update.ayudas.updates,
                            record: value
                        },
                        function (response) {
                            if (response.status)
                                $scope.cancelAll(false);
                            Alert.notify(
                                response.title,
                                response.msg,
                                response.status ? 'success' : 'error'
                            );
                        }
                    );
                }
            });
    };
    
    $scope.cancelAll = function (withCache = true) {

        // Set everything back to its initial state

        // Empty update lists
        $scope.update.ayudas.attachs = [];
        $scope.update.ayudas.detachs = [];
        $scope.update.ayudas.updates = [];

        // Reset 'editable' and 'removed' state for all 'ayudas'
        for (var i = 0; i < $scope.selected.ayudas.length; i++) {
            if ($scope.selected.ayudas[i].removed && !withCache) {
                $scope.selected.ayudas.splice(i, 1);
                i--;
            }
            else {

                if (withCache)
                    $scope.selected.ayudas[i] = $scope.selected.ayudas[i].cache || $scope.selected.ayudas[i];
                else
                    delete $scope.selected.ayudas[i].cache;

                $scope.selected.ayudas[i].editable = false;
                $scope.selected.ayudas[i].changed = false;
                $scope.selected.ayudas[i].removed = false;
            }
        }
    };
    
});
