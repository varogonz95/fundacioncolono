app.controller('Inspectores_EditController', function ($scope, Inspector, Usuario, Alert, Typeahead, Modal) {

  var modal = Modal.getInstance(),
  hasUncommitted = function () {
      return true;
  };

  $scope.visible = false;

  $scope.invalid_add = false;

  $scope.cantones = [];
  $scope.distritos = [];

  $scope.edit = function (){
      $scope.selected.editable = true;
    //   $scope.update.usuario  = copy($scope.selected.usuario,['editable']);
  };

  $scope.delete = function () {
	Alert.confirm('Desactivar inspector', 'Esta operación removerá el expediente de la lista pero no lo eliminará permanentemente.', 'warning')
	.then(function (result) {
		if (result.value || result.dismiss === 'cancel') {
			Inspector().delete(
				{id: $scope.selected.id},
				function (response) {
					if (response.status) {
						$scope.inspectores.splice(getIndex($scope.inspectores, $scope.selected), 1);
                        if ($scope.page !== response.last && $scope.inspectores.length > 0) 
                            $scope.index($scope.page);
                        else if ($scope.inspectores.length === 0)
							$scope.index($scope.page - 1);
						modal.close(true, function () { $('body').css('overflow-y', 'auto'); });
					}
					Alert.notify(response.title, response.msg, response.type);
				}
			);
		}
	});
};

  $scope.mostrarPassword = function (){
      if($scope.visible){
        $scope.visible = false;
      }else{
        $scope.visible = true;
      }
  };

  $scope.updateUsuario = function () {
      console.log($scope.update.usuario.email);
      Usuario.save(
          {
              id: $scope.selected.usuario.id,
              data: $scope.update.usuario,
          },
          function (response) {
              if (response.status) {
                console.log('selected.usuario');
                console.log($scope.selected.usuario);
                console.log('will become');
                console.log($scope.update.usuario);
                console.log('final data');
                console.log(copy($scope.update.usuario, $scope.selected.usuario));
                console.log($scope.selected.usuario);
                console.log($scope.update.usuario);

                $scope.selected.editable = false;
              }
              else { alert(response.msg); }
          },
          function (error) { alert(error.data.message); }
      );
  };

});
