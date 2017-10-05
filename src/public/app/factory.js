app.factory('Expediente', function (AppResource) {
    return function (optional) {
        if (optional) return AppResource.extends('expedientes' + (optional[0] === '/'? optional : '/' + optional ));
        else return AppResource.extends('expedientes');
    };
});

app.factory('Persona', function (AppResource) {
    return AppResource.extends('personas');
});

app.factory('Referente', function(AppResource){
    return AppResource.extends('referentes');
});

app.factory('Ayuda', function(AppResource){
    return AppResource.extends('ayudas');
});

