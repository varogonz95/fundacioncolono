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

                    // Get one resource
                    get: function (data = {}, success = function () { }, error = function () { }) {
                        return service.get(data, success, error);
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

                    // insert or update a model by passing its id and model
                    save: function (model = {}, id = null, success = function () { }, error = function () { }) {
                        return id === null?
                        // Insert
                        $resource(getUrl() + route, null).save(model, success, error) :
                        // Update
                        $resource(getUrl() + route + '/' + id, null, { 'save': { method: 'PATCH' } }).save(model, success, error);
                    },

                    // Delete or remove resource
                    delete: function (data = {}, success = function () { }, error = function () { }) {
                        return service.delete(data, success, error);                        
                    },

                    find: function (data, success = function () { }, error = function () { }) {
                        return service.get(data, success, error);
                    },

                    all: function (data, success = function () { }, error = function () { }) {
                        return service.query(data, success, error);
                    },

                    update: function (data, success = function () { }, error = function () { }) {
                        return service.save(data, success, error);                        
                    }

                };
            };

        return {
            getUrl: getUrl,
            extends: extend
        };
    }
});