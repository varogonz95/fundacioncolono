
/*
*   Controller for entity 'Expediente'
*/
app.controller('Expedientes_IndexController', function ($scope, Expediente, Referente, Ayuda, Region) {

    var showModal = $('#show_modal').animatedModal({
        onBeforeShow: function () { $('body').css('overflow-y', 'hidden'); },
        onBeforeClose: function () { $('body').css('overflow-y', 'auto'); },
    });

    $scope.selected = {};
    $scope.expedientes = [];

    $scope.total = 1;
    $scope.page = 1;

    $scope.sort = {
        by: 'cedula',
        order: true,
        filter: function () { }
    };
    // Not supported for Location yet
    $scope.doSort = function (by) {
        $scope.sort.order = ($scope.sort.by === by) ? !$scope.sort.order : true;
        $scope.sort.by = by;

        $scope.index();
    };

    $scope.columns = {
        cedula: true,
        nombre: true,
        apellidos: true,
        prioridad: true,
        estado: true,
        referente: true,
        ayuda: true
    };

    $scope.index = function (page = 1, params = {}) {

        $scope.page = (page < 1) ? 1 : page;

        Expediente('all').get(
            angular.extend({
                page: page,
                by: $scope.sort.by,
                order: ($scope.sort.order ? 'asc' : 'desc')},
                params),
            true,
            function(response){
                $scope.expedientes = response.expedientes;
                $scope.total = response.total;
            });
    };

    $scope.show = function (obj) {
        obj.editable = false;
        obj.isSelected = true;
        obj.persona.editable = false;
        $scope.selected.isSelected = false;
        // scope.ayudas.editable = false;

        var regions = obj.persona.ubicacion.split('/');

        // Get Provincia from list and set to persona
        obj.persona.provincia = Region.find($scope.provincias, 'cod', regions[0]);

        Region.getCantones(obj.persona.provincia.cod).then(function (response) {
            $scope.cantones = Region.toList(response.data);
            obj.persona.canton = Region.find($scope.cantones, 'cod', regions[1]);

            Region.getDistritos(obj.persona.provincia.cod, obj.persona.canton.cod).then(function (response) {
                $scope.distritos = Region.toList(response.data);
                obj.persona.distrito = Region.find($scope.distritos, 'cod', regions[2]);
            });
        });

        $scope.selected = obj;
        showModal.show();
    };

    $scope.delete = function () {
        if (confirm('¿Realmente desea eliminar este expediente?\nEsta acción es irreversible.'))
            Expediente().delete({id: $scope.selected.persona.cedula},
                function (response) {
                    if (response.status) {
                        showModal.close();
                        $scope.expedientes.splice(getIndex($scope.expedientes, $scope.selected), 1);
                        $scope.selected = {};

                        if ($scope.page !== response.last && $scope.expedientes.length > 0) { $scope.index($scope.page); }
                        else if ($scope.expedientes.length === 0) { $scope.index($scope.page - 1); }

                        alert('Deleted successfully');
                    }
                },
                function (error) {alert(error.message);} 
            );
    }

    $scope.index();
});
