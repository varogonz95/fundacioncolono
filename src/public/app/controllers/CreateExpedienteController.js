app.controller('CreateExpedienteController', function($scope, $http) {

    $scope.ayudas = [];
    $scope.ayudas_selected = [{}];
    $scope.prioridades = [
        {value:1, name:'Baja'},
        {value:2, name:'Media'},
        {value:3, name:'Alta'}
    ];
    $scope.estados = [
        {value:0, name:'En valoración (por defecto)'},
        {value:1, name:'Aprobado'},
        {value:2, name:'No aprobado'}
    ];
    $scope.estado = {value:0, name:'En valoración (por defecto)'};

    $scope.checkNullity = function(arr){

        for (var i = 0; i < arr.length; i++) {
            if (arr[i] === null || arr[i] === copy(arr[i], ['$$hashKey'])) {
                console.log('yep');
                return true;
            }
        }

        console.log('nope');
        return false;
    };

    $scope.changed = function(scope, index){

        // Revisar en las ayudas seleccionadas
        for (var i = 0; i < $scope.ayudas_selected.length; i++) {
            if (i === index) { continue; }
            else if (scope.id === $scope.ayudas_selected[i].id) {
                $scope.newexpediente.$invalid = true;
                scope.$invalid = true;
                break;
            }
        }

    };

    $scope.add = function() {
        if (!$scope.checkNullity($scope.ayudas_selected)) {
            $scope.ayudas_selected.push({});
        }
    };

    $scope.remove = function(scope){
        $scope.ayudas_selected.splice(getIndex($scope.ayudas_selected, scope),1);
    };

    var init = function(){
        $http.get('../ayudas').then(
            function(response){
                $scope.ayudas = response.data;
                console.log(response.data);
            },
            function(error){}
        );
    };

    init();

});
