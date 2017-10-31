app.provider('AppResource', function () {

    this.$get = function ($location, $resource) {

        var protocol = this.protocol || $location.protocol(),
            host = this.host || $location.host(),
            port = this.port || $location.port(),
            extras = this.extras || '',

            queryData = function (data, append) {

                var params = '',
                    data_params = {};

                if (!append) {
                    for (var key in data) {
                        params += '/:' + key;
                        data_params[key] = '@' + key;
                    }
                }

                return { params: params, data_params: data_params };
            },

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

                    create: function (data = {}, success = function () { }, error = function () { }) {
                        return service.create(data, success, error);
                    },

                    save: function (data = {}, success = function () { }, error = function () { }) {
                        return service.save(data, success, error);
                    },

                    // Delete or remove resource
                    delete: function (data = {}, success = function () { }, error = function () { }) {
                        return service.delete(data, success, error);                        
                    },

                    get: function (data, success = function () { }, error = function () { }) {
                        return service.get(data, success, error);
                    },

                    all: function (data, success = function () { }, error = function () { }) {
                        return service.query(data, success, error);
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
            dangerbtn = angular.merge({confirm: {className: 'swal-button--danger'}}, buttons);

        return {
            buttons: buttons,
            promptContent: promptContent,
            close: closebtn,
            dangerbtn: dangerbtn,
        }
    }
});