var app = angular.module('App',['ngRoute','ngSanitize','ui.bootstrap']);

app.config(['uibPaginationConfig',function(conf){
    conf.previousText="Anterior";
    conf.nextText="Siguiente";
    conf.lastText="Último";
    conf.firstText="Primero";
    conf.boundaryLinks=true;
    conf.directionLinks=false;
    conf.forceEllipses=true;
}]);

function jQueryToJson(obj, key){
    var data = {}
    obj.find('['+key+']').each(function(index){
        data[this.getAttribute(key)]=this.value;
    });
    return data;
}

function copy(_this, _into, except){

    var data = {},
    fails = 0;

    if (except) {
        for (var key in _this) {
            for (var i = 0; i < except.length; i++) { if (key === except[i]) { fails++; } }
            if (fails === 0) { data[key] = _this[key]; }
            fails = 0;
        }
    }
    else {
        for (var key in _this) { data[key] = _this[key]; }
    }

    return data;
}

function getIndex(list, object){
    var i = 0;

    for (;i < list.length; i++) {
        if (list[i] === object) {
            break;
        }
    }
    return i;
};
