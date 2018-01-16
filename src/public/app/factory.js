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

app.factory('Alert', function (AlertProvider) {

    return {
        notify: function(title, text, type = 'success', timer = 2500){
            swal({
                title: title,
                text: text,
                icon: type,
                buttons: false,
                content: AlertProvider.close,
                timer: timer,
            });
        },

        confirm: function (title, text, type = 'info', buttons = false){
            // returns promise
            return swal({
                title: !text ? null : title,
                text: !text ? title : text,
                content: AlertProvider.close,
                icon: type,
                closeOnClickOutside: false,
                buttons: !buttons ?
                    (type === 'error' ? AlertProvider.dangerbtn :
                     type === 'warning' ? AlertProvider.warningbtn :
                     AlertProvider.buttons) :
                    buttons,
            });
        },

        prompt: function (title, text, content = null, type = null, buttons = false) {
            // returns promise
            return swal({
                title: !text ? null : title,
                text: !text ? title : text,
                icon: type,
                content: content === null ? AlertProvider.promptContent : content,
                buttons: buttons,
            });
        }
    }
});
