
app.controller('Expedientes_OverviewController', function ($scope, $filter, Expediente, AyudaExpediente, Alert, Modal) {

	$scope.items = [];

	var resetAll = function (){
		$scope.update.caso = {};
		$scope.update.persona = {};
		delete $scope.update.cache;

		$scope.selected.editable = false;
		$scope.selected.persona.editable = false;

		$scope.resetAyudas();
	},

	modal = Modal.setSettings({
		onBeforeClose: function() {
			$scope.$apply(resetAll);
			$('body').css('overflow-y', 'auto');
		}}, true),

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
							modal.close(true, function () { $('body').css('overflow-y', 'auto'); });
                        }
                        Alert.notify(response.title, response.msg, response.type);
                    }
                );
        });
    };

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
									$scope.resetAyudas(false);
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
											date: $scope.selected.fecha_desde ? new Date($scope.selected.fecha_desde) : new Date(),
											open: false
										},
										to: {
											date: $scope.selected.fecha_hasta ? new Date($scope.selected.fecha_hasta) : new Date(),
											open: false
										}
									};
									$scope.resetAyudas(false);
							}
							Alert.notify(response.title, response.msg, response.type);
						}
					);
				}
			});
	};

	$scope.resetAyudas = function (withCache = true) {

		console.log($scope.update.ayudas.attachs);
		console.log($scope.items);

		for (var i = 0; i < $scope.update.ayudas.attachs.length; i++)
			$scope.items.push({id:$scope.update.ayudas.attachs[i].id, descripcion:$scope.update.ayudas.attachs[i].descripcion});

		console.log($scope.items);

		// Empty update lists
		$scope.update.ayudas.attachs = [];
		$scope.update.ayudas.detachs = [];
		$scope.update.ayudas.updates = [];

		// Reset 'editable' and 'removed' state for all 'ayudas'
		if (withCache)
			for (var i = 0; i < $scope.selected.ayudas.length; i++) {
				$scope.selected.ayudas[i] = $scope.selected.ayudas[i].cache || $scope.selected.ayudas[i];
				delete $scope.selected.ayudas[i].update;
				delete $scope.selected.ayudas[i].removed;
			}
	};

});
