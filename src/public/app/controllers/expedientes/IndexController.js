
app.controller('Expedientes_IndexController', function ($scope, Expediente, Referente, Ayuda, Region, Typeahead, Alert, Modal) {

    var showModal = Modal.init('#show_modal',{
        style:{'overflow-y':'hidden', 'bottom': '0'},
        onBeforeShow: function () { $('body').css('overflow-y', 'hidden'); },
        onBeforeClose: function () { $('body').css('overflow-y', 'auto'); },
    });

    $scope.formatter = Typeahead.formatter;
    
    $scope.selected = {};
    
    $scope.expedientes = [];
    
    $scope.datePickers = {
        openFrom:false,
        openTo:false,
    };

    $scope.filter_data = {
        active: false,
        filter: null,
        filtered: false,
        prioridad: $scope.prioridades[0],
        estado: $scope.estados[0],
        referente: [],
        ayuda: [],
        fecha_creacion: {from: new Date(), to: null},
        value: ''
    };

    $scope.total = 1;
    $scope.page = 1;

    $scope.sort = {
        by: 'cedula',
        order: true
    };
    
    $scope.columns = {
        cedula: true,
        nombre: true,
        apellidos: true,
        prioridad: true,
        estado: true,
        referente: true,
        ayuda: true,
        fecha_creacion: true
    };

    // Not supported for Location yet
    $scope.doSort = function (by) {
        $scope.sort.order = ($scope.sort.by === by) ? !$scope.sort.order : true;
        $scope.sort.by = by;

        $scope.index();
    };

    $scope.filter_init = function(){
        if (!$scope.filter_data.active) {
            $scope.filter_data.referente = $scope.referentes[0];
            $scope.filter_data.ayuda = $scope.ayudas[0];
            $scope.filter_data.active = true;
        }
    };

    $scope.index = function (page = 1, params = {}) {

        $scope.page = (page < 1) ? 1 : page;

        Expediente('all').get(
            angular.extend({
                page: page,
                by: $scope.sort.by,
                order: ($scope.sort.order ? 'asc' : 'desc')},
                params),
            function(response){
                $scope.expedientes = response.expedientes;
                $scope.total = response.total;
            });
    };

    $scope.show = function (obj) {
        obj.editable = false;
        obj.isSelected = true;
        obj.persona.editable = false;
        $scope.selected.isSelected = obj === $scope.selected;
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

        if (obj.archivado)
            Alert.notify(
                'Expediente archivado', 
                'No se pueden realizar cambios al expediente mientras esté archivado. ', 
                'info',
                3000
            );
    };

    $scope.toStandardDate = function(date){
        return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
    };

    $scope.filter_pichudo = function () {

        var data = jQueryToJson($('#filter'), 'name');

        Expediente('test').get(
            data,
            function (response) {
                $scope.filter_data.filtered = true;
                // $scope.filter_data.filter = null;
                $scope.expedientes = response.expedientes;
                $scope.total = response.total;
            }
        );
    };

    $scope.index();
});
