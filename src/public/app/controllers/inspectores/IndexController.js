app.controller('Inspectores_IndexController', function($scope, Inspector, Region, Typeahead, Modal) {

	var showModal = Modal.init('#show_modal',{
			style:         {'overflow-y': 'hidden', 'bottom': '0'},
			onBeforeShow:  function () { $('body').css('overflow-y', 'hidden'); },
			onBeforeClose: function () { $('body').css('overflow-y', 'auto'); },
	});

	$scope.total = 1;
	$scope.page  = 1;

	$scope.filter_data = {
			value:          '',
			filter:         null,
			// active:         false,
			filtered:       false,
			one:            false,
			activo:         $scope.activo[0],
	};

	$scope.inspectores = [];

	$scope.columns = {
			username:      true,
			email:         true,
			cedula:        true,
			nombre:        true,
			apellidos:     true,
			activo:        true,
	};

	$scope.sort = {
			relationship: 'persona',
			by:           'cedula',
			order:        true,
	};


	$scope.filter_init = function(){
      if (!$scope.filter_data.active) {
          $scope.filter_data.active = true;
      }
  };


	// Not supported for Location yet
	$scope.doSort = function (by) {
			$scope.sort.order = ($scope.sort.by === by) ? !$scope.sort.order : true;
			$scope.sort.by = by;

			switch ($scope.sort.by) {
					case 'cedula':
					case 'nombre':
					case 'apellidos':
							$scope.sort.relationship = 'persona'
							break;
				 case 'activo':
							$scope.sort.relationship = 'inspectores'
							break;
					default:
							$scope.sort.relationship = 'usuario'
			}

			console.log($scope.sort);

			$scope.index();
	  };


	  $scope.index = function (page = 1){
		$scope.page = (page < 1) ? 1 : page;

		var params = {
				relationship: $scope.sort.relationship,
				order:        $scope.sort.order ? 'asc': 'desc',
				page:         $scope.page,
				by:           $scope.sort.by,
		};

		if ($scope.filter_data.filtered){
				params.page = $scope.filter_data.one ? 1 : $scope.page;
				$scope.page = params.page;
				$scope.filter_data.one = false;

				if ($scope.search !== '') params.search = $scope.search;
				params = angular.extend(params, jQueryToJson($('#filter'), 'name'));
		}

		Inspector('all').get(
			params,
			function (response) {

				for(var i = 0; i < response.total; i++){
					if(response.inspectores[i].activo == 0)
						response.inspectores[i].activo = 'No';
					else
						response.inspectores[i].activo = 'Si';
				}

				$scope.inspectores = response.inspectores;
				$scope.total = response.total;
			});
		};

		$scope.show = function (obj) {
				obj.editable               = false;
				obj.isSelected             = true;
				obj.persona.editable       = false;
				$scope.selected.isSelected = obj === $scope.selected;
				// scope.ayudas.editable = false;

				var regions = obj.persona.ubicacion.split('/');

				// Get Provincia from list and set to persona
				obj.persona.provincia = Region.find($scope.provincias, 'cod', regions[0]);

				Region.cantones(obj.persona.provincia.cod).then(function (response) {
					$scope.cantones    = Region.parse(response).cantones;
					obj.persona.canton = Region.find($scope.cantones, 'cod', regions[1]);

					Region.distritos(obj.persona.provincia.cod, obj.persona.canton.cod).then(function (response) {
						$scope.distritos     = Region.parse(response).distritos;
						obj.persona.distrito = Region.find($scope.distritos, 'cod', regions[2]);
					});

				$scope.selected = obj;
				showModal.show();

			});
    };

	$scope.filter_activo = function () {
			$scope.search          = '',
      $scope.filter_data.one = true;
      $scope.filter_data.filtered = true;
      $scope.index($scope.page);
			console.log("asdasd");
	};


	$scope.index();

});
