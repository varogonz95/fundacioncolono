app.controller('Inspectores_EditController', function ($scope, Inspector, Usuario, Alert, Typeahead, Modal) {

  var modal = Modal.getInstance(),
  hasUncommitted = function () {
      return true;
  };

  $scope.visible = false;

  $scope.invalid_add = false;

  $scope.formatter = Typeahead.formatter;

  $scope.cantones = [];
  $scope.distritos = [];

  $scope.edit = function (){
      $scope.selected.editable = true;
      $scope.update.usuario  = copy($scope.selected.usuario,['editable']);
  };

  $scope.modificarEstado = function () {
      Alert.confirm(
          $scope.selected.activo == 'Si' ? 'Deshabilitar' : 'Habilitar' ,
          'Esta operación pasará al inspector a estado ' + ($scope.selected.activo == 'Si' ? 'inactivo' : 'activo'),
          'warning'
      )
      .then(function(value) {
          if (value)
              Inspector().update(
                {
                  id: $scope.selected.id,
                  estado: $scope.selected.activo,
                },
                  function (response) {
                      if (response.status) {
                          $scope.index();
                          modal.close();
                      }
                      Alert.notify(response.msg, null, response.status ? 'success' : 'error');
                  },
                  function (error) { alert(error.message); }
              );
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
