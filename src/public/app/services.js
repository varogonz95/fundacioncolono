
app.service('Typeahead', function(){
    this.formatter = function(model, list, select, label){
        for (var i = 0; i < list.length; i++) {
            if (model === list[i][select]) {
                return list[i][label];
            }
        }
    };
});

app.service('Region', function($http){

    var provincias = [
        {cod: '1', name: 'San José'},
        {cod: '2', name: 'Alajuela'},
        {cod: '3', name: 'Cartago'},
        {cod: '4', name: 'Heredia'},
        {cod: '5', name: 'Guanacaste'},
        {cod: '6', name: 'Puntarenas'},
        {cod: '7', name: 'Limón'}
    ];

    this.getProvincias = function() {
        return provincias;
    };

    this.getCantones = function(provincia) {
        return $http.get('https://ubicaciones.paginasweb.cr/provincia/'+provincia+'/cantones.json');
    };
    
    this.getDistritos = function(provincia, canton) {
        return $http.get('https://ubicaciones.paginasweb.cr/provincia/' + provincia + '/canton/' + canton + '/distritos.json');
    };

    this.find = function(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if(array[i][key] === value){
                return array[i];
            }
        }
    }

    this.toList = function(data) {
        var list = [];

        for (var key in data) {
            list.push({cod: key, name: data[key]});
        }

        return list;
    };
});

app.service('Modal', function(){

    var instance;

    this.init = function(selector, settings = {}){
        instance = $(selector).animatedModal(settings);
        return instance;
    };

    // etc...

    this.getInstance = function(){
        return instance;
    };

});
