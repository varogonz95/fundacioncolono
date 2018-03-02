app.controller('Inspectores_IndexController', function($scope, Inspector, Region, Typeahead, Modal) {

	var showModal = Modal.init('#show_modal',{
			style:         {'overflow-y': 'hidden', 'bottom': '0'},
			onBeforeShow:  function () { $('body').css('overflow-y', 'hidden'); },
			onBeforeClose: function () { $('body').css('overflow-y', 'auto'); },
	});

	$scope.total = 1;
	$scope.page  = 1;

	$scope.filter_data = {
		value:     '',
		filter:    null,
		// active: false,
		filtered: false,
		one:      false,
	};

	$scope.inspectores = [];

	$scope.columns = {
			ubicacion:     true,
			email:         true,
			cedula:        true,
			nombre:        true,
			apellidos:     true,
			activo:        true,
			observaciones: true,
			fecha_visita:  true,
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
					case 'ubicacion':
						$scope.sort.relationship = 'persona'
						break;
					 case 'activo':
						 $scope.sort.relationship = 'inspector'
					     break;
					 case 'estado':
						 $scope.sort.relationship = 'expediente'
					     break;
					default:
						$scope.sort.relationship = 'usuario'
			}
			$scope.index();
	  };


	  $scope.index = function (page = 1){
		$scope.page = page;

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
				$scope.inspectores = response.inspectores;
				$scope.total = response.total;
			});
		};

	$scope.show = function (obj) {
			obj.editable               = false;
			obj.isSelected             = true;
			obj.persona.editable       = false;
			$scope.selected.isSelected = obj === $scope.selected;
		
			copy(obj, $scope.selected);
			showModal.show();
	};

	$scope.filter_activo = function () {
	  $scope.search          = '',
      $scope.filter_data.one = true;
      $scope.filter_data.filtered = true;
      $scope.index($scope.page);
	};


	$scope.index();
});
