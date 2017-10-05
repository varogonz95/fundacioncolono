
/*
*   Controller for entity 'Expediente'
*/
app.controller('Expedientes_MainController', function ($scope, $http, Expediente, Referente, Ayuda, Region) {

    $scope.selected = {};
    $scope.update = {
        persona: {},
        caso: {},
        ayudas: {
            attachs: [],
            detachs: []
        }
    };

    $scope.expedientes = [];
    $scope.ayudas = Ayuda.query();
    $scope.referentes = Referente.query();

    $scope.estados = [
        { id: 0, name: 'En valoración (por defecto)' },
        { id: 1, name: 'Aprobado' },
        { id: 2, name: 'No aprobado' }
    ];

    $scope.prioridades = [
        { id: 1, name: 'Baja' },
        { id: 2, name: 'Media' },
        { id: 3, name: 'Alta' }
    ];

    $scope.provincias = Region.getProvincias();

    $scope.total = 1;
    $scope.page = 1;

    $scope.columns = {
        cedula: true,
        nombre: true,
        apellidos: true,
        prioridad: true,
        estado: true,
        referente: true,
        ayuda: true
    };

});
