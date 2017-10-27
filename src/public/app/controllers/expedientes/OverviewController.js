
app.controller('Expedientes_OverviewController', function ($scope, Alert, AyudaExpediente) {

    var hasUncommitted = function () {
        for (var i = 0; i < $scope.selected.ayudas.length; i++)
            if ($scope.selected.ayudas[i].editable)
                return true;

        return false;
    };

    $scope.delete = function () {
        if (confirm('¿Realmente desea eliminar este expediente?\nEsta acción es irreversible.'))
            Expediente().delete({ id: $scope.selected.persona.cedula },
                function (response) {
                    if (response.status) {
                        showModal.close();
                        $scope.expedientes.splice(getIndex($scope.expedientes, $scope.selected), 1);
                        $scope.selected = {};

                        if ($scope.page !== response.last && $scope.expedientes.length > 0) { $scope.index($scope.page); }
                        else if ($scope.expedientes.length === 0) { $scope.index($scope.page - 1); }

                        alert('Deleted successfully');
                    }
                },
                function (error) { alert(error.message); }
            );
    };

    $scope.updateCaso = function () {
        Alert.confirm('¿Desea incluir los cambios en el histórico?')
            .then(function (value) {
                $scope.update.caso.record = value;
                Expediente().update(
                    $scope.update.caso,
                    function (response) {
                        copy($scope.update.caso, $scope.selected);
                        Alert.notify(
                            response.title,
                            response.msg,
                            response.status ? 'success' : 'error'
                        );
                    },
                    function (error) { },
                );

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
            AyudaExpediente.$service.post(
                {
                    expedienteId: $scope.selected.id,
                    ayudas: $scope.update.ayudas,
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
                },
                function (error) { }
            );
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
            if ($scope.selected.ayudas[i].removed) {
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
