app.factory('Expediente', function (AppResource) {
    return function (optional) {
        if (optional) return AppResource.extends('expedientes/:id' + (optional[0] === '/' ? optional : '/' + optional), { id: '@id' });
        else return AppResource.extends('expedientes/:id', {id: '@id'});
    };
});

app.factory('Persona', function (AppResource) {
    return AppResource.extends('personas/:cedula', {cedula: '@cedula'});
});

app.factory('Usuario', function (AppResource) {
    return AppResource.extends('usuarios/:id', {id: '@id'});
});

app.factory('Referente', function(AppResource){
    return AppResource.extends('referentes/:id', {id: '@id'});
});

app.factory('Ayuda', function(AppResource){
    return AppResource.extends('ayudas/:id', {id: '@id'});
});

app.factory('AyudaExpediente', function (AppResource) {
    return AppResource.extends('expedientes/:id/ayudas', { id: '@id'});
});
app.factory('Inspector', function (AppResource) {
    return function (optional) {
      if (optional) return AppResource.extends('inspectores/:id' + (optional[0] === '/' ? optional : '/' + optional), { id: '@id' });
      else return AppResource.extends('inspectores/:id', {id: '@id'});
    };
});

app.factory('Alert', function (ConfirmAlert, NotifyAlert /* , PromptAlert */) {

    return {
        notify: function (title, text, type = 'info', timer = 2500) {
            return swal(angular.extend({titleText: title, text: text, type: type, timer: timer}, NotifyAlert.config));
        },

        confirm: function (title, text, type = 'question') {
            return swal(angular.extend({titleText: title, text: text, type: type}, ConfirmAlert.setButtonColor(type)));
        },

        closed: function(dismiss){
            if (dismiss) return dismiss === 'esc' || dismiss === 'cancel' || dismiss === 'close' || dismiss === 'overlay';
            return false;
        }

        //Prompt alert here...
    };

});