<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspector extends Model{
    public $timestamps = false;

    public $table = 'inspectores';

    public $filterable = ['persona_fk', 'usuario_fk', 'activo'];

    public function persona(){
        return $this->belongsTo('App\Models\Persona', 'persona_fk');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\Usuario', 'usuario_fk');
    }

    public function visitas(){
        return $this->hasMany('App\Models\Visita', 'inspector_fk');
    }
}
