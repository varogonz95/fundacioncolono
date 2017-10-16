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

            getUrl = function () { return protocol + '://' + host + ':' + port + '/' + extras; },

            extend = function (route) {

                route = (route[0] === '/') ? route : '/' + route;

                return {

                    // Get one resource
                    get: function (data = {}, append = false, success = function () { }, error = function () { }) {
                        var query = queryData(data, append);
                        return $resource(getUrl() + route + query.params, (append ? undefined : query.data_params)).get(data, success, error);
                    },

                    // Get list of resources
                    query: function (success = function(){}, data = {}) {
                        var params = '';

                        if (!angular.equals(data, {})) {
                            for (var key in data) {
                                params += '&' + key + '=' + data[key];
                            }
                            params = '?' + params.substring(1, params.length);
                        }
                        return $resource(getUrl() + route, data).query(success);
                    },

                    // update a model by passing its id and model itself
                    update: function (id, model = {}, success = function () { }, error = function () { }) {
                        id = '/' + id;
                        return $resource(getUrl() + route + id, null, { 'save': { method: 'PUT' } }).save(model, success, error);
                    },

                    // Delete or remove resource
                    delete: function (data = {}, success = function () { }, error = function () { }) {
                        var query = queryData(data, false);
                        return $resource(getUrl() + route + query.params).delete(data, success, error);
                    }
                };
            };

        return {
            getUrl: getUrl,
            extends: extend
        };
    }
});

