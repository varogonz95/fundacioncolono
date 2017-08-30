var app = angular.module('App',['ngRoute','ngSanitize','ui.bootstrap']);

/*
*   Routes for SPA control and dynamic content management
*/
app.config(function($routeProvider){
    $routeProvider

    /*
    *   Routing for root location
    */
    .when("/",{templateUrl:'./home',controller:function(){$('#sectionheader').text('Actividad reciente');}})

    /*
    *   Routing for 'Person'
    */
    .when("/person/create",{templateUrl:'./person/create', controller:'PersonaController'})
    .when("/person/index",{templateUrl:'./person/index', controller:'PersonaController'})

    /*
    *   Routing for 'Records'
    */
    .when("/records/create",{templateUrl:'./records/create', controller:'ExpedienteController'})
    .when("/records/index",{templateUrl:'./records/index', controller:'ExpedienteController'});
});

app.config(['uibPaginationConfig',function(conf){
    conf.previousText="Anterior";
    conf.nextText="Siguiente";
    conf.lastText="Último";
    conf.firstText="Primero";
    conf.boundaryLinks=true;
    conf.directionLinks=false;
    conf.forceEllipses=true;
}]);

app.controller('Main',function($scope,$compile,$templateRequest,$http){
    var compile = function(config,template){
        var element = angular.element(config.target);
        if(!config.replace){
            if(config.emptyFirst){element.empty();}
            element.append($compile(template)(config.scope));
        }
        else {element.replaceWith($compile(template)(config.scope));}
    },
    getLocationInfo = function(p, c, d){
        var provincia = {code: p, data: ''},
        canton = {code: c, data: ''},
        distrito = {code: d, data: ''};

        // Added switch to prevent additional and obvious request responses
        switch (p) {
            case '1':
            provincia.data = 'San José';
            break;

            case '2':
            provincia.data = 'Alajuela';
            break;

            case '3':
            provincia.data = 'Cartago';
            break;

            case '4':
            provincia.data = 'Heredia';
            break;

            case '5':
            provincia.data = 'Guanacaste';
            break;

            case '6':
            provincia.data = 'Puntarenas';
            break;

            case '7':
            provincia.data = 'Limón';
            break;

        }

        $http.get('https://ubicaciones.paginasweb.cr/provincia/'+p+'/cantones.json').then(function(response){
            canton.data = response.data[c];
            $http.get('https://ubicaciones.paginasweb.cr/provincia/'+p+'/canton/'+c+'/distritos.json').then(function(response){
                distrito.data = response.data[d];
            });
        });

        return {provincia, canton, distrito};
    },
    selectLocation = function(p, c, scope){
        if(0 !== parseInt(p)){
            if (0 === parseInt(c)) {
                console.log('true 1st');
                scope.canton = '0';
                scope.distrito = '0';
                $http.get('https://ubicaciones.paginasweb.cr/provincia/'+p+'/cantones.json').then(
                    function(response){scope.cantones = response.data;}
                );
            }
            else{
                console.log('true 2nd');
                $http.get('https://ubicaciones.paginasweb.cr/provincia/'+p+'/canton/'+c+'/distritos.json').then(
                    function(response){scope.distritos = response.data;}
                );
            }
        }
        else {
            scope.provincia = '0';
            scope.canton = '0';
            scope.distrito = '0';
            scope.cantones = [];
            scope.distritos = [];
        }
    },
    persistData = {};

    $scope.persist={
        set:function(key, value, overwrite){
            if(!persistData[key]){persistData[key]=value;}
            else {if (overwrite) {persistData[key]=value;}}
        },
        get:function(key, def){return (!persistData[key])? def : persistData[key];}
    };
    $scope.modal={footer:true};
    $scope.content={
        remote:false,
        emptyFirst:false,
        replace:false,
        reset:function(){
            this.remote=false;
            this.emptyFirst=false;
            this.replace=false;
            this.template=null;
            this.target=null;
        },
        compile:function(){
            if(!this.remote){
                compile(this,this.template);
                //this.reset();
            }
            else {
                $templateRequest(this.template).then(function(html){compile($scope.content, html);});
            }
        }
    };
    $scope.location = {
        getInfo: getLocationInfo,
        select: selectLocation
    }
});

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
            for (var i in except) {
                if(key !== except[i] || !key){_into[key]=_this[key];}
            }
        }
        else{
            _into[key]=_this[key];
        }
    }
    return _into;
}
