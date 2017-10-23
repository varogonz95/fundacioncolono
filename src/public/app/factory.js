app.factory('Expediente', function (AppResource) {
    return function (optional) {
        if (optional) return AppResource.extends('expedientes/:id' + (optional[0] === '/' ? optional : '/' + optional), { id: '@id' });
        else return AppResource.extends('expedientes/:id', {id: '@id'});
    };
});

app.factory('Persona', function (AppResource) {
    return AppResource.extends('personas/:cedula', {cedula: '@cedula'});
});

app.factory('Referente', function(AppResource){
    return AppResource.extends('referentes/:id', {id: '@id'});
});

app.factory('Ayuda', function(AppResource){
    return AppResource.extends('ayudas/:id', {id: '@id'});
});

app.factory('AyudaExpediente', function (AppResource) {
    return AppResource.extends('expedientes/:expedienteId/ayudas/:ayudaId', { expedienteId: '@expedienteId', ayudaId: '@ayudaId' });
});
