app.provider('AppResource', function () {

    this.host;
    this.port;
    this.extras;
    this.protocol;

    this.$get = function ($location, $resource) {

        var protocol = this.protocol || $location.protocol(),
            host = this.host || $location.host(),
            port = this.port || $location.port(),
            extras = this.extras || '',

            getTemplate = function (route) {
                var type = typeof route;
                if(type === 'array'){
                    var data = '';
                    for (var i = 0; i < route.length; i++) { data += '/' + route[i]; }
                    return data;
                }
                else if (type === 'string') {
                    return route;
                }
            },

            getUrl = function () { return protocol + '://' + host + ':' + port + '/' + extras; },

            extend = function (route, placeholders) {

                route = (route[0] === '/') ? route : '/' + route;

                var url = getUrl() + getTemplate(route),
                    service = $resource(url, placeholders);

                return {

                    $service: service,

                    create: function (data, success = function () { }, error = function () { }) {
                        return service.create(data, success, error);
                    },

                    save: function (data, success = function () { }, error = function () { }) {
                        return service.save(data, success, error);
                    },

                    // Delete or remove resource
                    delete: function (data, success = function () { }, error = function () { }) {
                        return service.delete(data, success, error);
                    },

                    get: function (data = {}, success = function () { }, error = function () { }) {
                        return service.get(data, success, error);
                    },

                    all: function (success = function () { }, error = function () { }) {
                        return service.query(success, error);
                    },

                    update: function (data, success = function () { }, error = function () { }) {
                        return service.update(data, success, error);
                    }

                };
            };

        return {
            getUrl: getUrl,
            extends: extend
        };
    }
});

app.provider('Territory', function(){
    
    this.resultWrapper;
    this.fields = {
        canton:{},
        distrito:{}
    };
    this.orderby = {};
    this.defaultParameters    = {
        f:                           'pjson',
        time:                        '',
        inSR:                        '',
        outSR:                       '',
        token:                       '',
        units:                       'esriSRUnit_Meter',
        having:                      '',
        returnZ:                     false,
        returnM:                     false,
        geometry:                    '',
        distance:                    '0.0',
        objectIds:                   '',
        sqlFormat:                   'none',
        outFields:                   '',
        spatialRel:                  'esriSpatialRelIntersects',
        resultType:                  'none',
        geometryType:                'esriGeometryEnvelope',
        resultOffset:                '',
        orderByFields:               '',
        returnIdsOnly:               false,
        outStatistics:               '',
        returnGeodetic:              false,
        returnGeometry:              false,
        returnCentroid:              false,
        returnCountOnly:             false,
        multipatchOption:            'xyFootprint',
        returnExtentOnly:            false,
        resultRecordCount:           '',
        geometryPrecision:           '',
        maxAllowableOffset:          '',
        applyVCSProjection:          false,
        datumTransformation:         '',
        returnDistinctValues:        true,
        quantizationParameters:      '',
        groupByFieldsForStatistics:  '',
        returnExceededLimitFeatures: false,
    };

    // this.outFields = 'COD_PROV,COD_CANT,COD_DIST,NOM_PROV,NOM_CANT,NOM_DIST';
    // this.URL       = 'https://services.arcgis.com/LjCtRQt1uf8M6LGR/arcgis/rest/services/Distritos_CR/FeatureServer/0/query';
    
    this.$get = function(){

        var params = this.defaultParameters,
            fields = this.fields,
            orderby = this.orderby,

        distritos = function(provincia, canton){
            params.where = 'COD_PROV=' + provincia + ' AND COD_CANT=' + canton;
            params.outFields = fields.distritos;
            params.orderByFields = orderby.distrito;
            return params;
        }, 
        
        cantones = function (provincia) {
            params.where = 'COD_PROV=' + provincia;
            params.outFields = fields.cantones;
            params.orderByFields = orderby.canton;
            return params;
        },

        all = function (provincia, canton, distrito) {
            params.where = 'COD_PROV=' + provincia + ' AND COD_CANT=' + canton + ' AND COD_DIST=' + distrito;
            params.outFields = fields.all;
            // console.log(params.where);
            return params;
        };

        return {
            wrapper:    this.resultWrapper,
            fields: fields,
            parameters: params,
            all:        all,
            cantones:   cantones,
            distritos:  distritos,
            url:        this.URL,
            urls: {
                // provincia:,
                canton:   'https://services.arcgis.com/LjCtRQt1uf8M6LGR/arcgis/rest/services/Cantones_CR/FeatureServer/0/query',
                distrito: 'https://services.arcgis.com/LjCtRQt1uf8M6LGR/arcgis/rest/services/Distritos_CR/FeatureServer/0/query',
            },
        };
    };
    
    // this.cantonesOutFields = ['COD_PROV', 'COD_CANT', 'NOM_CANT_1'];
    // this.cantonesUrl  = 'https://services.arcgis.com/LjCtRQt1uf8M6LGR/arcgis/rest/services/Cantones_CR/FeatureServer/0';
    // this.distritosUrl = 'https://services.arcgis.com/LjCtRQt1uf8M6LGR/arcgis/rest/services/Distritos_CR/FeatureServer/0';
});

app.provider('AlertProvider', function () {

    this.$get = function () {

        var buttons = this.buttons || {
                cancel: {
                    text: 'Cancelar',
                    value: false,
                    visible: true,
                    closeModal: true
                },
                confirm: {
                    text: 'Confirmar',
                    value: true,
                    visible: true,
                    closeModal: true
                },
            },
            promptContent = this.promptContent || {
                element: 'input',
                attributes: {type: 'text'},
            },
            closebtn = {
                element: $.parseHTML('<button class="swal-close" title="Cerrar" onclick="swal.setActionValue({confirm: null,cancel: null});swal.close()">\u00D7</button>')[0],
            },
            //! *** Notice that angular.merge is deprecated, but functional in this case ***
            dangerbtn = angular.merge({ confirm: { className: 'swal-button--danger' } }, buttons);
            warningbtn = angular.merge({ confirm: { className: 'swal-button--warning' } }, buttons);

        return {
            buttons: buttons,
            promptContent: promptContent,
            close: closebtn,
            dangerbtn: dangerbtn,
            warningbtn: warningbtn,
        }
    }
});


