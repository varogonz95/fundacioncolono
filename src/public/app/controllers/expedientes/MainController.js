
/*
*   Controller for entity 'Expediente'
*/
app.controller('Expedientes_MainController', function ($scope, Expediente, Referente, Ayuda, Region) {

    $scope.selected = {};
    $scope.update = {
        persona: {},
        caso: {},
        ayudas: {
            attachs: [],
            detachs: [],
            updates: []
        }
    };

    $scope.ayudas = Ayuda.all();
    $scope.referentes = Referente.all();

    $scope.estados = [
        { id: 0, name: 'En valoración' },
        { id: 1, name: 'Aprobado' },
        { id: 2, name: 'No aprobado' },
        { id: 3, name: 'Pendiente' },
    ];

    $scope.prioridades = [
        { id: 1, name: 'Baja' },
        { id: 2, name: 'Media' },
        { id: 3, name: 'Alta' }
    ];
    $scope.provincias = Region.provincias();
});
