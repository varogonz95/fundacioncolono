
app.controller('Expedientes_IndexController', function ($scope, Expediente, Referente, Ayuda, Region, Typeahead, Alert, Modal) {

    var showModal = Modal.init('#show_modal',{
        style:         {'overflow-y': 'hidden', 'bottom': '0'},
        onBeforeShow:  function () { $('body').css('overflow-y', 'hidden'); },
        onBeforeClose: function () { $('body').css('overflow-y', 'auto'); },
    });

    // Allowed search atributes
    $scope.searchable = ['cedula', 'nombre', 'apellidos'];

    $scope.formatter = Typeahead.formatter;
    
    $scope.expedientes = [];
    
    $scope.datePickers = {
        openTo:   false,
        openFrom: false,
    };

    $scope.filter_data = {
        value:          '',
        referente:      [],
        ayuda:          [],
        filter:         null,
        // active:         false,
        filtered:       false,
        one:            false,
        estado:         $scope.estados[0],
        prioridad:      $scope.prioridades[0],
        fecha_creacion: {from: new Date(), to: null},
    };

    $scope.total = 1;
    $scope.page  = 1;
    // $scope.totalpages = 1;

    $scope.sort = {
        relationship: 'persona',
        by:           'cedula',
        order:        true,
    };
    
    $scope.columns = {
        ayuda:          true,
        cedula:         true,
        nombre:         true,
        estado:         true,
        apellidos:      true,
        prioridad:      true,
        referente:      true,
        ubicacion:      true,
        fecha_creacion: true
    };

    // Not supported for Location yet
    $scope.doSort = function (by) {
        $scope.sort.order = ($scope.sort.by === by) ? !$scope.sort.order : true;
        $scope.sort.by = by;

        switch ($scope.sort.by) {
            case 'estado':
            case 'prioridad':
            case 'referentes':
            case 'fecha_creacion':
                $scope.sort.relationship = 'expedientes'
                break;

            default:
                $scope.sort.relationship = 'persona'
                
        }

        console.log($scope.sort);

        $scope.index();
    };

    $scope.filter_init = function(){
        if (!$scope.filter_data.active) {
            $scope.filter_data.referente = $scope.referentes[0];
            $scope.filter_data.ayuda = $scope.ayudas[0];
            $scope.filter_data.active = true;
        }
    };

    $scope.index = function (page = 1) {

        $scope.page = page < 1 ? 1 : page;

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
        else params.search = $scope.search;

        Expediente('all').get(
            params,
            function(response){
                $scope.total       = response.total;
                // $scope.totalpages  = response.pages;
                $scope.expedientes = response.expedientes;
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

        $scope.search          = '',
        $scope.filter_data.one = true;
        $scope.filter_data.filtered = true;
        $scope.index($scope.page);

    };

    $scope.clear = function(){
        $scope.search = null;
    };

    $scope.index();
});
