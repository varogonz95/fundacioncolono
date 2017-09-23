
app.factory('Referente', function($resource, AppResource){
    return function (params = '') {
        params = (params[0] === '/')? params.substring(1, params.length) : params;
        return $resource(AppResource.getUrl()+'/referentes'+params);
    }
});

app.factory('Ayuda', function($resource, AppResource){
    return function (params = '') {
        params = (params[0] === '/')? params.substring(1, params.length) : params;
        return $resource(AppResource.getUrl()+'/ayudas'+params);
    }
});
