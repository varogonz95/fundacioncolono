var app = angular.module('App',['ngResource','ui.bootstrap']);

app.config(['uibPaginationConfig',function(conf){
    conf.previousText="Anterior";
    conf.nextText="Siguiente";
    conf.lastText="Último";
    conf.firstText="Primero";
    conf.boundaryLinks=true;
    conf.directionLinks=false;
    conf.forceEllipses=true;
}]);

app.config(['uibDatepickerPopupConfig', function (conf) {
    conf.altInputFormats = [];
    conf.clearText = 'Limpiar';
    conf.closeText = 'Hecho';
    conf.currentText = 'Hoy';
    conf.placement = 'auto bottom';
}]);

app.config(function ($resourceProvider) {
    $resourceProvider.defaults.actions.save.method = 'PATCH';
    $resourceProvider.defaults.actions.update = { method: 'PUT' };
    $resourceProvider.defaults.actions.post = { method: 'POST'};
});

app.config(function(AppResourceProvider){
    AppResourceProvider.extras = 'fundacioncolono';
});


// SOME BUILT-IN FUNCTIONS
function jQueryToJson(obj, key){
    var data = {}
    obj.find('['+key+']').each(function(index){
        data[this.getAttribute(key)]=this.value;
    });
    return data;
}

function copy(_this, _into = {}, except = []){

    var data = {},
    fails = 0;

    if (except) {
        for (var key in _this) {
            for (var i = 0; i < except.length; i++) { if (key === except[i]) { fails++; } }
            if (fails === 0) { 
                data[key] = _this[key];
                _into[key] = _this[key];
            }
            fails = 0;
        }
    }
    else {
        for (var key in _this) { 
            data[key] = _this[key];
            _into[key] = _this[key];
        }
    }

    return data;
}

function find(key, value, array) {
    for (var i = 0; i < array.length; i++) {
        if(array[i][key] == value){
            return array[i];
        }
    }

    return false;
}

function getIndex(list, object){
    var i = 0,
    found = false;

    for (;i < list.length; i++) {

        if (angular.equals(list[i], object)) {
            found = true;
            break;
        }
    }

    return found? i : -1;
};
