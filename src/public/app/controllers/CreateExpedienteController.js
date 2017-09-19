app.controller('CreateExpedienteController', function($scope, $http) {

    $scope.submit = function() {
        console.log($scope.ayudas_selected);
    };

    $scope.invalid_add = false;
    $scope.submitting = false;
    $scope.referentes = [];
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

    $scope.changed = function(scope, index){
        $scope.invalid_add = false;

        // Revisar en las ayudas seleccionadas
        for (var i = 0; i < $scope.ayudas_selected.length; i++) {

            // Si el elemento de la lista es igual al de la iteracion
            // entonces que lo salte
            if (i === index) { continue; }
            // Sino, si el id del objeto seleccionado
            // es igual al id del elemento de la lista en i
            // entonces el elemento ya se encuentra seleccionado,
            // por lo tanto es invalido
            else if (scope.id === $scope.ayudas_selected[i].id) {
                // $scope.newexpediente.$invalid = true;
                scope.$invalid = true;
                break;
            }
        }

        console.log(scope);

    };

    $scope.add = function() {
        /************ POSSIBLE FIX ****************/
        if ($scope.ayudas_selected[$scope.ayudas_selected.length - 1].id /*&& !$scope.ayudas_selected[$scope.ayudas_selected.length - 1].$invalid*/) {
            $scope.invalid_add = false;
            $scope.ayudas_selected.push({});
        }
        else {
            $scope.invalid_add = true;
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
        $http.get('../referentes').then(
            function(response){
                $scope.referentes = response.data;
                console.log(response.data);
            },
            function(error){}
        );
    },

    checkValidity = function(array) {};

    init();

});
