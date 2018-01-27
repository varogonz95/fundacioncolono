
app.controller('Expedientes_OverviewController', function ($scope, $filter, Expediente, AyudaExpediente, Alert, Modal) {

	var modal = Modal.getInstance()/* .applySettings({onAfterClose: function(){ $scope.selected = {}; }}, true) */,
		hasUncommitted = function () {
			for (var i = 0; i < $scope.selected.ayudas.length; i++)
				if ($scope.selected.ayudas[i].editable)
					return true;

			return false;
		};

    $scope.delete = function () {
        Alert.confirm('Archivar expediente', 'Esta operación removerá el expediente de la lista pero no lo eliminará permanentemente.', 'warning')
        .then(function(result) {
            if (result.value)
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
                        Alert.notify(response.title, response.msg, response.type);
                    }
                );
        });
    };

	// Mostrar mensaje de respuesta
	$scope.restore = function () {
		Expediente('restore').$service.post(
			{ id: $scope.selected.id },
			function (response) {
				if (response.status)
					$scope.selected.archivado = false;
				Alert.notify(response.title, response.msg, response.type);
			});
	};

	$scope.updateCaso = function () {
		if (hasUncommitted())
			Alert.notify('Aún tiene cambios sin confirmar.', 'Confirme sus cambios antes de guardar.', 'warning', 3000);

		else
			Alert.confirm(null, '¿Desea incluir los cambios en el histórico?')
				.then(function (result) {

					if (result.value || result.dismiss === 'cancel') {
						$scope.update.caso.fecha_desde = $filter('date')($scope.update.caso.datePickers.from.date, 'yyyy/MM/dd');
						$scope.update.caso.fecha_hasta = $filter('date')($scope.update.caso.datePickers.to.date, 'yyyy/MM/dd');

						Expediente().save(
							{
								id: $scope.selected.id,
								expediente: $scope.update.caso,
								attachs: $scope.update.ayudas.attachs,
								detachs: $scope.update.ayudas.detachs,
								updates: $scope.update.ayudas.updates,
								record: !!result.value
							},
							function (response) {
								if (response.status) {
									delete $scope.update.cache;
									$scope.update.caso = {};
									copy(response.expediente, $scope.selected);
									$scope.selected.datePickers = {
										from: {
											date: $scope.selected.fecha_desde.raw ? new Date($scope.selected.fecha_desde.raw) : new Date(),
											open: false
										},
										to: {
											date: $scope.selected.fecha_hasta.raw ? new Date($scope.selected.fecha_hasta.raw) : new Date(),
											open: false
										}
									};
									$scope.resetAll(false);
								}
								Alert.notify(response.title, response.msg, response.type);
							}
						);
					}
				});
	};

	$scope.updateAyudas = function () {

		if (hasUncommitted())
			Alert.notify('Aún tiene cambios sin confirmar.', 'Confirme sus cambios antes de guardar.', 'warning');
		else
			Alert.confirm(null, '¿Desea incluir los cambios en el histórico?')
			.then(function (result) {
				if (result.value || result.dismiss === 'cancel') {
					AyudaExpediente.$service.post(
						{
								id: $scope.selected.id,
								attachs: $scope.update.ayudas.attachs,
								detachs: $scope.update.ayudas.detachs,
								updates: $scope.update.ayudas.updates,
								record: !!result.value
						},
						function (response) {
							if (response.status) {
									copy(response.expediente, $scope.selected);
									$scope.selected.datePickers = {
										from: {
											date: $scope.selected.fecha_desde.raw ? new Date($scope.selected.fecha_desde.raw) : new Date(),
											open: false
										},
										to: {
											date: $scope.selected.fecha_hasta.raw ? new Date($scope.selected.fecha_hasta.raw) : new Date(),
											open: false
										}
									};
									$scope.resetAll(false);
							}
							Alert.notify(response.title, response.msg, response.type);
						}
					);
				}
			});
	};

    $scope.close = function(){
        $scope.selected = {};
    };

	$scope.resetAll = function (withCache = true) {

		// Set everything back to its initial state

		// Empty update lists
		$scope.update.ayudas.attachs = [];
		$scope.update.ayudas.detachs = [];
		$scope.update.ayudas.updates = [];

		// Reset 'editable' and 'removed' state for all 'ayudas'
		if (withCache)
			for (var i = 0; i < $scope.selected.ayudas.length; i++) {
				$scope.selected.ayudas[i] = $scope.selected.ayudas[i].cache || $scope.selected.ayudas[i];

				// $scope.selected.ayudas[i].editable = false;
				// $scope.selected.ayudas[i].changed = false;
				// $scope.selected.ayudas[i].removed = false;
			}
	};

});
