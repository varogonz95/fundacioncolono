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

function mergeObjs(_this, _into, except){
    for (var key in _this) {
        if(except){
            for (var i = 0; i < except.length; i++) {
                array[i]
            }
            for (var i in except) {
                if(key !== except[i] || !key){
                    _into[key]=_this[key];
                    console.log('key ['+key+'] copied');
                }
                else {
                    console.log('key ['+key+'] not copied');
                }
            }
        }
        else{
            _into[key]=_this[key];
        }
    }
    return _into;
}

function getIndex(list, object){
    var i = 0;
    for (;i < list.length; i++) {
        if (list[i] === object) {break;}
    }
    return i-1;
};
